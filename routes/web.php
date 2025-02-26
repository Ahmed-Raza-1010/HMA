<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\IpdCaseController;
use App\Http\Controllers\OpdCaseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DischargePlanController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OperationalNoteController;

Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

  // Patient Routes
  Route::middleware(['can:manage patients'])->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
    Route::get('/create/patient', [PatientController::class, 'create'])->name('patient.create');
    Route::post('/store/patient', [PatientController::class, 'store'])->name('patient.store');
    Route::get('/view/patient/{id}', [PatientController::class, 'view'])->name('patient.view');
    Route::get('/edit/patient/{id}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::put('/update/patient/{id}', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/delete/patient/{id}', [PatientController::class, 'destroy'])->name('patient.destroy');
    Route::get('/getFilteredPatientData', [PatientController::class, 'getFilteredPatientData']);
    Route::get('/getPatientDetails/{id}', [PatientController::class, 'getPatientDetails']);
  });

  // Doctor Routes
  Route::middleware(['can:manage doctors'])->group(function () {
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/create/doctor', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/store/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/view/doctor/{id}', [DoctorController::class, 'view'])->name('doctor.view');
    Route::get('/edit/doctor/{id}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/update/doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::delete('/delete/doctor/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::get('/getFilteredDoctorData', [DoctorController::class, 'getFilteredDoctorData']);
    Route::get('/getDoctorDetails/{id}', [DoctorController::class, 'getDoctorDetails']);
  });

  // Profile Routes
  Route::middleware('auth')->group(function () {
    Route::get('/edit/password/{id}', [DoctorController::class, 'editPassword'])->name('doctor.edit-password');
    Route::put('/update/password/{id}', [DoctorController::class, 'updatePassword'])->name('doctor.update-password');
  });

  // IPD Routes
  Route::middleware(['can:manage ipd'])->group(function () {
    Route::get('/ipd-cases', [IpdCaseController::class, 'index'])->name('ipd-case.index');
    Route::get('/create/ipd-case', [IpdCaseController::class, 'create'])->name('ipd-case.create');
    Route::post('/store/ipd-case', [IpdCaseController::class, 'store'])->name('ipd-case.store');
    Route::get('/view/ipd-case/{id}', [IpdCaseController::class, 'view'])->name('ipd-case.view');
    Route::delete('/delete/ipd-case/{id}', [IpdCaseController::class, 'destroy'])->name('ipd-case.destroy');
    Route::get('/edit/ipd-case/{id}', [IpdCaseController::class, 'edit'])->name('ipd-case.edit');
    Route::put('/update/ipd-case/{id}', [IpdCaseController::class, 'update'])->name('ipd-case.update');
    Route::get('/getFilteredIPDData', [IpdCaseController::class, 'getFilteredIPDData']);
    Route::get('/getIPDCaseDetails/{id}', [IpdCaseController::class, 'getIPDCaseDetails']);
  });

  // OPD Routes
  Route::middleware(['can:manage opd'])->group(function () {
    Route::get('/opd-cases', [OpdCaseController::class, 'index'])->name('opd-case.index');
    Route::get('/create/opd-case', [OpdCaseController::class, 'create'])->name('opd-case.create');
    Route::post('/store/opd-case', [OpdCaseController::class, 'store'])->name('opd-case.store');
    Route::get('/view/opd-case/{id}', [OpdCaseController::class, 'view'])->name('opd-case.view');
    Route::get('/edit/opd-case/{id}', [OpdCaseController::class, 'edit'])->name('opd-case.edit');
    Route::put('/update/opd-case/{id}', [OpdCaseController::class, 'update'])->name('opd-case.update');
    Route::delete('/delete/opd-case/{id}', [OpdCaseController::class, 'destroy'])->name('opd-case.destroy');
    Route::get('/getFilteredOpdData', [OpdCaseController::class, 'getFilteredOpdData']);
    Route::get('/getOpdDetails/{id}', [OpdCaseController::class, 'getOpdDetails']);
  });

  // Operational Note Routes
  Route::middleware(['can:manage notes'])->group(function () {
    Route::get('/operational-notes', [OperationalNoteController::class, 'index'])->name('operational-note.index');
    Route::get('/create/operational-note', [OperationalNoteController::class, 'create'])->name('operational-note.create');
    Route::post('/store/operational-note', [OperationalNoteController::class, 'store'])->name('operational-note.store');
    Route::get('/view/operational-note/{id}', [OperationalNoteController::class, 'view'])->name('operational-note.view');
    Route::get('/edit/operational-note/{id}', [OperationalNoteController::class, 'edit'])->name('operational-note.edit');
    Route::put('/update/operational-note/{id}', [OperationalNoteController::class, 'update'])->name('operational-note.update');
    Route::delete('/delete/operational-note/{id}', [OperationalNoteController::class, 'destroy'])->name('operational-note.destroy');
    Route::get('/getFilteredNotesData', [OperationalNoteController::class, 'getFilteredNotesData']);
    Route::get('/getNoteDetails/{id}', [OperationalNoteController::class, 'getNoteDetails']);
  });

  //Discharge Plan
  Route::middleware(['can:manage discharge'])->group(function () {
    Route::get('/discharge-plan', [DischargePlanController::class, 'index'])->name('discharge-plan.index');
    Route::get('/create/discharge-plan', [DischargePlanController::class, 'create'])->name('discharge-plan.create');
    Route::post('/store/discharge-plan', [DischargePlanController::class, 'store'])->name('discharge-plan.store');
    Route::get('/view/discharge-plan/{id}', [DischargePlanController::class, 'view'])->name('discharge-plan.view');
    Route::get('/ipd-cases/{patientId}', [DischargePlanController::class, 'getIpdCasesByPatient']);
    Route::get('/edit/discharge-plan/{id}', [DischargePlanController::class, 'edit'])->name('discharge-plan.edit');
    Route::put('/update/discharge-plan/{id}', [DischargePlanController::class, 'update'])->name('discharge-plan.update');
    Route::delete('/delete/discharge-plan/{id}', [DischargePlanController::class, 'destroy'])->name('discharge-plan.destroy');
    Route::get('/getFilteredDischargeData', [DischargePlanController::class, 'getFilteredDischargeData']);
    Route::get('/getDischargeDetails/{id}', [DischargePlanController::class, 'getDischargeDetails']);
  });

 // Medicine Routes
 Route::middleware(['can:manage doctors'])->group(function () {
  Route::get('/medicines', [MedicineController::class, 'index'])->name('medicine.index');
  Route::get('/create/medicine', [MedicineController::class, 'create'])->name('medicine.create');
  Route::post('/store/medicine', [MedicineController::class, 'store'])->name('medicine.store');
  // Route::get('/view/medicine/{id}', [MedicineController::class, 'view'])->name('medicine.view');
   Route::get('/edit/medicine/{id}', [MedicineController::class, 'edit'])->name('medicine.edit');
   Route::put('/update/medicine/{id}', [MedicineController::class, 'update'])->name('medicine.update');
  Route::delete('/delete/medicine/{id}', [MedicineController::class, 'destroy'])->name('medicine.destroy');
  Route::get('/getFilteredMedicineData', [MedicineController::class, 'getFilteredMedicineData']);
// Route::get('/getMedicineDetails/{id}', [MedicineController::class, 'getMedicineDetails']);
});
  // Profile Routes
  // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
