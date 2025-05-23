<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudyProgram;
use App\Models\Role;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function pengguna()
    {
        $users = User::all();
        return view('admin.pengguna', compact('users'));
    }

    public function create()
    {
        return view('admin.createPengguna');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:users|max:9',
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users|max:45',
            'password' => 'required|confirmed|min:8|max:255',
            'address' => 'required|max:300',
            'study_program_id' => 'required',
            'phone' => 'required|max:16',
            'role_id' => 'required',
        ], [
            'id.required' => 'Kolom ID wajib diisi.',
            'id.unique' => 'ID sudah digunakan.',
            'id.max' => 'ID tidak boleh lebih dari 9 karakter.',
            'name.required' => 'Kolom Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 120 karakter.',
            'email.required' => 'Kolom Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email tidak boleh lebih dari 45 karakter.',
            'password.required' => 'Kolom Kata Sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi Kata Sandi tidak cocok.',
            'password.min' => 'Kata Sandi harus minimal 8 karakter.',
            'password.max' => 'Kata Sandi tidak boleh lebih dari 255 karakter.',
            'address.required' => 'Kolom Alamat wajib diisi.',
            'address.max' => 'Alamat tidak boleh lebih dari 300 karakter.',
            'study_program_id.required' => 'Kolom Program Studi wajib diisi.',
            'phone.required' => 'Kolom Telepon wajib diisi.',
            'phone.max' => 'Telepon tidak boleh lebih dari 16 karakter.',
            'role_id.required' => 'Kolom Peran wajib diisi.',
        ]);

        // Check if the role is Kaprodi and if there is an active Kaprodi for the same study program
        if ($request->role == 'Kaprodi') {
            $existingKaprodi = User::where('role_id', $request->role_id)
                ->where('study_program_id', $request->study_program_id)
                ->where('status', 'aktif')
                ->first();

            if ($existingKaprodi) {
                return back()->withInput()->with('error', 'Kaprodi aktif sudah ada untuk program studi yang dipilih.');
            }
        }

        try {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $data['status'] = 'aktif';

            $user = User::create($data);

            // Send email with credentials
            Mail::to($request->email)->send(new WelcomeMail($request->name, $request->id, $request->password));

            $role = strtolower($user->role->name);

            return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat Pengguna.');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna dengan ID yang ditentukan tidak ditemukan.');
        }

        $studyPrograms = StudyProgram::all();
        $roles = Role::all();
        return view('admin.editPengguna', compact('user', 'studyPrograms', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna dengan ID yang ditentukan tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'name' => 'required|max:120',
            'address' => 'required|max:300',
            'status' => 'required|in:aktif,tidak aktif',
            'phone' => 'required|max:16',
            'password' => 'nullable|confirmed|min:8|max:255',
            'role_id' => 'required_if:role,Dosen|in:dosen,kaprodi',
        ], [
            'name.required' => 'Kolom Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 120 karakter.',
            'address.required' => 'Kolom Alamat wajib diisi.',
            'address.max' => 'Alamat tidak boleh lebih dari 300 karakter.',
            'status.required' => 'Kolom Status wajib diisi.',
            'status.in' => 'Status harus berupa Aktif atau Tidak Aktif.',
            'phone.required' => 'Kolom Telepon wajib diisi.',
            'phone.max' => 'Telepon tidak boleh lebih dari 16 karakter.',
            'password.confirmed' => 'Konfirmasi Kata Sandi tidak cocok.',
            'password.min' => 'Kata Sandi harus minimal 8 karakter.',
            'password.max' => 'Kata Sandi tidak boleh lebih dari 255 karakter.',
            'role_id.required_if' => 'Kolom Role wajib diisi jika pengguna adalah Dosen.',
            'role_id.in' => 'Role harus berupa Dosen atau Kaprodi.',
        ]);

        try {
            // Check if the role is being changed to Kaprodi
            if ($user->role->name == 'Dosen' && $validatedData['role_id'] == 'kaprodi') {
                $existingKaprodi = User::where('role_id', Role::where('name', 'Kaprodi')->first()->id)
                    ->where('study_program_id', $user->study_program_id)
                    ->where('status', 'aktif')
                    ->first();

                if ($existingKaprodi) {
                    return redirect()->back()->with('error', 'Kaprodi aktif sudah ada untuk program studi yang dipilih.');
                }
            }

            $user->name = $validatedData['name'];
            $user->address = $validatedData['address'];
            $user->status = $validatedData['status'];
            $user->phone = $validatedData['phone'];

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            // Update role if applicable
            if ($user->role->name == 'Dosen' && isset($validatedData['role_id'])) {
                $user->role_id = Role::where('name', ucfirst($validatedData['role_id']))->first()->id;
            }

            $user->save();

            $role = strtolower($user->role->name);
            return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui Pengguna.')->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $role = strtolower($user->role->name);
        $user->delete();
        return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna berhasil dihapus.');
    }

    public function editProfile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')
                ->withErrors(['error' => 'Gagal memperbarui profil. Silakan coba lagi.'])
                ->withInput();
        }
    }
}