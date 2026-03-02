<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Room;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('room');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $equipment = $query->orderBy('name')->paginate(15)->appends(request()->query());
        return view('admin.equipment.index', compact('equipment'));
    }

    public function create()
    {
        $rooms = Room::active()->where('scope', 'lab-terpadu')->get();
        return view('admin.equipment.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:equipment,code',
            'description' => 'nullable|string',
            'room_id' => 'nullable|exists:rooms,id',
            'category' => 'required|in:general,soil,water,plant_tissue',
            'is_available' => 'boolean',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
        ]);

        $validated['is_available'] = $request->has('is_available');
        Equipment::create($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load('room', 'practicumRegistrations');
        return view('admin.equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        $rooms = Room::active()->where('scope', 'lab-terpadu')->get();
        return view('admin.equipment.edit', compact('equipment', 'rooms'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:equipment,code,' . $equipment->id,
            'description' => 'nullable|string',
            'room_id' => 'nullable|exists:rooms,id',
            'category' => 'required|in:general,soil,water,plant_tissue',
            'is_available' => 'boolean',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $equipment->update($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('admin.equipment.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
