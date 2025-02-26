@extends('layouts.layoutMaster')

@section('title', 'IPD Cases List')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-user-list.js')
    @vite('resources/assets/js/ipd-cases-list.js')
@endsection

@section('content')

    <!-- IPD Cases List Table -->
    <div class="card">

        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Display error message -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-header border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <b><i class="menu-icon tf-icons ti ti-emergency-bed"> </i></i>IPD Management</b>
                    </h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('ipd-case.create') }}" class="btn btn-primary">Add New IPD Case +</a>
                </div>
            </div>
        </div>
        <div class="card-header border-bottom">
            <h5 class="card-title">Filter By</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="patient_name">Patient's Name</label>
                        <select class="select2 form-select text-capitalize" id="patient_name" name="patient_name">
                            <option selected="" value="">
                            </option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->name }}">
                                    {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
          

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="appointment_date">Filter by Appointment Date</label>
                        <input type="date" id="appointment_date" name="appointment_date" class="form-control">
                    </div>
                </div>

                <div class="col-md-4 text-md-end d-flex align-items-end">
                    <button type="button" class="btn btn-primary me-2" id="apply-filters">Apply Filters</button>
                    {{-- <a href="{{ route('ipd-case.create') }}" class="btn btn-primary">Add New IPD +</a> --}}
                </div>
            </div>
        </div>


        <div class="card-datatable table-responsive">
            <table class="datatables-ipd-cases table">
                <thead class="border-top">
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Gender</th>
                        <th>Diagnose</th>
                        <th>Phone</th>
                        <th>Actions</th>


                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Diagnose Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Provisional Diagnose</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="diagnose-details">
                    <!-- IPD Details will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- IPD Case Details Modal -->
    <div class="modal fade" id="ipdCaseDetailsModal" tabindex="-1" aria-labelledby="ipdCaseDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" class="img-fluid auth-illustration"
                        data-app-light-img="tmh-icons/Header.png" data-app-dark-img="tmh-icons/Header.png ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ipd-details">
                    <!-- IPD case details will be inserted here -->
                </div>
                <div class="modal-footer">
                    <img src="{{ asset('assets/img/tmh-icons/Footer.png') }}" class="img-fluid auth-illustration"
                        data-app-light-img="tmh-icons/Footer.png" data-app-dark-img="tmh-icons/Footer.png ">
                    <button type="button" class="btn btn-primary" id="print-btn">Print</button>
                    {{-- <button type="button" class="btn btn-success" id="download-btn">Download</button> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        var baseUrl = "{{ url('/') }}";
        var csrfToken = "{{ csrf_token() }}";
        var headerImage = "{{ asset('assets/img/tmh-icons/Header.png') }}";
        var footerImage = "{{ asset('assets/img/tmh-icons/Footer.png') }}";
        var canDelete = @json($canDelete);
    </script>

@endsection
