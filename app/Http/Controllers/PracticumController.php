<?php

namespace App\Http\Controllers;

use App\Models\PracticumRegistration;
use App\Models\PracticumReport;
use App\Models\Equipment;
use App\Models\Room;
use Illuminate\Http\Request;

class PracticumController extends Controller
{
    /**
     * List user's practicum registrations.
     */
    public function index()
    {
        $registrations = PracticumRegistration::with(['room'])
            ->where('user_id', auth()->id())
            ->orderByDesc('schedule_date')
            ->paginate(10);

        return view('practicum.index', compact('registrations'));
    }

    /**
     * Show practicum registration form.
     */
    public function create()
    {
        $rooms = Room::active()->where('scope', 'lab-terpadu')->get();
        $equipment = Equipment::available()->orderBy('name')->get();

        return view('practicum.create', compact('rooms', 'equipment'));
    }

    /**
     * Store new practicum registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'class_name' => 'required|string|max:100',
            'lecturer_name' => 'required|string|max:255',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'schedule_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'num_students' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'equipment' => 'nullable|array',
            'equipment.*.id' => 'exists:equipment,id',
            'equipment.*.quantity' => 'integer|min:1',
        ]);

        $registration = PracticumRegistration::create([
            'user_id' => auth()->id(),
            'course_name' => $validated['course_name'],
            'class_name' => $validated['class_name'],
            'lecturer_name' => $validated['lecturer_name'],
            'semester' => $validated['semester'],
            'academic_year' => $validated['academic_year'],
            'room_id' => $validated['room_id'],
            'schedule_date' => $validated['schedule_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'num_students' => $validated['num_students'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'registered',
        ]);

        // Attach equipment if provided
        if (!empty($validated['equipment'])) {
            foreach ($validated['equipment'] as $item) {
                if (!empty($item['id'])) {
                    $registration->equipment()->attach($item['id'], [
                        'quantity' => $item['quantity'] ?? 1,
                    ]);
                }
            }
        }

        return redirect()->route('practicum.show', $registration)
            ->with('success', 'Pendaftaran praktikum berhasil.');
    }

    /**
     * Show practicum detail.
     */
    public function show(PracticumRegistration $practicum)
    {
        if ($practicum->user_id !== auth()->id()) {
            abort(403);
        }

        $practicum->load(['room', 'equipment', 'reports.submitter']);
        return view('practicum.show', compact('practicum'));
    }

    /**
     * Submit a practicum report.
     */
    public function submitReport(Request $request, PracticumRegistration $practicum)
    {
        if ($practicum->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'report_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        $path = $request->file('report_file')->store('reports/praktikum', 'public');

        PracticumReport::create([
            'practicum_registration_id' => $practicum->id,
            'title' => $validated['title'],
            'report_file' => $path,
            'submitted_by' => auth()->id(),
            'submitted_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Laporan praktikum berhasil diunggah.');
    }
}
