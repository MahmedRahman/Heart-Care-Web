<?php

namespace App\Http\Controllers;

use App\Models\RadiologyReport;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RadiologyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = RadiologyReport::with('patient')
            ->latest('report_date')
            ->paginate(15);
        
        return view('radiology-reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('first_name')->orderBy('last_name')->get();
        return view('radiology-reports.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'report_name' => 'required|string|max:255',
            'report_date' => 'required|date',
            'files' => 'required|array|min:1',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,pdf|max:10240', // 10MB max per file
        ]);

        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $files[] = $file->store('radiology-reports', 'public');
            }
        }

        $validated['files'] = $files;

        RadiologyReport::create($validated);

        return redirect()->route('radiology-reports.index')
            ->with('success', 'Radiology report created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RadiologyReport $radiologyReport)
    {
        $radiologyReport->load('patient');
        return view('radiology-reports.show', compact('radiologyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RadiologyReport $radiologyReport)
    {
        $patients = Patient::orderBy('first_name')->orderBy('last_name')->get();
        return view('radiology-reports.edit', compact('radiologyReport', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RadiologyReport $radiologyReport)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'report_name' => 'required|string|max:255',
            'report_date' => 'required|date',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,pdf|max:10240',
        ]);

        // Handle new file uploads
        if ($request->hasFile('files')) {
            $newFiles = [];
            foreach ($request->file('files') as $file) {
                $newFiles[] = $file->store('radiology-reports', 'public');
            }
            
            // Merge with existing files if any
            $existingFiles = $radiologyReport->files ?? [];
            $validated['files'] = array_merge($existingFiles, $newFiles);
        } else {
            // Keep existing files
            $validated['files'] = $radiologyReport->files;
        }

        $radiologyReport->update($validated);

        return redirect()->route('radiology-reports.index')
            ->with('success', 'Radiology report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RadiologyReport $radiologyReport)
    {
        // Delete associated files
        if ($radiologyReport->files) {
            foreach ($radiologyReport->files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $radiologyReport->delete();

        return redirect()->route('radiology-reports.index')
            ->with('success', 'Radiology report deleted successfully.');
    }

    /**
     * Delete a specific file from a report
     */
    public function deleteFile(RadiologyReport $radiologyReport, $fileIndex)
    {
        $files = $radiologyReport->files ?? [];
        
        if (isset($files[$fileIndex])) {
            Storage::disk('public')->delete($files[$fileIndex]);
            unset($files[$fileIndex]);
            $radiologyReport->files = array_values($files); // Re-index array
            $radiologyReport->save();
        }

        return back()->with('success', 'File deleted successfully.');
    }
}
