<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Patient $patient)
    {
        $prescriptions = $patient->prescriptions()->with('medicines')->latest('prescription_date')->paginate(15);
        return view('prescriptions.index', compact('patient', 'prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        return view('prescriptions.create', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'doctor_name' => 'required|string|max:255',
            'prescription_date' => 'required|date',
            'medicines' => 'required|array|min:1',
            'medicines.*.medicine_name' => 'nullable|string|max:255',
            'medicines.*.other_medicine_name' => 'nullable|string|max:255',
            'medicines.*.medicine_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'medicines.*.dose' => 'nullable|string|max:100',
            'medicines.*.form' => 'nullable|string|max:100',
            'medicines.*.route' => 'nullable|string|max:100',
            'medicines.*.frequency' => 'nullable|string|max:100',
            'medicines.*.time' => 'nullable|array',
            'medicines.*.time.*' => 'nullable|string',
            'medicines.*.duration_value' => 'nullable|integer|min:1',
            'medicines.*.duration_unit' => 'nullable|string|max:50',
            'medicines.*.start_date' => 'nullable|date',
            'medicines.*.renewal_date' => 'nullable|date',
            'medicines.*.description' => 'nullable|string|max:1000',
            'medicines.*.special_instruction' => 'nullable|string|max:500',
        ]);

        $prescription = $patient->prescriptions()->create([
            'doctor_name' => $validated['doctor_name'],
            'prescription_date' => $validated['prescription_date'],
        ]);

        foreach ($validated['medicines'] as $key => $medicineData) {
            $medicineData['prescription_id'] = $prescription->id;

            // Handle image upload
            if ($request->hasFile("medicines.{$key}.medicine_image")) {
                $image = $request->file("medicines.{$key}.medicine_image");
                $medicineData['medicine_image'] = $image->store('medicines', 'public');
            }

            // Clean up time array (remove null values)
            if (isset($medicineData['time']) && is_array($medicineData['time'])) {
                $medicineData['time'] = array_filter($medicineData['time'], fn($t) => !empty($t));
            }

            Medicine::create($medicineData);
        }

        return redirect()->route('patients.prescriptions.index', $patient)
            ->with('success', 'Prescription created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient, Prescription $prescription)
    {
        $prescription->load('medicines');
        return view('prescriptions.show', compact('patient', 'prescription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient, Prescription $prescription)
    {
        $prescription->load('medicines');
        return view('prescriptions.edit', compact('patient', 'prescription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, Prescription $prescription)
    {
        $validated = $request->validate([
            'doctor_name' => 'required|string|max:255',
            'prescription_date' => 'required|date',
            'medicines' => 'required|array|min:1',
            'medicines.*.id' => 'nullable|exists:medicines,id',
            'medicines.*.medicine_name' => 'nullable|string|max:255',
            'medicines.*.other_medicine_name' => 'nullable|string|max:255',
            'medicines.*.medicine_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'medicines.*.dose' => 'nullable|string|max:100',
            'medicines.*.form' => 'nullable|string|max:100',
            'medicines.*.route' => 'nullable|string|max:100',
            'medicines.*.frequency' => 'nullable|string|max:100',
            'medicines.*.time' => 'nullable|array',
            'medicines.*.time.*' => 'nullable|string',
            'medicines.*.duration_value' => 'nullable|integer|min:1',
            'medicines.*.duration_unit' => 'nullable|string|max:50',
            'medicines.*.start_date' => 'nullable|date',
            'medicines.*.renewal_date' => 'nullable|date',
            'medicines.*.description' => 'nullable|string|max:1000',
            'medicines.*.special_instruction' => 'nullable|string|max:500',
        ]);

        $prescription->update([
            'doctor_name' => $validated['doctor_name'],
            'prescription_date' => $validated['prescription_date'],
        ]);

        // Get existing medicine IDs
        $existingIds = collect($validated['medicines'])->pluck('id')->filter()->toArray();
        
        // Delete medicines that are not in the request
        $prescription->medicines()->whereNotIn('id', $existingIds)->delete();

        foreach ($validated['medicines'] as $key => $medicineData) {
            $medicineData['prescription_id'] = $prescription->id;

            // Handle image upload
            if ($request->hasFile("medicines.{$key}.medicine_image")) {
                $image = $request->file("medicines.{$key}.medicine_image");
                $medicineData['medicine_image'] = $image->store('medicines', 'public');
            }

            // Clean up time array
            if (isset($medicineData['time']) && is_array($medicineData['time'])) {
                $medicineData['time'] = array_filter($medicineData['time'], fn($t) => !empty($t));
            }

            if (isset($medicineData['id']) && $medicineData['id']) {
                // Update existing medicine
                $medicine = Medicine::find($medicineData['id']);
                if ($medicine) {
                    unset($medicineData['id']);
                    $medicine->update($medicineData);
                }
            } else {
                // Create new medicine
                unset($medicineData['id']);
                Medicine::create($medicineData);
            }
        }

        return redirect()->route('patients.prescriptions.index', $patient)
            ->with('success', 'Prescription updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, Prescription $prescription)
    {
        // Delete medicine images
        foreach ($prescription->medicines as $medicine) {
            if ($medicine->medicine_image) {
                Storage::disk('public')->delete($medicine->medicine_image);
            }
        }

        $prescription->delete();

        return redirect()->route('patients.prescriptions.index', $patient)
            ->with('success', 'Prescription deleted successfully.');
    }
}
