<?php

namespace App\Http\Controllers;

use App\Models\BloodPressureReading;
use App\Models\Patient;
use Illuminate\Http\Request;

class BloodPressureReadingController extends Controller
{
    /**
     * Display a listing of all blood pressure readings.
     */
    public function all()
    {
        $readings = BloodPressureReading::with('patient')
            ->latest('date')
            ->latest('time')
            ->paginate(15);
        return view('blood-pressure-readings.all', compact('readings'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $readings = $patient->bloodPressureReadings()->latest('date')->latest('time')->paginate(15);
        return view('blood-pressure-readings.index', compact('patient', 'readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('blood-pressure-readings.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'systolic_bp' => 'required|integer|min:50|max:300',
            'systolic_unit' => 'required|string|max:10',
            'diastolic_bp' => 'required|integer|min:30|max:200',
            'diastolic_unit' => 'required|string|max:10',
            'map' => 'nullable|numeric|min:40|max:200',
            'map_unit' => 'nullable|string|max:10',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'heart_rate_unit' => 'nullable|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $validated['patient_id'] = $patient->id;
        
        // Set default units if not provided
        $validated['systolic_unit'] = $validated['systolic_unit'] ?? 'mmHg';
        $validated['diastolic_unit'] = $validated['diastolic_unit'] ?? 'mmHg';
        $validated['map_unit'] = $validated['map_unit'] ?? 'mmHg';
        $validated['heart_rate_unit'] = $validated['heart_rate_unit'] ?? 'bpm';

        BloodPressureReading::create($validated);

        return redirect()->route('patients.blood-pressure-readings.index', $patient)
            ->with('success', 'Blood pressure reading added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, BloodPressureReading $bloodPressureReading)
    {
        return view('blood-pressure-readings.edit', compact('patient', 'bloodPressureReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, BloodPressureReading $bloodPressureReading)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'systolic_bp' => 'required|integer|min:50|max:300',
            'systolic_unit' => 'required|string|max:10',
            'diastolic_bp' => 'required|integer|min:30|max:200',
            'diastolic_unit' => 'required|string|max:10',
            'map' => 'nullable|numeric|min:40|max:200',
            'map_unit' => 'nullable|string|max:10',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'heart_rate_unit' => 'nullable|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        // Set default units if not provided
        $validated['systolic_unit'] = $validated['systolic_unit'] ?? 'mmHg';
        $validated['diastolic_unit'] = $validated['diastolic_unit'] ?? 'mmHg';
        $validated['map_unit'] = $validated['map_unit'] ?? 'mmHg';
        $validated['heart_rate_unit'] = $validated['heart_rate_unit'] ?? 'bpm';

        $bloodPressureReading->update($validated);

        return redirect()->route('patients.blood-pressure-readings.index', $patient)
            ->with('success', 'Blood pressure reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, BloodPressureReading $bloodPressureReading)
    {
        $bloodPressureReading->delete();

        return redirect()->route('patients.blood-pressure-readings.index', $patient)
            ->with('success', 'Blood pressure reading deleted successfully.');
    }
}
