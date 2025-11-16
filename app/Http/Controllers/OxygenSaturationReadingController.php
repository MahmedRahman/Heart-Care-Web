<?php

namespace App\Http\Controllers;

use App\Models\OxygenSaturationReading;
use App\Models\Patient;
use Illuminate\Http\Request;

class OxygenSaturationReadingController extends Controller
{
    /**
     * Display a listing of all oxygen saturation readings.
     */
    public function all()
    {
        $readings = OxygenSaturationReading::with('patient')
            ->latest('date')
            ->latest('time')
            ->paginate(15);
        return view('oxygen-saturation-readings.all', compact('readings'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $readings = $patient->oxygenSaturationReadings()->latest('date')->latest('time')->paginate(15);
        return view('oxygen-saturation-readings.index', compact('patient', 'readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('oxygen-saturation-readings.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'oxygen_saturation' => 'required|numeric|min:0|max:100',
            'oxygen_saturation_unit' => 'required|string|max:10',
            'oxygen_delivery_method' => 'nullable|string|max:255',
            'oxygen_delivery_method_unit' => 'nullable|string|max:20',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $validated['patient_id'] = $patient->id;
        
        // Set default unit if not provided
        $validated['oxygen_saturation_unit'] = $validated['oxygen_saturation_unit'] ?? '%';

        OxygenSaturationReading::create($validated);

        return redirect()->route('patients.oxygen-saturation-readings.index', $patient)
            ->with('success', 'Oxygen saturation reading added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, OxygenSaturationReading $oxygenSaturationReading)
    {
        return view('oxygen-saturation-readings.edit', compact('patient', 'oxygenSaturationReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, OxygenSaturationReading $oxygenSaturationReading)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'oxygen_saturation' => 'required|numeric|min:0|max:100',
            'oxygen_saturation_unit' => 'required|string|max:10',
            'oxygen_delivery_method' => 'nullable|string|max:255',
            'oxygen_delivery_method_unit' => 'nullable|string|max:20',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        // Set default unit if not provided
        $validated['oxygen_saturation_unit'] = $validated['oxygen_saturation_unit'] ?? '%';

        $oxygenSaturationReading->update($validated);

        return redirect()->route('patients.oxygen-saturation-readings.index', $patient)
            ->with('success', 'Oxygen saturation reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, OxygenSaturationReading $oxygenSaturationReading)
    {
        $oxygenSaturationReading->delete();

        return redirect()->route('patients.oxygen-saturation-readings.index', $patient)
            ->with('success', 'Oxygen saturation reading deleted successfully.');
    }
}
