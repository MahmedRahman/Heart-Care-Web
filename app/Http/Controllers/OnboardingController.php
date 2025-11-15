<?php

namespace App\Http\Controllers;

use App\Models\Onboarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $onboardings = Onboarding::orderBy('order')->paginate(15);
        return view('onboardings.index', compact('onboardings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('onboardings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('onboardings', 'public');
        }

        Onboarding::create($validated);

        return redirect()->route('onboardings.index')
            ->with('success', 'Onboarding item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Onboarding $onboarding)
    {
        return view('onboardings.show', compact('onboarding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Onboarding $onboarding)
    {
        return view('onboardings.edit', compact('onboarding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Onboarding $onboarding)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($onboarding->image) {
                Storage::disk('public')->delete($onboarding->image);
            }
            $validated['image'] = $request->file('image')->store('onboardings', 'public');
        }

        $onboarding->update($validated);

        return redirect()->route('onboardings.index')
            ->with('success', 'Onboarding item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Onboarding $onboarding)
    {
        // Delete image if exists
        if ($onboarding->image) {
            Storage::disk('public')->delete($onboarding->image);
        }

        $onboarding->delete();

        return redirect()->route('onboardings.index')
            ->with('success', 'Onboarding item deleted successfully.');
    }
}
