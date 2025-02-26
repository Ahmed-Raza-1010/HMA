@extends('layouts/layoutMaster')

@section('title', 'Create Discharge Plan')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/form-layouts.js'])
    @vite(['resources/assets/js/discharge-plan-list.js'])
@endsection

@section('content')

    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <div class="card-header border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"> <i class="menu-icon tf-icons ti ti-checkup-list"> </i>
                        <b>Create Discharge Plan</b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="discharge-plan-form" class="card-body" action="{{ route('discharge-plan.store') }}" method="POST">
            @csrf
            <h6>BASIC INFORMATION</h6>

            <!-- Patient Selection -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="patient_id">Patient's Name</label>
                        @php
                            $selectedPatientID = isset($patientID) ? $patientID : null;
                            $selectedipdID = isset($ipdID) ? $ipdID : null;
                        @endphp
                        <!-- Hidden input to pass the pre-selected patient ID -->
                        <input type="hidden" id="pre-selected-patient-id" value="{{ $selectedPatientID }}">
                        <select class="select2 form-select text-capitalize" id="patient_id" name="patient_id">
                            <option value="" disabled {{ is_null($selectedPatientID) ? 'selected' : '' }}>
                                {{ __('Select Patient') }}</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" data-name="{{ $patient->name }}"
                                    data-gender="{{ $patient->gender }}" data-age="{{ $patient->age }}"
                                    data-phone="{{ $patient->phone }}" data-address="{{ $patient->address }}"
                                    {{ $lastIpdCase && $lastIpdCase->patient_id == $patient->id ? 'selected' : '' }}
                                    {{ $patient->id == $selectedPatientID ? 'selected' : '' }}>
                                    {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                        <span id="patient-error" style="color: red; display: none;">Please make a selection.</span>
                    </div>
                </div>

                <!-- IPD Case Selection -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="ipd_case">IPD Case</label>
                        <input type="hidden" id="pre-selected-ipd-case-id" value="{{ $ipdID ?? '' }}">
                        <select class="select2 form-select text-capitalize" id="ipd_case" name="ipd_case">
                            <option value="" disabled>{{ __('Select IPD Case') }}</option>
                            @foreach ($ipdCases as $case)
                                <option value="{{ $case->id }}"
                                    data-special_instruction="{{ $case->special_instruction ?? '' }}"
                                    data-provisional_diagnose="{{ $case->provisional_diagnose ?? '' }}"
                                    data-patient_id="{{ $case->patient_id }}"
                                    {{ $lastIpdCase && $lastIpdCase->id == $case->id ? 'selected' : '' }}
                                    {{ $case->id == $ipdID ? 'selected' : '' }}>
                                    {{ $case->appointment_date }}
                                </option>
                            @endforeach
                        </select>
                        <span id="ipd-case-error" style="color: red; display: none;">Please make a selection.</span>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="name">Patient's Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="John Doe"
                        value="{{ $lastIpdCase && $lastIpdCase->patient ? $lastIpdCase->patient->name : '' }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="gender">Gender</label>
                    <input type="text" name="gender" id="gender" class="form-control" placeholder="Gender"
                        value="{{ $lastIpdCase && $lastIpdCase->patient ? $lastIpdCase->patient->gender : '' }}"
                        readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" placeholder="Age"
                        value="{{ $lastIpdCase && $lastIpdCase->patient ? $lastIpdCase->patient->age : '' }}" readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="multicol-provisional_diagnose">Provisional Diagnose</label>
                    <input type="text" name="provisional_diagnose" id="provisional_diagnose" class="form-control"
                        placeholder="Provisional Diagnose"
                        value="{{ $lastIpdCase && $lastIpdCase->ipdCase ? $lastIpdCase->ipdCase->provisional_diagnose : '' }}"
                        readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="phone">Phone No</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="0312 3456789"
                        value="{{ $lastIpdCase && $lastIpdCase->patient ? $lastIpdCase->patient->phone : '' }}" readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="multicol-address">Address</label>
                    <textarea id="address" name="address" class="form-control" placeholder="Address here"
                        style="height: 110px; resize: none;" readonly>{{ $lastIpdCase && $lastIpdCase->patient ? $lastIpdCase->patient->address : '' }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="operative_findings">Diagnose Findings</label>
                    <textarea id="operative_findings" name="operative_findings" class="form-control" placeholder="Findings here"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="findings-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr />
            <!-- Treatment Details -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="treatment_in_hospital">Treatment in Hospital</label>
                    <textarea id="treatment_in_hospital" name="treatment_in_hospital" class="form-control"
                        placeholder="Treatment in Hospital" style="height: 110px; resize: none;"></textarea>
                    <span id="hospital-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="treatment_in_home">Treatment in Home</label>
                    <textarea id="treatment_in_home" name="treatment_in_home" class="form-control" placeholder="Treatment in Home"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="home-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="special_instruction">Special Instruction</label>
                    <textarea id="special_instruction" name="special_instruction" class="form-control" placeholder="Special instruction"
                        style="height: 110px; resize: none;" readonly>{{ $lastIpdCase && $lastIpdCase->ipdCase ? $lastIpdCase->ipdCase->special_instruction : '' }}</textarea>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Save</button>
                <button type="reset" onclick="window.location.href='{{ route('discharge-plan.index') }}'"
                    class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Initialize Select2
            $('#patient_id').select2();
            $('#ipd_case').select2();

            // Function to populate IPD cases based on selected patient
            function populateIpdCases() {
                const patientSelect = document.getElementById('patient_id');
                const ipdCaseSelect = document.getElementById('ipd_case');
                const selectedPatientId = patientSelect.value;

                ipdCaseSelect.innerHTML = '<option value="" disabled>{{ __('Select IPD Case') }}</option>';

                @foreach ($ipdCases as $case)
                    if ("{{ $case->patient_id }}" === selectedPatientId) {
                        const option = document.createElement('option');
                        option.value = "{{ $case->id }}";
                        option.dataset.special_instruction = "{{ $case->special_instruction ?? '' }}";
                        option.dataset.provisional_diagnose = "{{ $case->provisional_diagnose ?? '' }}";
                        option.textContent = `Appointment Date: {{ $case->appointment_date }}`;
                        ipdCaseSelect.appendChild(option);
                    }
                @endforeach

                // Reset IPD case selection and fields
                // document.getElementById('ipd_case').value = '';
                $('#ipd_case').val(null).trigger('change'); // Select2 specific code
                document.getElementById('provisional_diagnose').value = '';
                document.getElementById('special_instruction').value = '';
            }

            // Function to populate fields based on pre-selected or selected values
            function populateFields() {
                const patientSelect = document.getElementById('patient_id');
                const ipdCaseSelect = document.getElementById('ipd_case');

                // Function to populate patient fields
                function populatePatientFields(patientId) {
                    const patientOptions = patientSelect.options;
                    for (let i = 0; i < patientOptions.length; i++) {
                        if (patientOptions[i].value === patientId) {
                            patientSelect.selectedIndex = i;
                            const selectedOption = patientOptions[i];
                            document.getElementById('name').value = selectedOption.getAttribute('data-name');
                            document.getElementById('gender').value = selectedOption.getAttribute('data-gender');
                            document.getElementById('age').value = selectedOption.getAttribute('data-age');
                            document.getElementById('phone').value = selectedOption.getAttribute('data-phone');
                            document.getElementById('address').value = selectedOption.getAttribute('data-address');
                            populateIpdCases(); // Populate IPD cases based on selected patient
                            break;
                        }
                    }
                }

                // Function to populate IPD case fields
                function populateIpdCaseFields(ipdCaseId) {
                    const ipdCaseOptions = ipdCaseSelect.options;
                    for (let i = 0; i < ipdCaseOptions.length; i++) {
                        if (ipdCaseOptions[i].value === ipdCaseId) {
                            ipdCaseSelect.selectedIndex = i;
                            const selectedOption = ipdCaseOptions[i];
                            document.getElementById('provisional_diagnose').value = selectedOption.getAttribute(
                                'data-provisional_diagnose');
                            document.getElementById('special_instruction').value = selectedOption.getAttribute(
                                'data-special_instruction');
                            break;
                        }
                    }
                }

                // Get pre-selected values
                const preSelectedPatientId = document.getElementById('pre-selected-patient-id').value;
                const preSelectedIpdCaseId = document.getElementById('pre-selected-ipd-case-id').value;

                // Populate fields based on pre-selected IDs or selected values
                if (preSelectedPatientId) {
                    populatePatientFields(preSelectedPatientId);
                } else {
                    // No pre-selected patient, but if a patient is selected, populate
                    const selectedPatientValue = patientSelect.value;
                    if (selectedPatientValue) {
                        populatePatientFields(selectedPatientValue);
                    }
                }

                if (preSelectedIpdCaseId) {
                    populateIpdCaseFields(preSelectedIpdCaseId);
                } else {
                    // No pre-selected IPD case, but if IPD cases are populated, select the latest one
                    if (ipdCaseSelect.options.length > 1) {
                        // Select the latest IPD case (assuming the latest is the last option)
                        const latestIpdCaseOption = ipdCaseSelect.options[ipdCaseSelect.options.length - 1];
                        ipdCaseSelect.selectedIndex = ipdCaseSelect.options.length - 1;
                        document.getElementById('provisional_diagnose').value = latestIpdCaseOption.getAttribute(
                            'data-provisional_diagnose');
                        document.getElementById('special_instruction').value = latestIpdCaseOption.getAttribute(
                            'data-special_instruction');
                    }
                }
                $('#ipd_case').select2(); // Reinitialize Select2
            }

            populateFields();

            // Handle patient selection change
            // document.getElementById('patient_id').addEventListener('change', function() {
            $('#patient_id').on('change', function() {
                const selectedPatientValue = this.value;
                const patientOptions = this.options;
                for (let i = 0; i < patientOptions.length; i++) {
                    if (patientOptions[i].value === selectedPatientValue) {
                        const selectedOption = patientOptions[i];
                        document.getElementById('name').value = selectedOption.getAttribute('data-name');
                        document.getElementById('gender').value = selectedOption.getAttribute(
                            'data-gender');
                        document.getElementById('age').value = selectedOption.getAttribute('data-age');
                        document.getElementById('phone').value = selectedOption.getAttribute('data-phone');
                        document.getElementById('address').value = selectedOption.getAttribute(
                            'data-address');
                        populateIpdCases(); // Update IPD cases based on the selected patient
                        break;
                    }
                }
            });

            // Handle IPD case selection change
            // document.getElementById('ipd_case').addEventListener('change', function() {
            $('#ipd_case').on('change', function() {
                const selectedIpdCaseValue = this.value;
                const ipdCaseOptions = this.options;
                for (let i = 0; i < ipdCaseOptions.length; i++) {
                    if (ipdCaseOptions[i].value === selectedIpdCaseValue) {
                        const selectedOption = ipdCaseOptions[i];
                        document.getElementById('provisional_diagnose').value = selectedOption.getAttribute(
                            'data-provisional_diagnose');
                        document.getElementById('special_instruction').value = selectedOption.getAttribute(
                            'data-special_instruction');
                        break;
                    }
                }
            });

            // Form validation
            function validateSelection(input, errorElement) {
                if (!input.value) {
                    errorElement.style.display = 'inline';
                } else {
                    errorElement.style.display = 'none';
                }
            }

            document.getElementById('discharge-plan-form').addEventListener('submit', function(e) {
                const patientSelect = document.getElementById('patient_id');
                const ipdCaseSelect = document.getElementById('ipd_case');
                const findings = document.getElementById('operative_findings');
                const hospital = document.getElementById('treatment_in_hospital');
                const home = document.getElementById('treatment_in_home');

                validateSelection(patientSelect, document.getElementById('patient-error'));
                validateSelection(ipdCaseSelect, document.getElementById('ipd-case-error'));
                validateSelection(findings, document.getElementById('findings-error'));
                validateSelection(hospital, document.getElementById('hospital-error'));
                validateSelection(home, document.getElementById('home-error'));

                if (!patientSelect.value || !ipdCaseSelect.value || !findings.value || !hospital.value || !
                    home.value) {
                    e.preventDefault(); // Prevent form submission if validation fails
                }
            });
        });
    </script>
@endsection
