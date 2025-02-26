<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\IpdCase;
use App\Models\OpdCase;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\DischargePlan;
use Illuminate\Support\Carbon;
use App\Models\OperationalNote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function dashboard()
  {
    $user = Auth::user();
    $today = Carbon::today();

    $doctorCount = User::count();
    $patientCount = Patient::count();
    $opdPatientCount = OpdCase::distinct('patient_id')->count('patient_id');
    $ipdPatientCount = IpdCase::distinct('patient_id')->count('patient_id');
    $operationalNoteCount = OperationalNote::count();
    $dischargePlanCount = DischargePlan::count();

    $doctorsAddedToday = User::whereDate('created_at', $today)->count();
    $patientsAddedToday = Patient::whereDate('created_at', $today)->count();
    $opdPatientsAddedToday = OpdCase::whereDate('created_at', $today)->distinct('patient_id')->count('patient_id');
    $ipdPatientsAddedToday = IpdCase::whereDate('created_at', $today)->distinct('patient_id')->count('patient_id');
    $operationalNotesAddedToday = OperationalNote::whereDate('created_at', $today)->count();
    $dischargePlansAddedToday = DischargePlan::whereDate('created_at', $today)->count();

    if ($user) {
      $roles = $user->getRoleNames();
      $role = $roles->first();

      return view('admin.dashboard', [
        'doctorCount' => $doctorCount,
        'patientCount' => $patientCount,
        'opdPatientCount' => $opdPatientCount,
        'ipdPatientCount' => $ipdPatientCount,
        'operationalNoteCount' => $operationalNoteCount,
        'dischargePlanCount' => $dischargePlanCount,
        'doctorsAddedToday' => $doctorsAddedToday,
        'patientsAddedToday' => $patientsAddedToday,
        'ipdPatientsAddedToday' => $ipdPatientsAddedToday,
        'opdPatientsAddedToday' => $opdPatientsAddedToday,
        'operationalNotesAddedToday' => $operationalNotesAddedToday,
        'dischargePlansAddedToday' => $dischargePlansAddedToday,
        'role' => $role
      ]);
    }
    return redirect('/')->with('error', 'Unauthorized access');
  }
}
