<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Chirp;
use App\Models\ChirpLog;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')
            ->where('is_deleted', false)  // Exclude deleted chirps
            ->latest()
            ->take(50)  // Limit to 50 most recent chirps
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        $chirp = auth()->user()->chirps()->create($validated);

        auth()->user()->chirpLogs()->create([
            'user_id' => auth()->id(),
            'chirp_id' => $chirp->id,
            'message' => $validated['message'],
            'status' => 'current',
            'created_at' => $chirp->created_at,
            'updated_at' => $chirp->updated_at,
        ]);

        return redirect('/')->with('success', 'Your chirp has been posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Validate
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Update
        $chirp->update($validated);

        // Log update
        $chirpLogCurrent = ChirpLog::where('chirp_id', $chirp->id)->latest('id')->first();
        if ($chirpLogCurrent) {
            $chirpLogCurrent->update([
                'status' => 'old',
                'updated_at' => $chirp->updated_at,
            ]);
        }

        auth()->user()->chirpLogs()->create([
            'user_id'=> auth()->id(),
            'chirp_id' => $chirp->id,
            'message' => $validated['message'],
            'status' => 'current',
            'created_at' => $chirp->updated_at,
            'updated_at' => $chirp->updated_at,
        ]);

        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $chirp->update(['is_deleted' => true]);

        $chirpLogCurrent = ChirpLog::where('chirp_id', $chirp->id)->latest('id')->first();
        if ($chirpLogCurrent) {
            $chirpLogCurrent->update([
                'status' => 'deleted',
                'updated_at' => $chirp->updated_at,
            ]);
        }

        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
