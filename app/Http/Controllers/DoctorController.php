<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
  public function index()
  {
    $currentUser = Auth::user();
    $canDelete = $currentUser->can('delete records');
    $doctors = User::orderBy('name', 'asc')->get();
    return view('doctor.index', compact('doctors', 'canDelete'));
  }
  public function show($id)
  {
    $doctor = User::findOrFail($id);
    return response()->json($doctor);
  }
  public function create()
  {
    return view('doctor.create-doctor');
  }
  public function store(Request $request)
  {
    // Validate phone number for uniqueness
    $request->validate([
      'phone' => ['required', 'string', Rule::unique('users', 'phone')],
    ], [
      'phone.unique' => 'The phone number is already in use by another user.',
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'gender' => $request->gender,
      'address' => $request->address,
      'designation' => $request->designation,
      'phone' => $request->phone,
      'city' => $request->city,
      'password' => bcrypt('12345678'),
    ]);

    // Assign role based on designation
    if ($request->designation === 'Doctor') {
      $user->assignRole('doctor');
    } elseif ($request->designation === 'Surgeon') {
      $user->assignRole('doctor');
    } elseif ($request->designation === 'Assistant') {
      $user->assignRole('assistant');
    }

    return redirect()->route('doctor.index')->with('success', 'User added successfully  (Password: 12345678).');
  }

  public function getFilteredDoctorData(Request $request)
  {
    $query = User::query();

    // Filter by exact name match
    if ($request->has('name') && $request->name) {
      $query->where('name', $request->name); // Exact match
    }

    // Filter by designation

    if ($request->has('designation') && $request->designation) {
      $query->where('designation', $request->designation);
    }

    $query->orderBy('name', 'asc');
    $doctors = $query->get();

    // Adjust the response format
    $data = $doctors->map(function ($doctor) {
      return [
        'id' => $doctor->id,
        'name' => $doctor->name,
        'gender' => $doctor->gender,
        'email' => $doctor->email,
        'city' => $doctor->city,
        'phone' => $doctor->phone,
        'address' => $doctor->address,
        'designation' => $doctor->designation,
      ];
    });

    return response()->json($data);
  }


  public function view($id)
  {
    $doctor = User::where('id', $id)->firstOrFail();

    return view('doctor.view-doctor', compact('doctor'));
  }


  public function getDoctorDetails($id)
  {
    $doctor = User::where('id', $id)->first();

    if ($doctor) {
      return response()->json($doctor);
    } else {
      return response()->json(['error' => 'doctor not found'], 404);
    }
  }
  public function edit($id)
  {
    $doctor = User::where('id', $id)->firstOrFail();
    return view('doctor.edit', compact('doctor'));
  }
  public function update(Request $request, $id)
  {
    // Validate only the phone number for uniqueness
    $request->validate([
      'phone' => ['required', 'string', Rule::unique('users', 'phone')->ignore($id)],
    ], [
      'phone.unique' => 'The phone number is already in use by another user.',
    ]);

    $doctor = User::findOrFail($id);
    $data = [
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'gender' => $request->input('gender'),
      'designation' => $request->input('designation'),
      'city' => $request->input('city'),
      'phone' => $request->input('phone'),
      'address' => $request->input('address'),
    ];
    if ($request->filled('password')) {
      $data['password'] = bcrypt($request->input('password'));
    }
    $doctor->update($data);

    return redirect()->route('doctor.index')->with('success', 'User updated successfully.');
  }
  public function editPassword($id)
  {
    $user = User::where('id', $id)->firstOrFail();
    if (auth()->user()->id !== (int) $id) {
      abort(403, 'Unauthorized access');
    }
    return view('my_profile.edit', compact('user'));
  }
  public function updatePassword(Request $request, $id)
  {
    // Validate only the phone number for uniqueness
    $request->validate([
      'phone' => ['required', 'string', Rule::unique('users', 'phone')->ignore($id)],
    ], [
      'phone.unique' => 'The phone number is already in use by another user.',
    ]);

    $user = User::findOrFail($id);
    $data = [
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'gender' => $request->input('gender'),
      'phone' => $request->input('phone'),
    ];
    if ($request->filled('password')) {
      $data['password'] = bcrypt($request->input('password'));
    }
    $user->update($data);

    return redirect()->route('doctor.edit-password', ['id' => $id])->with('success', 'Profile updated successfully.');
  }

  public function destroy($id)
  {
    $doctor = User::find($id);

    if (!$doctor) {
      return redirect()->route('doctor.index')->with('error', 'User not found.');
    }

    $doctor->delete();

    return redirect()->route('doctor.index')->with('success', 'User deleted successfully.');
  }
}
