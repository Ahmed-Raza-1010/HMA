$(document).ready(function () {
  // Initial data fetch when page loads
  getFilteredOpdData();


  //Custom Selct2 Placeholder
  $('#patients').select2({
    placeholder: "Select a patient", // Custom placeholder for patients
    allowClear: true
  });

  $('#patient_id').select2({
    placeholder: "Select a patient", // Custom placeholder for patient_id
    allowClear: true
  });

  $('#doctor_id').select2({
    placeholder: "Select a doctor", // Custom placeholder for doctor_id
    allowClear: true
  });
  // Function to handle Print button click
  $('#print-btn').click(function () {
    var printWindow = window.open('', '', 'height=600,width=800');

    var patientDetailsContent = document.getElementById('patient-details').innerHTML;
    var opdDetailsContent = document.getElementById('opd-details').innerHTML;

    // Full content including header and footer images
    var content = `
        <html>
        <head>
            <title>OPD Details</title>
            <style>
                body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                width: 100%;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                align-items: center; /* Center content horizontally */
              }
              .header-img, .footer-img {
                  display: block;
                  width: 60%; /* Set width to 60% of the viewport width */
                  max-width: 100%;
                  margin-bottom: 20px; /* Margin between images and content */
                  text-align: center; /* Center image horizontally */
              }
              .container {
                  width: 60%; /* Set container width to 60% */
                  padding: 0 15px;
                  box-sizing: border-box;
                  text-align: left; /* Align text content */
              }
            </style>
        </head>
        <body>
            <img src="${headerImage}" class="header-img" alt="Header Image">
            <div class="container">
                ${patientDetailsContent}
                ${opdDetailsContent}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `;

    printWindow.document.write(content);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
  });

  // Function to handle Download button click
  $('#download-btn').click(function () {
    var patientDetailsContent = document.getElementById('patient-details').innerHTML;
    var opdDetailsContent = document.getElementById('opd-details').innerHTML;

    // Full content including header and footer images
    var content = `
        <html>
        <head>
            <title>OPD Details</title>
            <style>
                body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                width: 100%;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                align-items: center; /* Center content horizontally */
              }
              .header-img, .footer-img {
                  display: block;
                  width: 60%; /* Set width to 60% of the viewport width */
                  max-width: 100%;
                  margin-bottom: 20px; /* Margin between images and content */
                  text-align: center; /* Center image horizontally */
              }
              .container {
                  width: 60%; /* Set container width to 60% */
                  padding: 0 15px;
                  box-sizing: border-box;
                  text-align: left; /* Align text content */
              }
            </style>
        </head>
        <body>
            <img src="${headerImage}" class="header-img" alt="Header Image">
            <div class="container">
                ${patientDetailsContent}
                ${opdDetailsContent}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `;

    var blob = new Blob([content], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'opd-details.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // Bind click event to the Add New Patient button
  $('#add-opd').click(function () {
    window.location.href = '/create/opd-case';
  });

  // Bind click event to the Apply Filters button
  $('#apply-filters').click(function () {
    applyFilter();
  });

  // Bind click event to the Reset Filters button
  $('#reset-filters').click(function () {
    resetFilter();
  });

  // Delete button confirmation with SweetAlert
  $(document).on('click', '.delete-button', function (e) {
    e.preventDefault(); // Prevent default form submission

    var form = $(this).closest('form'); // Get the form related to the delete button

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        form.submit(); // If confirmed, submit the form
      }
    });
  });

  // Bind click event to the View button to show modal
  $(document).on('click', '.view-button', function (e) {
    e.preventDefault();

    var opdCaseId = $(this).data('id');

    $.ajax({
      url: '/getOpdDetails/' + opdCaseId,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        // Populate patient details
        $('#patient-details').html(`
              <div style="display: flex; justify-content: space-between; gap: 20px;">
                  <div style="flex: 1;">
                      <p style="margin-bottom: 0.5rem;"><strong>Name:</strong> ${data.patient.name}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Gender:</strong> ${data.patient.gender}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>City:</strong> ${data.patient.city}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${data.patient.phone}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> ${data.patient.address}</p>
                  </div>
                  <div style="flex: 1;">
                      <p style="margin-bottom: 0.5rem;"><strong>Height:</strong> ${data.patient.height}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Weight:</strong> ${data.patient.weight}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Pulse:</strong> ${data.patient.pulse}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Blood Pressure:</strong> ${data.patient.blood_pressure}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Temperature:</strong> ${data.patient.temperature}</p>
                  </div>
              </div>
          `);

        // Populate OPD details
        $('#opd-details').html(`
              <div style="display: flex; justify-content: space-between; gap: 20px;">
                  <div style="flex: 1;">
                      <p style="margin-bottom: 0.5rem;"><strong>Doctor Name:</strong> ${data.doctor.name}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Visit No:</strong> ${data.visit_no}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Respiratory:</strong> ${data.respiratory}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Appointment Date:</strong> ${data.appointment_date}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Presenting Complaint:</strong> ${data.presenting_complaint}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>History:</strong> ${data.history}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Provisional Diagnose:</strong> ${data.provisional_diagnose}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Treatment:</strong> ${data.treatment}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Special Instruction:</strong> ${data.special_instruction}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Follow Up Days:</strong> ${data.follow_up_days}</p>
                  </div>
              </div>
          `);

        // Show the modal
        $('#opdDetailsModal').modal('show');
      },
      error: function (error) {
        console.log('AJAX request failed.');
        console.log(error);
      }
    });
  });
});

