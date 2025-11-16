<?php

namespace App\Http\Controllers;

use App\Models\WeightReading;
use App\Models\Patient;
use Illuminate\Http\Request;

class WeightReadingController extends Controller
{
    /**
     * Display a listing of all weight readings.
     */
    public function all()
    {
        $readings = WeightReading::with('patient')
            ->latest('date')
            ->latest('time')
            ->paginate(15);
        return view('weight-readings.all', compact('readings'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $readings = $patient->weightReadings()->latest('date')->latest('time')->paginate(15);
        return view('weight-readings.index', compact('patient', 'readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('weight-readings.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'weight' => 'required|numeric|min:0|max:1000',
            'weight_unit' => 'required|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $validated['patient_id'] = $patient->id;
        
        // Set default unit if not provided
        $validated['weight_unit'] = $validated['weight_unit'] ?? 'kg';

        WeightReading::create($validated);

        return redirect()->route('patients.weight-readings.index', $patient)
            ->with('success', 'Weight reading added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, WeightReading $weightReading)
    {
        return view('weight-readings.edit', compact('patient', 'weightReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, WeightReading $weightReading)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'weight' => 'required|numeric|min:0|max:1000',
            'weight_unit' => 'required|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        // Set default unit if not provided
        $validated['weight_unit'] = $validated['weight_unit'] ?? 'kg';

        $weightReading->update($validated);

        return redirect()->route('patients.weight-readings.index', $patient)
            ->with('success', 'Weight reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, WeightReading $weightReading)
    {
        $weightReading->delete();

        return redirect()->route('patients.weight-readings.index', $patient)
            ->with('success', 'Weight reading deleted successfully.');
    }
}
