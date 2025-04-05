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
            'status' => 'required|max:12',
            'study_program_id' => 'required',
            'phone' => 'required|max:16',
            'role_id' => 'required',
        ], [
            'id.required' => 'The ID field is required.',
            'id.unique' => 'The ID has already been taken.',
            'id.max' => 'The ID may not be greater than 9 characters.',
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 120 characters.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email must be a valid email address.',
            'email.unique' => 'The Email has already been taken.',
            'email.max' => 'The Email may not be greater than 45 characters.',
            'password.required' => 'The Password field is required.',
            'password.confirmed' => 'The Password confirmation does not match.',
            'password.min' => 'The Password must be at least 8 characters.',
            'password.max' => 'The Password may not be greater than 255 characters.',
            'address.required' => 'The Address field is required.',
            'address.max' => 'The Address may not be greater than 300 characters.',
            'status.required' => 'The Status field is required.',
            'status.max' => 'The Status may not be greater than 12 characters.',
            'study_program_id.required' => 'The Study Program field is required.',
            'phone.required' => 'The Phone field is required.',
            'phone.max' => 'The Phone may not be greater than 16 characters.',
            'role_id.required' => 'The Role field is required.',
        ]);

        // Check if the role is Kaprodi and if there is an active Kaprodi for the same study program
        if ($request->role == 'Kaprodi') {
            $existingKaprodi = User::where('role_id', $request->role_id)
                ->where('study_program_id', $request->study_program_id)
                ->where('status', 'aktif')
                ->first();

            if ($existingKaprodi) {
                return back()->withInput()->with('error', 'An active Kaprodi already exists for the selected study program.');
            }
        }

        try {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);

            $user = User::create($data);

            // Send email with credentials
            Mail::to($request->email)->send(new WelcomeMail($request->name, $request->id, $request->password));

            $role = strtolower($user->role->name);

            return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create Pengguna.');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $studyPrograms = StudyProgram::all();
        $roles = Role::all();
        return view('admin.editPengguna', compact('user', 'studyPrograms', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,'.$id.'|max:45',
            'address' => 'required|max:300',
            'status' => 'required|max:12',
            'study_program_id' => 'required',
            'phone' => 'required|max:16',
            'role_id' => 'required',
        ], [
            'name.required' => 'The Name field is required.',
            'name.max' => 'The Name may not be greater than 120 characters.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email must be a valid email address.',
            'email.unique' => 'The Email has already been taken.',
            'email.max' => 'The Email may not be greater than 45 characters.',
            'address.required' => 'The Address field is required.',
            'address.max' => 'The Address may not be greater than 300 characters.',
            'status.required' => 'The Status field is required.',
            'status.max' => 'The Status may not be greater than 12 characters.',
            'study_program_id.required' => 'The Study Program field is required.',
            'phone.required' => 'The Phone field is required.',
            'phone.max' => 'The Phone may not be greater than 16 characters.',
            'role_id.required' => 'The Role field is required.',
        ]);

        try {
            $user = User::find($id);

            // Check if the role is Kaprodi and the status is being set to "aktif"
            if ($request->role_id == $user->role_id && strtolower($user->role->name) == 'kaprodi' && $request->status == 'aktif') {
                $existingKaprodi = User::where('role_id', $user->role_id)
                    ->where('study_program_id', $request->study_program_id)
                    ->where('status', 'aktif')
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingKaprodi) {
                    return back()->withInput()->with('error', 'An active Kaprodi already exists for the selected study program.');
                }
            }

            $user->update($request->all());

            $role = strtolower($user->role->name);

            return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update Pengguna.');
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $role = strtolower($user->role->name);
        $user->delete();
        return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna deleted successfully.');
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

            return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')
                ->withErrors(['error' => 'Failed to update profile. Please try again.'])
                ->withInput();
        }
    }
}