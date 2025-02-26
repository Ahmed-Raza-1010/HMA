@extends('layouts/layoutMaster')

@section('title', 'Operational Notes')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-user-list.js')
    @vite('resources/assets/js/operational-notes-list.js')
@endsection

@section('content')

    <!-- Users List Table -->
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
                    <h5 class="mb-0"> <i class="menu-icon tf-icons ti ti-notes"> </i>
                        <b>Operational Notes</b></h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="add-note">Add New Operational Note +</button>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-notes table">
                <thead class="border-top">
                    <tr>
                        <th>Note ID</th>
                        <th>Paitent Name</th>
                        <th>Surgeon Name</th>
                        <th>Appointment Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>

    {{-- @if (session('oprNote'))
        <!-- Modal -->
        <div class="modal fade show" id="oprNoteModal" tabindex="-1" role="dialog" aria-labelledby="oprNoteModalLabel"
            aria-hidden="true" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="auth-login-cover"
                            class="img-fluid my-5 auth-illustration" data-app-light-img="tmh-icons/Header.png"
                            data-app-dark-img="tmh-icons/Header.png ">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="oprNoteContent">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Patient's Name:</strong> {{ session('patient')->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Procedure's Name:</strong> {{ session('oprNote')->procedure_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Surgeon:</strong> {{ session('surgeon')->name }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Assistant:</strong> {{ session('assistant')->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Indication of Surgery:</strong> {{ session('oprNote')->indication_of_surgery }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Operative Findings:</strong> {{ session('oprNote')->operative_findings }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Post Operation Orders:</strong> {{ session('oprNote')->post_operation_orders }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Special Instruction:</strong> {{ session('oprNote')->special_instruction }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <img src="{{ asset('assets/img/tmh-icons/Footer.png') }}" alt="auth-login-cover"
                            class="img-fluid my-5 auth-illustration" data-app-light-img="tmh-icons/Footer.png"
                            data-app-dark-img="tmh-icons/Footer.png ">
                        <button type="button" id="print-btn" class="btn btn-primary">Print</button>
                        <button type="button" id="download-btn" class="btn btn-success">Download</button>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <!-- Note Details Modal -->
    <div class="modal fade" id="noteDetailsModal" tabindex="-1" aria-labelledby="noteDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="auth-login-cover"
                        class="img-fluid auth-illustration" data-app-light-img="tmh-icons/Header.png"
                        data-app-dark-img="tmh-icons/Header.png ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="note-details">
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
