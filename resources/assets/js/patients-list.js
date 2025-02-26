$(document).ready(function () {
  // Initial data fetch when page loads
  getFilteredPatientData();

  //Custom Selct2 Placeholder
  $('#patients').select2({
      placeholder: "Select a patient", // Custom placeholder for patients
      allowClear: true
  });

  // Function to handle Print button click
  $('#print-btn').click(function () {
    var printWindow = window.open('', '', 'height=600,width=800');
    var content = document.getElementById('patient-details').innerHTML;

    // HTML content including the header and footer images
    var printContent = `
          <html>
          <head>
              <title>Patient Details</title>
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
                  ${content}
              </div>
              <img src="${footerImage}" class="footer-img" alt="Footer Image">
          </body>
          </html>
      `;

    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
  });


  // Function to handle Download button click
  $('#download-btn').click(function () {
    var content = document.getElementById('patient-details').innerHTML;

    // HTML content including the header and footer images
    var downloadContent = `
          <html>
          <head>
              <title>Patient Details</title>
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
                  ${content}
              </div>
              <img src="${footerImage}" class="footer-img" alt="Footer Image">
          </body>
          </html>
      `;

    var blob = new Blob([downloadContent], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'patient-details.pdf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });


  // Bind click event to the Add New Patient button
  $('#add-patient').click(function () {
    window.location.href = '/create/patient';
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

    var patientId = $(this).data('id');

    $.ajax({
      url: '/getPatientDetails/' + patientId,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        // Populate modal with patient details
        $('#patient-details').html(`
         <div style="display: flex; justify-content: space-between; gap: 20px;">
            <div style="flex: 1;">
                <p style="margin-bottom: 0.5rem;"><strong>Name:</strong> ${data.name}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Gender:</strong> ${data.gender}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Age:</strong> ${data.age}</p>
                <p style="margin-bottom: 0.5rem;"><strong>City:</strong> ${data.city}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${data.phone}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> ${data.address}</p>
            </div>
            <div style="flex: 1;">
                <p style="margin-bottom: 0.5rem;"><strong>Height:</strong> ${data.height}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Weight:</strong> ${data.weight}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Pulse:</strong> ${data.pulse}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Blood Pressure:</strong> ${data.blood_pressure}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Temperature:</strong> ${data.temperature}</p>
            </div>
        </div>
        `);

        // Show the modal
        $('#patientDetailsModal').modal('show');
      },
      error: function (error) {
        console.log('AJAX request failed.');
        console.log(error);
      }
    });
  });
});

// Function to apply filters
function applyFilter() {
  getFilteredPatientData();
}

// Function to reset filters
function resetFilter() {
  $('#patients').val(''); // Clear the patient name filter
  $('#filter-date').val(''); // Clear the date filter
  getFilteredPatientData(); // Fetch all data again
}

// Function to fetch filtered data
function getFilteredPatientData() {
  var dataSet = [];

  // Get the filter values
  var patientName = $('#patients').val();
  var filterDate = $('#filter-date').val();

  $.ajax({
    url: '/getFilteredPatientData', // Your actual backend URL
    type: 'get',
    dataType: 'json',
    data: { name: patientName, filterDate: filterDate }, // Send filters in request
    success: function (data) {
      var dataSet = [];

      // Prepare data for DataTable
      $.each(data, function (index, val) {
        var action = `
          <a href="/view/patient/${val.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/patient/${val.id}" class="btn btn-sm btn-primary">Edit</a>
        `;

        // Conditionally include delete button if canDelete is true
        if (canDelete) {
          action += `
            <form action="${baseUrl}delete/patient/${val.id}" method="POST" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="${csrfToken}">
              <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${val.id}">
                <i class="ti ti-trash"></i> <!-- Delete icon -->
              </button>
            </form>`;
        }

        // Add each row to the dataSet
        dataSet.push([val.id, val.name, val.gender, val.phone, val.city, action]);
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
