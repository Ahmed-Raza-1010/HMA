@extends('layouts/layoutMaster')

@section('title', 'TMH System')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

@section('content')

    <div class="row">
        <div class="row g-2 mb-4">
            <div class="col-sm-6 col-xl-3">
                @if (Auth::user()->hasRole('admin') || Auth::user()->can('manage doctors'))
                    <a href="{{ route('doctor.index') }}" class="card text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <h6>Doctors</h6>
                                        <div class="d-flex align-items-end mt-2">
                                            <h3 class="mb-0 me-2">{{ $doctorCount }}</h3>
                                            <small>Total Doctors</small>
                                        </div>
                                        <hr />
                                        <small class="{{ $doctorsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                            (Added today: {{ $doctorsAddedToday }})
                                        </small>
                                    </div>
                                    <span class="badge bg-label-primary rounded p-2">
                                        <i class="ti ti-users-group ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <h6>Doctors</h6>
                                    <div class="d-flex align-items-end mt-2">
                                        <h3 class="mb-0 me-2">{{ $doctorCount }}</h3>
                                        <small>Total Doctors</small>
                                    </div>
                                    <hr />
                                    <small class="{{ $doctorsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                        (Added today: {{ $doctorsAddedToday }})
                                    </small>
                                </div>
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class="ti ti-users-group ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-xl-3">
                @if (Auth::user()->hasRole('admin') || Auth::user()->can('manage patients'))
                    <a href="{{ route('patient.index') }}" class="card text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <h6>Patients</h6>
                                        <div class="d-flex align-items-end mt-2">
                                            <h3 class="mb-0 me-2">{{ $patientCount }}</h3>
                                            <small>Total Patients</small>
                                        </div>
                                        <hr />
                                        <small class="{{ $patientsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                            (Added today: {{ $patientsAddedToday }})
                                        </small>
                                    </div>
                                    <span class="badge bg-label-primary rounded p-2">
                                        <i class="ti ti-heart-rate-monitor ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <h6>Patients</h6>
                                    <div class="d-flex align-items-end mt-2">
                                        <h3 class="mb-0 me-2">{{ $patientCount }}</h3>
                                        <small>Total Patients</small>
                                    </div>
                                    <hr />
                                    <small class="{{ $patientsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                        (Added today: {{ $patientsAddedToday }})
                                    </small>
                                </div>
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class="ti ti-heart-rate-monitor ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-xl-3">
                @if (Auth::user()->hasRole('admin') || Auth::user()->can('manage ipd'))
                    <a href="{{ route('ipd-case.index') }}" class="card text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <h6>Inpatient Dept.</h6>
                                        <div class="d-flex align-items-end mt-2">
                                            <h3 class="mb-0 me-2">{{ $ipdPatientCount }}</h3>
                                            <small>Inpatient Records</small>
                                        </div>
                                        <hr />
                                        <small class="{{ $ipdPatientsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                            (Added today: {{ $ipdPatientsAddedToday }})
                                        </small>
                                    </div>
                                    <span class="badge bg-label-danger rounded p-2">
                                        <i class="ti ti-emergency-bed ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <h6>Inpatient Dept.</h6>
                                    <div class="d-flex align-items-end mt-2">
                                        <h3 class="mb-0 me-2">{{ $ipdPatientCount }}</h3>
                                        <small>Inpatient Records</small>
                                    </div>
                                    <hr />
                                    <small class="{{ $ipdPatientsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                        (Added today: {{ $ipdPatientsAddedToday }})
                                    </small>
                                </div>
                                <span class="badge bg-label-danger rounded p-2">
                                    <i class="ti ti-emergency-bed ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-xl-3">
                @if (Auth::user()->hasRole('admin') || Auth::user()->can('manage ipd'))
                    <a href="{{ route('opd-case.index') }}" class="card text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <h6>Outpatient Dept.</h6>
                                        <div class="d-flex align-items-end mt-2">
                                            <h3 class="mb-0 me-2">{{ $opdPatientCount }}</h3>
                                            <small>Outpatient Records</small>
                                        </div>
                                        <hr />
                                        <small class="{{ $opdPatientsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                            (Added today: {{ $opdPatientsAddedToday }})
                                        </small>
                                    </div>
                                    <span class="badge bg-label-danger rounded p-2">
                                        <i class="ti ti-first-aid-kit ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <h6>Outpatient Dept.</h6>
                                    <div class="d-flex align-items-end mt-2">
                                        <h3 class="mb-0 me-2">{{ $opdPatientCount }}</h3>
                                        <small>Outpatient Records</small>
                                    </div>
                                    <hr />
                                    <small class="{{ $opdPatientsAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                        (Added today: {{ $opdPatientsAddedToday }})
                                    </small>
                                </div>
                                <span class="badge bg-label-danger rounded p-2">
                                    <i class="ti ti-first-aid-kit ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-xl-3">
                @if (Auth::user()->hasRole('admin') || Auth::user()->can('manage notes'))
                    <a href="{{ route('operational-note.index') }}" class="card text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <h6>Operational Notes</h6>
                                        <div class="d-flex align-items-end mt-2">
                                            <h3 class="mb-0 me-2">{{ $operationalNoteCount }}</h3>
                                            <small>Operational Notes</small>
                                        </div>
                                        <hr />
                                        <small
                                            class="{{ $operationalNotesAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                            (Added today: {{ $operationalNotesAddedToday }})
                                        </small>
                                    </div>
                                    <span class="badge bg-label-warning rounded p-2">
                                        <i class="ti ti-notes ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <h6>Operational Notes</h6>
                                    <div class="d-flex align-items-end mt-2">
                                        <h3 class="mb-0 me-2">{{ $operationalNoteCount }}</h3>
                                        <small>Operational Notes</small>
                                    </div>
                                    <hr />
                                    <small class="{{ $operationalNotesAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                        (Added today: {{ $operationalNotesAddedToday }})
                                    </small>
                                </div>
                                <span class="badge bg-label-warning rounded p-2">
                                    <i class="ti ti-notes ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-xl-3">
              @if (Auth::user()->hasRole('admin') || Auth::user()->can('manage discharge'))
                  <a href="{{ route('discharge-plan.index') }}" class="card text-decoration-none">
                      <div class="card">
                          <div class="card-body">
                              <div class="d-flex align-items-start justify-content-between">
                                  <div class="content-left">
                                      <h6>Discharge Plans</h6>
                                      <div class="d-flex align-items-end mt-2">
                                          <h3 class="mb-0 me-2">{{ $dischargePlanCount }}</h3>
                                          <small>Discharge Plans</small>
                                      </div>
                                      <hr />
                                      <small
                                          class="{{ $dischargePlansAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                          (Added today: {{ $dischargePlansAddedToday }})
                                      </small>
                                  </div>
                                  <span class="badge bg-label-success rounded p-2">
                                      <i class="ti ti-checkup-list ti-sm"></i>
                                  </span>
                              </div>
                          </div>
                      </div>
                  </a>
              @else
                  <div class="card">
                      <div class="card-body">
                          <div class="d-flex align-items-start justify-content-between">
                              <div class="content-left">
                                  <h6>Discharge Plans</h6>
                                  <div class="d-flex align-items-end mt-2">
                                      <h3 class="mb-0 me-2">{{ $dischargePlanCount }}</h3>
                                      <small>Discharge Plans</small>
                                  </div>
                                  <hr />
                                  <small class="{{ $dischargePlansAddedToday > 0 ? 'text-primary' : 'text-danger' }}">
                                      (Added today: {{ $dischargePlansAddedToday }})
                                  </small>
                              </div>
                              <span class="badge bg-label-success rounded p-2">
                                  <i class="ti ti-checkup-list ti-sm"></i>
                              </span>
                          </div>
                      </div>
                  </div>
              @endif
          </div>
        </div>
    @endsection
