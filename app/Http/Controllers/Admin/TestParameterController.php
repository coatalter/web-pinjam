<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestParameter;
use Illuminate\Http\Request;

class TestParameterController extends Controller
{
    public function index(Request $request)
    {
        $query = TestParameter::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $parameters = $query->orderBy('category')->orderBy('name')->paginate(15)->appends(request()->query());
        return view('admin.test-parameters.index', compact('parameters'));
    }

    public function create()
    {
        return view('admin.test-parameters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
            'method' => 'nullable|string|max:255',
            'category' => 'required|in:soil,water,plant_tissue',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');
        TestParameter::create($validated);

        return redirect()->route('admin.test-parameters.index')
            ->with('success', 'Parameter pengujian berhasil ditambahkan.');
    }

    public function edit(TestParameter $testParameter)
    {
        return view('admin.test-parameters.edit', compact('testParameter'));
    }

    public function update(Request $request, TestParameter $testParameter)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
            'method' => 'nullable|string|max:255',
            'category' => 'required|in:soil,water,plant_tissue',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $testParameter->update($validated);

        return redirect()->route('admin.test-parameters.index')
            ->with('success', 'Parameter pengujian berhasil diperbarui.');
    }

    public function destroy(TestParameter $testParameter)
    {
        $testParameter->delete();
        return redirect()->route('admin.test-parameters.index')
            ->with('success', 'Parameter pengujian berhasil dihapus.');
    }
}
