<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataUser = User::all();
        return view('admin.user.index', compact('dataUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
        $data['password'] = Hash::make($request->password);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birthday'   => 'nullable|date',
            'gender'     => 'required|in:Male,Female,Other',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|numeric',
        ]);

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
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
        $data['dataUser'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'birthday'   => 'nullable|date',
            'gender'     => 'required|in:Male,Female,Other',
            'email'      => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone'      => 'required|numeric',
        ]);
        $user = User::where('user_id', $id)->firstOrFail();
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
