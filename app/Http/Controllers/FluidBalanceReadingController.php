<?php

namespace App\Http\Controllers;

use App\Models\FluidBalanceReading;
use App\Models\Patient;
use Illuminate\Http\Request;

class FluidBalanceReadingController extends Controller
{
    /**
     * Display a listing of all fluid balance readings.
     */
    public function all()
    {
        $readings = FluidBalanceReading::with('patient')
            ->latest('date')
            ->latest('time')
            ->paginate(15);
        return view('fluid-balance-readings.all', compact('readings'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $readings = $patient->fluidBalanceReadings()->latest('date')->latest('time')->paginate(15);
        return view('fluid-balance-readings.index', compact('patient', 'readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('fluid-balance-readings.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'fluid_intake' => 'nullable|numeric|min:0|max:10000',
            'fluid_intake_unit' => 'nullable|string|max:10',
            'fluid_output' => 'nullable|numeric|min:0|max:10000',
            'fluid_output_unit' => 'nullable|string|max:10',
            'net_balance' => 'nullable|numeric',
            'net_balance_unit' => 'nullable|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        $validated['patient_id'] = $patient->id;

        // Calculate net balance if both intake and output are provided
        if (isset($validated['fluid_intake']) && isset($validated['fluid_output'])) {
            $validated['net_balance'] = $validated['fluid_intake'] - $validated['fluid_output'];
            $validated['net_balance_unit'] = $validated['fluid_intake_unit'] ?? $validated['fluid_output_unit'] ?? 'mL';
        }

        FluidBalanceReading::create($validated);

        return redirect()->route('patients.fluid-balance-readings.index', $patient)
            ->with('success', 'Fluid balance reading added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, FluidBalanceReading $fluidBalanceReading)
    {
        return view('fluid-balance-readings.edit', compact('patient', 'fluidBalanceReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, FluidBalanceReading $fluidBalanceReading)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'fluid_intake' => 'nullable|numeric|min:0|max:10000',
            'fluid_intake_unit' => 'nullable|string|max:10',
            'fluid_output' => 'nullable|numeric|min:0|max:10000',
            'fluid_output_unit' => 'nullable|string|max:10',
            'net_balance' => 'nullable|numeric',
            'net_balance_unit' => 'nullable|string|max:10',
            'symptoms' => 'nullable|string|max:1000',
        ]);

        // Calculate net balance if both intake and output are provided
        if (isset($validated['fluid_intake']) && isset($validated['fluid_output'])) {
            $validated['net_balance'] = $validated['fluid_intake'] - $validated['fluid_output'];
            $validated['net_balance_unit'] = $validated['fluid_intake_unit'] ?? $validated['fluid_output_unit'] ?? 'mL';
        }

        $fluidBalanceReading->update($validated);

        return redirect()->route('patients.fluid-balance-readings.index', $patient)
            ->with('success', 'Fluid balance reading updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, FluidBalanceReading $fluidBalanceReading)
    {
        $fluidBalanceReading->delete();

        return redirect()->route('patients.fluid-balance-readings.index', $patient)
            ->with('success', 'Fluid balance reading deleted successfully.');
    }
}
