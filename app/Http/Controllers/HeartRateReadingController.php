<?php

namespace App\Http\Controllers;

use App\Models\HeartRateReading;
use App\Models\Patient;
use Illuminate\Http\Request;

class HeartRateReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $readings = $patient->heartRateReadings()->latest('date')->latest('time')->paginate(15);
        return view('heart-rate-readings.index', compact('patient', 'readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('heart-rate-readings.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'heart_rate' => 'required|integer|min:30|max:250',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $validated['patient_id'] = $patient->id;
        HeartRateReading::create($validated);

        return redirect()->route('patients.heart-rate-readings.index', $patient)
            ->with('success', 'Heart rate reading added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient, HeartRateReading $heartRateReading)
    {
        return view('heart-rate-readings.show', compact('patient', 'heartRateReading'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, HeartRateReading $heartRateReading)
    {
        return view('heart-rate-readings.edit', compact('patient', 'heartRateReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, HeartRateReading $heartRateReading)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'heart_rate' => 'required|integer|min:30|max:250',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $heartRateReading->update($validated);

        return redirect()->route('patients.heart-rate-readings.index', $patient)
            ->with('success', 'Heart rate reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, HeartRateReading $heartRateReading)
    {
        $heartRateReading->delete();

        return redirect()->route('patients.heart-rate-readings.index', $patient)
            ->with('success', 'Heart rate reading deleted successfully.');
    }
}
