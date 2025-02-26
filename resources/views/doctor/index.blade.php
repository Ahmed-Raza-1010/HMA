@extends('layouts.layoutMaster')

@section('title', 'Doctors List')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-user-list.js')
    @vite('resources/assets/js/doctors-list.js')
@endsection

@section('content')

    <!-- Doctors List Table -->
    <div class="card">

        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Display error messages from validation -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-header border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <b><i class="menu-icon tf-icons ti ti-users"> </i></i>User Management</b>
                    </h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('doctor.create') }}" class="btn btn-primary">Add New User +</a>
                </div>
            </div>
        </div>
        <div class="card-header border-bottom">
            <h5 class="card-title">Filter By</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="doctors">Doctor's Name</label>
                        <select class="select2 form-select text-capitalize" id="doctors" name="doctors">
                            <option selected="" value=""></option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->name }}">
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="designation">Designation</label>
                    <select id="designation" name="designation" class="form-select">
                        <option value="">{{ __('All') }}</option>
                        <option value="Doctor">Doctor</option>
                        <option value="Surgeon">Surgeon</option>
                        <option value="Assistant">Assistant</option>
                    </select>
                </div>
                <div class="col-md-5 text-md-end d-flex align-items-end">
                    <button type="button" class="btn btn-primary me-2" id="apply-filters">Apply Filters</button>
                    {{-- <button type="button" class="btn btn-primary" id="add-doctor">Add New Doctor +</button> --}}
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Designation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->id }}</td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->designation }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->email }}</td>
                            <td>
                                {{-- <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>  --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Doctor Details Modal -->
    <div class="modal fade" id="doctorDetailsModal" tabindex="-1" aria-labelledby="doctorDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="auth-login-cover"
                        class="img-fluid auth-illustration" data-app-light-img="tmh-icons/Header.png"
                        data-app-dark-img="tmh-icons/Header.png ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="doctor-details">
                    <!-- Doctor details will be inserted here -->
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
