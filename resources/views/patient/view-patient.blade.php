@extends('layouts/layoutMaster')

@section('title', 'View Patient')

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
<style>
  body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      width: 100%;
      box-sizing: border-box;
  }

  img {
      width: 100%;
      display: block;
  }

  .container {
      width: 100%;
      margin: 0 auto;
  }

  .row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -5px;
  }

  .h4 {
      margin: 10px 0;
      font-size: 18px;
      line-height: 1.2;
  }

  .col-md-6,
  .col-md-4,
  .col-md-12,
  .col-md-3,
  .col-md-2 {
      padding: 0 10px;
      box-sizing: border-box;
  }

  .col-md-6 {
      flex: 0 0 50%;
      max-width: 50%;
  }

  .col-md-4 {
      flex: 0 0 33.333%;
      max-width: 33.333%;
  }

  .col-md-3 {
      flex: 0 0 25%;
      max-width: 25%;
  }

  .col-md-2 {
      flex: 0 0 16.666%;
      max-width: 16.666%;
  }

  p {
      margin: 0;
      padding-right: 15px;
      font-size: 14px;
      line-height: 1.5;
  }

  hr {
      margin: 10px 0;
      border: 1px solid #ccc;
  }

  .mb-3 {
      margin-bottom: 10px;
  }

  .img-fluid {
      max-width: 100%;
      height: auto;
  }

  .btn {
      display: inline-block;
      padding: 10px 20px;
      margin: 10px;
      font-size: 16px;
      text-align: center;
      cursor: pointer;
      border: none;
      border-radius: 4px;
      color: #fff;
      background-color: #007bff;
      text-decoration: none;
  }

  .btn:hover {
      background-color: #0056b3;
  }
</style>

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
                    <h5 class="mb-0"><i class="menu-icon tf-icons ti ti-heart-rate-monitor"></i>
                        <b>Patient Details</b>
                    </h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <button type="button" id="print-btn" class="btn btn-primary m-2">Print</button>
                    <button type="button" id="download-pdf-btn" class="btn btn-primary m-2">Download</button>
                </div>
            </div>
        </div>
        <!-- Header Image -->
        <div class="text-center mb-2">
            <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="Header Image" class=" my-3"
                style="max-width: 100%; height: auto;">
        </div>
        <div class="container my-5 px-4">
            <!-- Patient Information -->
            <div class="ps-2 mb-4">
                <h2 class="h4 mb-4"><b>Patient Information</b></h2>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <p><strong>Name:</strong> {{ $patient->name }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Address:</strong> {{ $patient->address }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>City:</strong> {{ $patient->city }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Height:</strong> {{ $patient->height }} FT IN</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Weight:</strong> {{ $patient->weight }} KG</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Pulse:</strong> {{ $patient->pulse }} BPM</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Blood Pressure:</strong> {{ $patient->blood_pressure }} MM HG</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <p><strong>Temprature:</strong> {{ $patient->temperature }} °C</p>
                    </div>
                </div>
                <hr>
            </div>
            <!-- Discharge Plan Details -->
        </div>
        <!-- Footer Image -->
        <div class="text-center mt-4">
            <img src="{{ asset('assets/img/tmh-icons/Footer.png') }}" alt="Footer Image" class="img-fluid my-3"
                style="max-width: 100%; height: auto;">
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle Print button click
            document.getElementById('print-btn')?.addEventListener('click', function() {
                var modalContent = document.querySelector('.container').innerHTML;
                var headerImage = '{{ asset('assets/img/tmh-icons/Header.png') }}';
                var footerImage = '{{ asset('assets/img/tmh-icons/Footer.png') }}';

                var printWindow = window.open('', '', 'height=600,width=800');
                var content = `
                    <html>
                    <head>
                        <title>Patient Details</title>
                        <style>
                            body, html {
                                height: 100%;
                                margin: 0;
                                padding: 0;
                                font-family: Arial, sans-serif;
                            }
                            img {
                                width: 100%;
                                display: block;
                            }
                            .container {
                                width: 90%;
                                margin: 0 auto;
                                flex: 1 0 auto; /* Ensure the container takes up the remaining space */
                            }
                            .footer {
                                position: absolute;
                                bottom: 0;
                                width: 100%;
                            }
                            .wrapper {
                                display: flex;
                                flex-direction: column;
                                min-height: 100vh;
                            }
                            .row {
                                display: flex;
                                flex-wrap: wrap;
                                margin: -15px;
                            }
                            .col-md-6, .col-md-4, .col-md-12 {
                                padding: 15px;
                                box-sizing: border-box;
                            }
                            .col-md-6 {
                                flex: 0 0 50%;
                                max-width: 50%;
                            }
                            .col-md-4 {
                                flex: 0 0 33.333%;
                                max-width: 33.333%;
                            }
                            p {
                                margin: 0;
                            }
                            hr {
                                margin: 20px 0;
                            }
                            .mb-3 {
                                margin-bottom: 20px;
                            }
                            .img-fluid {
                                max-width: 100%;
                                height: auto;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="wrapper">
                            <img src="${headerImage}" alt="Header Image">
                            <div class="container">
                                ${modalContent}
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="footer">
                                <img src="${footerImage}" alt="Footer Image">
                            </div>
                        </div>
                    </body>
                    </html>
                `;
                printWindow.document.write(content);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
            });
        });

        // Function to handle Download button click
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('download-pdf-btn')?.addEventListener('click', function() {
                var modalContent = document.querySelector('.container');
                var headerImage = '{{ asset('assets/img/tmh-icons/Header.png') }}';
                var footerImage = '{{ asset('assets/img/tmh-icons/Footer.png') }}';

                const originalWidth = 2048; // Original width of your image in pixels
                const originalHeight = 443; // Original height of your image in pixels
                const pdfWidth = 190; // Desired width in the PDF in millimeters

                // Calculate height based on the aspect ratio
                const aspectRatio = originalHeight / originalWidth;
                const pdfHeight = pdfWidth * aspectRatio;

                html2canvas(modalContent).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');

                    const {
                        jsPDF
                    } = window.jspdf;
                    var pdf = new jsPDF('p', 'mm', 'a4');

                    var header = new Image();
                    header.src = headerImage;
                    header.onload = function() {
                        pdf.addImage(header, 'PNG', 10, 10, pdfWidth, pdfHeight);

                        pdf.addImage(imgData, 'PNG', 10, 60, 190, 0);

                        var footer = new Image();
                        footer.src = footerImage;
                        footer.onload = function() {
                            pdf.addImage(footer, 'PNG', 10, pdf.internal.pageSize.height -
                                30, 190, 20);

                            // Trigger the Save As dialog
                            pdf.save('Patient_Details.pdf');
                        };
                    };
                });
            });
        });
        var baseUrl = "{{ url('/') }}";
        var csrfToken = "{{ csrf_token() }}";
        var headerImage = "{{ asset('assets/img/tmh-icons/Header.png') }}";
        var footerImage = "{{ asset('assets/img/tmh-icons/Footer.png') }}";
    </script>
@endsection
