<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PracticumRegistration;
use App\Models\PracticumReport;
use Illuminate\Http\Request;

class PracticumAdminController extends Controller
{
    /**
     * List all practicum registrations.
     */
    public function index(Request $request)
    {
        $query = PracticumRegistration::with(['user', 'room']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('course_name', 'like', "%{$request->search}%")
                    ->orWhere('class_name', 'like', "%{$request->search}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderByDesc('schedule_date')->paginate(15)->appends(request()->query());
        return view('admin.practicum.index', compact('registrations'));
    }

    /**
     * Show registration detail.
     */
    public function show(PracticumRegistration $practicum)
    {
        $practicum->load(['user', 'room', 'equipment', 'reports.submitter']);
        return view('admin.practicum.show', compact('practicum'));
    }

    /**
     * Update status of practicum.
     */
    public function updateStatus(Request $request, PracticumRegistration $practicum)
    {
        $request->validate([
            'status' => 'required|in:registered,in_progress,completed',
        ]);

        $practicum->update(['status' => $request->status]);
        return back()->with('success', 'Status praktikum berhasil diperbarui.');
    }

    /**
     * Reports listing (all practicum reports).
     */
    public function reports(Request $request)
    {
        $query = PracticumReport::with(['practicumRegistration.user', 'practicumRegistration.room', 'submitter']);

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $reports = $query->orderByDesc('submitted_at')->paginate(15)->appends(request()->query());
        return view('admin.practicum.reports', compact('reports'));
    }

    /**
     * Export practicum report data to Excel.
     */
    public function export(Request $request)
    {
        $registrations = PracticumRegistration::with(['user', 'room', 'equipment', 'reports'])
            ->orderByDesc('schedule_date')
            ->get();

        // Simple CSV export (no external package dependency)
        $filename = 'laporan_praktikum_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No',
                'Mata Kuliah',
                'Kelas',
                'Dosen',
                'Semester',
                'Tahun Akademik',
                'Ruangan',
                'Tanggal',
                'Waktu Mulai',
                'Waktu Selesai',
                'Jumlah Mahasiswa',
                'Status',
                'Pendaftar',
                'Alat Digunakan',
            ]);

            foreach ($registrations as $i => $reg) {
                $equipmentList = $reg->equipment->map(fn($e) => "{$e->name} ({$e->pivot->quantity})")->implode(', ');
                fputcsv($file, [
                    $i + 1,
                    $reg->course_name,
                    $reg->class_name,
                    $reg->lecturer_name,
                    $reg->semester,
                    $reg->academic_year,
                    $reg->room?->name ?? '-',
                    $reg->schedule_date->format('Y-m-d'),
                    $reg->start_time,
                    $reg->end_time,
                    $reg->num_students,
                    $reg->status_label,
                    $reg->user?->name ?? '-',
                    $equipmentList ?: '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
