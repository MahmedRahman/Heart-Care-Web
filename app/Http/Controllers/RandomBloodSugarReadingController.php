<?php

namespace App\Http\Controllers;

use App\Models\RandomBloodSugarReading;
use App\Models\Patient;
use Illuminate\Http\Request;

class RandomBloodSugarReadingController extends Controller
{
    /**
     * Display a listing of all random blood sugar readings.
     */
    public function all()
    {
        $readings = RandomBloodSugarReading::with('patient')
            ->latest('date')
            ->latest('time')
            ->paginate(15);
        return view('random-blood-sugar-readings.all', compact('readings'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $readings = $patient->randomBloodSugarReadings()->latest('date')->latest('time')->paginate(15);
        return view('random-blood-sugar-readings.index', compact('patient', 'readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('random-blood-sugar-readings.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'random_blood_sugar' => 'required|numeric|min:0|max:1000',
            'random_blood_sugar_unit' => 'required|string|max:10',
            'insulin_dose' => 'nullable|numeric|min:0|max:1000',
            'insulin_dose_unit' => 'nullable|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $validated['patient_id'] = $patient->id;
        
        // Set default unit if not provided
        $validated['random_blood_sugar_unit'] = $validated['random_blood_sugar_unit'] ?? 'mg/dL';

        RandomBloodSugarReading::create($validated);

        return redirect()->route('patients.random-blood-sugar-readings.index', $patient)
            ->with('success', 'Random blood sugar reading added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, RandomBloodSugarReading $randomBloodSugarReading)
    {
        return view('random-blood-sugar-readings.edit', compact('patient', 'randomBloodSugarReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, RandomBloodSugarReading $randomBloodSugarReading)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'random_blood_sugar' => 'required|numeric|min:0|max:1000',
            'random_blood_sugar_unit' => 'required|string|max:10',
            'insulin_dose' => 'nullable|numeric|min:0|max:1000',
            'insulin_dose_unit' => 'nullable|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        // Set default unit if not provided
        $validated['random_blood_sugar_unit'] = $validated['random_blood_sugar_unit'] ?? 'mg/dL';

        $randomBloodSugarReading->update($validated);

        return redirect()->route('patients.random-blood-sugar-readings.index', $patient)
            ->with('success', 'Random blood sugar reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, RandomBloodSugarReading $randomBloodSugarReading)
    {
        $randomBloodSugarReading->delete();

        return redirect()->route('patients.random-blood-sugar-readings.index', $patient)
            ->with('success', 'Random blood sugar reading deleted successfully.');
    }
}
