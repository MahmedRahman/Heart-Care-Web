<?php

namespace App\Http\Controllers;

use App\Models\LabReport;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = LabReport::with('patient')
            ->latest('report_date')
            ->paginate(15);
        
        return view('lab-reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('first_name')->orderBy('last_name')->get();
        return view('lab-reports.create', compact('patients'));
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
            'files.*' => 'file|mimes:pdf|max:10240', // 10MB max per file, PDF only
        ]);

        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $files[] = $file->store('lab-reports', 'public');
            }
        }

        $validated['files'] = $files;

        LabReport::create($validated);

        return redirect()->route('lab-reports.index')
            ->with('success', 'Lab report created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LabReport $labReport)
    {
        $labReport->load('patient');
        return view('lab-reports.show', compact('labReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LabReport $labReport)
    {
        $patients = Patient::orderBy('first_name')->orderBy('last_name')->get();
        return view('lab-reports.edit', compact('labReport', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LabReport $labReport)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'report_name' => 'required|string|max:255',
            'report_date' => 'required|date',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:pdf|max:10240',
        ]);

        // Handle new file uploads
        if ($request->hasFile('files')) {
            $newFiles = [];
            foreach ($request->file('files') as $file) {
                $newFiles[] = $file->store('lab-reports', 'public');
            }
            
            // Merge with existing files if any
            $existingFiles = $labReport->files ?? [];
            $validated['files'] = array_merge($existingFiles, $newFiles);
        } else {
            // Keep existing files
            $validated['files'] = $labReport->files;
        }

        $labReport->update($validated);

        return redirect()->route('lab-reports.index')
            ->with('success', 'Lab report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LabReport $labReport)
    {
        // Delete associated files
        if ($labReport->files) {
            foreach ($labReport->files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $labReport->delete();

        return redirect()->route('lab-reports.index')
            ->with('success', 'Lab report deleted successfully.');
    }

    /**
     * Delete a specific file from a report
     */
    public function deleteFile(LabReport $labReport, $fileIndex)
    {
        $files = $labReport->files ?? [];
        
        if (isset($files[$fileIndex])) {
            Storage::disk('public')->delete($files[$fileIndex]);
            unset($files[$fileIndex]);
            $labReport->files = array_values($files); // Re-index array
            $labReport->save();
        }

        return back()->with('success', 'File deleted successfully.');
    }
}
