<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::latest()->paginate(15);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $primaryDiagnoses = Diagnosis::active()->byType('primary')->orderBy('order')->get();
        $secondaryDiagnoses = Diagnosis::active()->byType('secondary')->orderBy('order')->get();
        $tertiaryDiagnoses = Diagnosis::active()->byType('tertiary')->orderBy('order')->get();
        
        return view('patients.create', compact('primaryDiagnoses', 'secondaryDiagnoses', 'tertiaryDiagnoses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:patients,mobile_number',
            'telephone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:patients,email',
            'hospital_id' => 'required|string|unique:patients,hospital_id',
            'password' => 'required|string|min:8|confirmed',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address_area' => 'nullable|string|max:255',
            'address_street' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'age' => 'nullable|integer|min:0|max:150',
            'race' => 'nullable|in:african,asian,caucasian,hispanic,native_american,pacific_islander,other',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'bsa' => 'nullable|numeric|min:0',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'marital_state' => 'nullable|in:single,married,divorced,widowed,separated',
            'language' => 'nullable|string|max:255',
            'primary_diagnosis' => 'nullable|string|max:255',
            'secondary_diagnosis' => 'nullable|array',
            'secondary_diagnosis.*' => 'nullable|string|max:255',
            'tertiary_diagnosis' => 'nullable|array',
            'tertiary_diagnosis.*' => 'nullable|string|max:255',
            'next_of_kin' => 'nullable|string|max:255',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'next_of_kin_email' => 'nullable|email|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'physician_team_name' => 'nullable|string|max:255',
            'nurse_name' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('patients', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        Patient::create($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $primaryDiagnoses = Diagnosis::active()->byType('primary')->orderBy('order')->get();
        $secondaryDiagnoses = Diagnosis::active()->byType('secondary')->orderBy('order')->get();
        $tertiaryDiagnoses = Diagnosis::active()->byType('tertiary')->orderBy('order')->get();
        
        return view('patients.edit', compact('patient', 'primaryDiagnoses', 'secondaryDiagnoses', 'tertiaryDiagnoses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:patients,mobile_number,' . $patient->id,
            'telephone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'hospital_id' => 'required|string|unique:patients,hospital_id,' . $patient->id,
            'password' => 'nullable|string|min:8|confirmed',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address_area' => 'nullable|string|max:255',
            'address_street' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'age' => 'nullable|integer|min:0|max:150',
            'race' => 'nullable|in:african,asian,caucasian,hispanic,native_american,pacific_islander,other',
            'weight' => 'nullable|numeric|min:0|max:500',
            'height' => 'nullable|numeric|min:0|max:300',
            'bsa' => 'nullable|numeric|min:0',
            'bmi' => 'nullable|numeric|min:0|max:100',
            'marital_state' => 'nullable|in:single,married,divorced,widowed,separated',
            'language' => 'nullable|string|max:255',
            'primary_diagnosis' => 'nullable|string|max:255',
            'secondary_diagnosis' => 'nullable|array',
            'secondary_diagnosis.*' => 'nullable|string|max:255',
            'tertiary_diagnosis' => 'nullable|array',
            'tertiary_diagnosis.*' => 'nullable|string|max:255',
            'next_of_kin' => 'nullable|string|max:255',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'next_of_kin_email' => 'nullable|email|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'physician_team_name' => 'nullable|string|max:255',
            'nurse_name' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($patient->profile_image) {
                Storage::disk('public')->delete($patient->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('patients', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        // Delete profile image if exists
        if ($patient->profile_image) {
            Storage::disk('public')->delete($patient->profile_image);
        }

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
