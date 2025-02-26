@extends('layouts/layoutMaster')

@section('title', 'Discharge Plans')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-user-list.js')
    @vite('resources/assets/js/discharge-plan-list.js')
@endsection

@section('content')

    <!-- Discharge Plan List Table -->
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
                    <h5 class="mb-0"> <i class="menu-icon tf-icons ti ti-checkup-list"> </i>
                        <b>Discharge Plan</b></h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('discharge-plan.create') }}" class="btn btn-primary">Add New Discharge Plan +</a>
                </div>
            </div>
        </div>


        <div class="card-datatable table-responsive">
            <table class="datatables-plans table">
                <thead class="border-top">
                    <tr>
                        <th>Plan ID</th>
                        <th>Paitent Name</th>
                        <th>Visit Number</th>
                        <th>Appointment Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>


    </div>

    {{-- @if (session('dischargePlan'))
        <!-- Modal -->
        <div class="modal fade show" id="dischargePlanModal" tabindex="-1" role="dialog"
            aria-labelledby="dischargePlanModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="auth-login-cover"
                            class="img-fluid my-5 auth-illustration" data-app-light-img="tmh-icons/Header.png"
                            data-app-dark-img="tmh-icons/Header.png ">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="dischargePlanContent">
                        <div class="row mb-3">

                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Patient's Name:</strong> {{ session('patient')->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Patient's gender:</strong> {{ session('patient')->gender }}</p>

                            </div>
                            <div class="col-md-4">
                                <p><strong>Patient's phone:</strong> {{ session('patient')->phone }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Patient's address:</strong> {{ session('patient')->address }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Patient's Diagnose:</strong> {{ session('ipdCase')->provisional_diagnose }}</p>
                            </div>
                        </div>
                        <hr>
                        <!-- Display discharge plan details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Operative Findings:</strong> {{ session('dischargePlan')->operative_findings }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Treatment in Hospital:</strong>
                                    {{ session('dischargePlan')->treatment_in_hospital }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Treatment for Home:</strong> {{ session('dischargePlan')->treatment_in_home }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <img src="{{ asset('assets/img/tmh-icons/Footer.png') }}" alt="Footer Image"
                            class="img-fluid my-5 auth-illustration" data-app-light-img="tmh-icons/Footer.png"
                            data-app-dark-img="tmh-icons/Footer.png">
                        <button type="button" id="print-btn" class="btn btn-primary">Print</button>
                        <button type="button" id="download-btn" class="btn btn-success">Download</button>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <!-- Plan Details Modal -->
    <div class="modal fade" id="dischargePlanModal" tabindex="-1" aria-labelledby="dischargePlanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="auth-login-cover"
                        class="img-fluid auth-illustration" data-app-light-img="tmh-icons/Header.png"
                        data-app-dark-img="tmh-icons/Header.png ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="plan-details">
                    <!-- Note details will be inserted here -->
                </div>
                <div class="modal-footer">
                    <img src="{{ asset('assets/img/tmh-icons/Footer.png') }}" alt="auth-login-cover"
                        class="img-fluid auth-illustration" data-app-light-img="tmh-icons/Footer.png"
                        data-app-dark-img="tmh-icons/Footer.png ">
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
