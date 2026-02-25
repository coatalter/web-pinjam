<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('room')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('is_active', true)->orderBy('name')->get();

        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check for time conflicts
        $conflict = Booking::where('room_id', $validated['room_id'])
            ->where('booking_date', $validated['booking_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($validated) {
                $q->where(function ($q2) use ($validated) {
                    $q2->where('start_time', '<', $validated['end_time'])
                        ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ruangan sudah di-booking pada tanggal dan jam tersebut. Silakan pilih waktu lain.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function show(Booking $booking)
    {
        // Ensure users can only see their own bookings
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['room', 'approver']);

        return view('bookings.show', compact('booking'));
    }
}
