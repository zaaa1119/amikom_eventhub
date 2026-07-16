<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus = Pengurus::with('jabatan')->get();

        return view('pengurus.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::all();

        return view('pengurus.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'nullable|max:255',
            'salary' => 'required|numeric',
        ]);

        Pengurus::create([
            'jabatan_id' => $request->jabatan_id,
            'name' => $request->name,
            'description' => $request->description,
            'salary' => $request->salary,
            'created_by' => 'admin',
        ]);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $jabatans = Jabatan::all();

        return view('pengurus.edit', compact('pengurus', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jabatan_id' => 'required',
            'name' => 'required|max:100',
            'description' => 'nullable|max:255',
            'salary' => 'required|numeric',
        ]);

        $pengurus = Pengurus::findOrFail($id);

        $pengurus->update([
            'jabatan_id' => $request->jabatan_id,
            'name' => $request->name,
            'description' => $request->description,
            'salary' => $request->salary,
            'updated_by' => 'admin',
            'updated_at' => now(),
        ]);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengurus = Pengurus::findOrFail($id);

        $pengurus->delete();

        return redirect()->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil dihapus.');
    }
}