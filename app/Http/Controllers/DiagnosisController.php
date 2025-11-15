<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diagnoses = Diagnosis::orderBy('type')->orderBy('order')->paginate(15);
        return view('diagnoses.index', compact('diagnoses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diagnoses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:primary,secondary,tertiary',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        Diagnosis::create($validated);

        return redirect()->route('diagnoses.index')
            ->with('success', 'Diagnosis created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diagnosis $diagnosis)
    {
        return view('diagnoses.show', compact('diagnosis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diagnosis $diagnosis)
    {
        return view('diagnoses.edit', compact('diagnosis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diagnosis $diagnosis)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:primary,secondary,tertiary',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $diagnosis->update($validated);

        return redirect()->route('diagnoses.index')
            ->with('success', 'Diagnosis updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();

        return redirect()->route('diagnoses.index')
            ->with('success', 'Diagnosis deleted successfully.');
    }
}