$(document).on('click', '.view-diagnose-btn', function () {
  var opdCaseId = $(this).data('id');

  $.ajax({
      url: '/getOpdDetails/' + opdCaseId,  // Update with your actual route
      type: 'GET',
      dataType: 'json',
      success: function (data) {
          // Populate modal with OPD details
          $('#diagnose-details').html(`
              <p style="margin-bottom: 0.5rem;">${data.provisional_diagnose}</p>
          `);

          // Show the modal
          $('#detailsModal').modal('show');
      },
      error: function (error) {
          console.log('Error fetching details:', error);
      }
  });
});


// Function to apply filters
function applyFilter() {
  getFilteredOpdData();
}

// Function to reset filters
function resetFilter() {
  $('#patients').val(''); // Clear the patient name filter
  $('#filter-date').val(''); // Clear the date filter
  getFilteredOpdData(); // Fetch all data again
}

// Function to fetch filtered data
function getFilteredOpdData() {
  var dataSet = [];

  // Get the filter values
  var patientName = $('#patients').val();
  var filterDate = $('#filter-date').val();

  $.ajax({
    url: '/getFilteredOpdData', // Your actual backend URL
    type: 'get',
    dataType: 'json',
    data: { name: patientName, filterDate: filterDate }, // Send filters in request
    success: function (data) {
      console.log('Filtered data received:', data); // Debugging line
      var dataSet = [];

      // Prepare data for DataTable
      $.each(data, function (index, val) {
        var action = `
          <a href="/view/opd-case/${val.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/opd-case/${val.id}" class="btn btn-sm btn-primary">Edit</a>
        `;

        // Conditionally include delete button if canDelete is true
        if (canDelete) {
          action += `
              <form action="${baseUrl}delete/opd-case/${val.id}" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="button" class="btn btn-sm btn-icon delete-button"
                                      data-id="${val.id}"
                                      title="Delete Case">
                  <i class="ti ti-trash"></i> <!-- Delete icon -->
                </button>
              </form>`;
          }

          var viewButton = `
          <button class="btn btn-sm view-diagnose-btn" data-id="${val.id}">
              <i class="fas fa-eye"></i>
          </button>
          `;

        // Add each row to the dataSet
        dataSet.push([val.id, val.name, val.gender, viewButton, val.phone, action]);
      });

      // Destroy and reinitialize DataTable with the new data
      var table = $('.datatables-users').DataTable();
      table.destroy(); // Destroy the existing table
      $('.datatables-users').DataTable({
        aaSorting: [],
        data: dataSet,
        columnDefs: [{ className: 'text-nowrap text-left', targets: [0, 1, 2, 3, 4, 5] }],
        drawCallback: function (settings) {
          feather.replace(); // Reapply feather icons
          $('[data-toggle="tooltip"]').tooltip(); // Reapply tooltips
        }
      });
    },
    error: function (error) {
      console.log('AJAX request failed.');
      console.log(error);
    }
  });
}
