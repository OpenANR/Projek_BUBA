<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = User::where('role', 'siswa')
            ->with('kelas')
            ->orderBy('id', 'asc')
            ->get();

        $dataSiswa = $siswa;

        if ($request->wantsJson()) {
            return response()->json($dataSiswa);
        }

        return view('admin.siswa.index', compact('dataSiswa', 'siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataKelas = Kelas::get();
        return view('admin.siswa.add', compact('dataKelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'kode_user' => 'required|unique:users,kode_user',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'jenis_kelamin' => 'nullable',
            'role' => 'required',
            'kelas_id'  => 'nullable|exists:kelas,id'
        ]);

        $data = [
            // 'kode_user' => 'STD - ' . Str::upper(Str::random(4)),
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => $request->role,
            'kelas_id' => $request->kelas_id
        ];

        User::create($data);
        
        if ($request->wantsJson()) {
            return response()->json($data);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
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
    public function edit(User $siswa)
    {
        $dataKelas = Kelas::get();
        $dataSiswa = $siswa;
        // dd($dataSiswa);
        return view('admin.siswa.edit', compact('dataSiswa', 'dataKelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $siswa)
    {
        $request->validate([
            // 'kode_user' => 'required|unique:users,kode_user',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'password' => 'nullable|string',
            'jenis_kelamin' => 'nullable',
            'role' => 'required',
            'kelas_id'  => 'nullable|exists:kelas,id'
        ]);

        $data = [
            // 'kode_user' => 'STD - ' . Str::upper(Str::random(4)),
            'name' => $request->name,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => $request->role,
            'kelas_id' => $request->kelas_id
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $siswa->update($data);
        
        if ($request->wantsJson()) {
            return response()->json($siswa);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
