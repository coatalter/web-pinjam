<?php

namespace App\Http\Controllers;

use App\Models\TestRequest;
use App\Models\TestParameter;
use Illuminate\Http\Request;

class TestRequestController extends Controller
{
    /**
     * List user's test requests with tracking info.
     */
    public function index()
    {
        $requests = TestRequest::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('test-requests.index', compact('requests'));
    }

    /**
     * Show form to create a new test request.
     */
    public function create()
    {
        $parameters = TestParameter::active()
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('test-requests.create', compact('parameters'));
    }

    /**
     * Store new test request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sample_type' => 'required|in:tanah,air,jaringan_tanaman',
            'sample_description' => 'nullable|string|max:1000',
            'num_samples' => 'required|integer|min:1|max:100',
            'parameters' => 'required|array|min:1',
            'parameters.*' => 'exists:test_parameters,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $testRequest = TestRequest::create([
            'user_id' => auth()->id(),
            'request_code' => TestRequest::generateCode(),
            'sample_type' => $validated['sample_type'],
            'sample_description' => $validated['sample_description'] ?? null,
            'num_samples' => $validated['num_samples'],
            'parameters' => $validated['parameters'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending_payment',
        ]);

        return redirect()->route('test-requests.show', $testRequest)
            ->with('success', 'Permohonan pengujian berhasil dibuat. Silakan upload bukti pembayaran.');
    }

    /**
     * Show test request detail & tracking.
     */
    public function show(TestRequest $testRequest)
    {
        // Ensure user can only view their own requests
        if ($testRequest->user_id !== auth()->id()) {
            abort(403);
        }

        $testRequest->load(['testResults.testParameter']);

        // Get parameter details
        $parameterDetails = TestParameter::whereIn('id', $testRequest->parameters ?? [])
            ->get();

        return view('test-requests.show', compact('testRequest', 'parameterDetails'));
    }

    /**
     * Upload payment proof.
     */
    public function uploadPayment(Request $request, TestRequest $testRequest)
    {
        if ($testRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($testRequest->status, ['pending_payment', 'payment_uploaded'])) {
            return back()->with('error', 'Bukti pembayaran tidak bisa diupload pada status ini.');
        }

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        $testRequest->update([
            'payment_proof' => $path,
            'status' => 'payment_uploaded',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
