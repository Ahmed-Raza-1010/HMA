@extends('layouts/layoutMaster')

@section('title', 'Edit Profile')

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
@endsection

@section('content')

    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">

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

        <div class="card-header border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <b><i class="menu-icon tf-icons ti ti-users"> </i></i>Edit Profile</b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="doctor-form" class="card-body" method="POST" action="{{ route('doctor.update-password', $user->id) }}">
            @csrf
            @method('PUT')
            <h6>BASIC INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="John Doe"
                        value="{{ old('name', $user->name) }}" />
                    <span id="name-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control email"
                        placeholder="email@email.com" value="{{ old('email', $user->email) }}" />
                    <span id="email-error" style="color: red; display: none;">Enter a valid email address.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="gender">Gender</label>
                    <select id="gender" name="gender" class="form-select" data-allow-clear="true"
                        aria-label="Select gender" aria-required="true">
                        <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                    <span id="gender-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="phone">Phone No</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="0312-1234567"
                        aria-label="0312-1234567" value="{{ old('phone', $user->phone) }}" />
                    <span id="phone-error" style="color: red; display: none;">Enter a valid phone number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="password">Password (Optional)</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter new password" aria-label="New password" />
                    <span id="password-error" style="color: red; display: none;">Enter a valid password.</span>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                <button type="reset" class="btn btn-label-secondary"
                    onclick="window.location.href='/doctors';">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function formatPhoneNumber(inputElement) {
                let value = inputElement.value.replace(/\D/g, '');

                if (value.length > 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4);
                }

                inputElement.value = value;
            }

            function validatePhoneNumber(inputElement, errorMessageElement) {
                const value = inputElement.value;
                const regex = /^\d{4}-\d{7}$/; // Matches formats like 0312-1234567

                if (value === '') {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                } else if (!regex.test(value)) {
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                }
            }

            // Function to validate password
            function validatePassword(passwordElement, errorMessageElement) {
                const value = passwordElement.value;

                if (value === '') {
                    // No password entered, so it's considered valid
                    errorMessageElement.style.display = 'none';
                    passwordElement.style.borderColor = '';
                    return true;
                } else if (value.length < 8) {
                    // Password too short
                    errorMessageElement.textContent = 'Password must be at least 8 characters long.';
                    errorMessageElement.style.display = 'block';
                    passwordElement.style.borderColor = 'red';
                    return false;
                } else {
                    // Password valid
                    errorMessageElement.style.display = 'none';
                    passwordElement.style.borderColor = '';
                    return true;
                }
            }

            // General validation function for text inputs
            function validateInput(inputElement, errorMessageElement, type = 'text') {
                let isValid = true;

                if (inputElement.value.trim() === '') {
                    errorMessageElement.textContent = 'Field required.';
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    isValid = false;
                } else if (type === 'email' && !validateEmail(inputElement.value)) {
                    errorMessageElement.textContent = 'Enter a valid Gmail address.';
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    isValid = false;
                } else {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                }

                return isValid;
            }

            // Validation function for selection
            function validateSelection(selectElement, errorMessageElement) {
                if (selectElement.value === '') {
                    errorMessageElement.style.display = 'block';
                    selectElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    selectElement.style.borderColor = '';
                    return true;
                }
            }

            // Function to validate email format
            function validateEmail(email) {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailPattern.test(email);
            }

            // Set up event listeners for validation
            document.getElementById('name').addEventListener('input', function() {
                validateSelection(this, document.getElementById('name-error'));
            });

            document.getElementById('email').addEventListener('input', function() {
                validateInput(this, document.getElementById('email-error'), 'email');
            });

            document.getElementById('gender').addEventListener('change', function() {
                validateSelection(this, document.getElementById('gender-error'));
            });

            document.getElementById('phone').addEventListener('blur', function() {
                formatPhoneNumber(this);
                validatePhoneNumber(this, document.getElementById('phone-error'));
            });

            document.getElementById('password').addEventListener('blur', function() {
                validatePassword(this, document.getElementById('password-error'));
            });

            // Add form validation on submit
            document.getElementById('doctor-form').addEventListener('submit', function(event) {
                const isNameValid = validateInput(document.getElementById('name'), document.getElementById(
                    'name-error'));
                const isEmailValid = validateInput(document.getElementById('email'), document
                    .getElementById('email-error'), 'email');
                const isGenderSelected = validateSelection(document.getElementById('gender'), document
                    .getElementById('gender-error'));
                const isPhoneValid = validatePhoneNumber(document.getElementById('phone'), document
                    .getElementById('phone-error')) && validateSelection(document.getElementById(
                    'phone'), document.getElementById('phone-error'));
                const isPasswordValid = validatePassword(document.getElementById('password'), document
                    .getElementById('password-error'));


                if (!isNameValid || !isEmailValid || !isGenderSelected || !isPhoneValid || !
                    isPasswordValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                }
            });

        });
    </script>

@endsection
