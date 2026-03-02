<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestRequest;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;

class TestRequestAdminController extends Controller
{
    /**
     * List all test requests (admin view).
     */
    public function index(Request $request)
    {
        $query = TestRequest::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('request_code', 'like', "%{$request->search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            });
        }

        $requests = $query->orderByDesc('created_at')->paginate(15)->appends(request()->query());
        return view('admin.test-requests.index', compact('requests'));
    }

    /**
     * Show a specific test request detail.
     */
    public function show(TestRequest $testRequest)
    {
        $testRequest->load(['user', 'tester', 'reviewer', 'testResults.testParameter']);
        return view('admin.test-requests.show', compact('testRequest'));
    }

    /**
     * Payment verification listing.
     */
    public function payments(Request $request)
    {
        $requests = TestRequest::with('user')
            ->whereIn('status', ['payment_uploaded', 'payment_verified'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.test-requests.payments', compact('requests'));
    }

    /**
     * Verify payment for a test request.
     */
    public function verifyPayment(TestRequest $testRequest)
    {
        if ($testRequest->status !== 'payment_uploaded') {
            return back()->with('error', 'Status tidak valid untuk verifikasi pembayaran.');
        }

        $testRequest->update([
            'status' => 'payment_verified',
            'payment_verified_at' => now(),
            'payment_verified_by' => auth()->id(),
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Assign tester and reviewer.
     */
    public function assign(Request $request, TestRequest $testRequest)
    {
        $validated = $request->validate([
            'assigned_tester_id' => 'required|exists:users,id',
            'assigned_reviewer_id' => 'required|exists:users,id',
        ]);

        // Create test result rows for each requested parameter
        if ($testRequest->status === 'payment_verified') {
            $parameters = $testRequest->parameters ?? [];
            foreach ($parameters as $paramId) {
                TestResult::firstOrCreate([
                    'test_request_id' => $testRequest->id,
                    'test_parameter_id' => $paramId,
                ], [
                    'status' => 'pending',
                ]);
            }
        }

        $testRequest->update(array_merge($validated, [
            'status' => 'in_testing',
        ]));

        return back()->with('success', 'Penguji dan reviewer berhasil di-assign.');
    }

    /**
     * Approve the final report.
     */
    public function approveReport(TestRequest $testRequest)
    {
        if ($testRequest->status !== 'in_review') {
            return back()->with('error', 'Status tidak valid untuk approval laporan.');
        }

        $testRequest->update([
            'status' => 'report_approved',
            'report_approved_by' => auth()->id(),
            'report_approved_at' => now(),
        ]);

        return back()->with('success', 'Laporan pengujian disetujui.');
    }

    /**
     * Mark as completed (report sent via email).
     */
    public function complete(TestRequest $testRequest)
    {
        if ($testRequest->status !== 'report_approved') {
            return back()->with('error', 'Status tidak valid.');
        }

        $testRequest->update([
            'status' => 'completed',
            'report_sent_at' => now(),
        ]);

        return back()->with('success', 'Laporan telah dikirim. Permohonan selesai.');
    }

    /**
     * Upload report file (admin).
     */
    public function uploadReport(Request $request, TestRequest $testRequest)
    {
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('report_file')->store('reports/pengujian', 'public');
        $testRequest->update(['report_file' => $path]);

        return back()->with('success', 'File laporan berhasil diunggah.');
    }
}
