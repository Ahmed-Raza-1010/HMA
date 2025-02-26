$(document).ready(function () {
  // Initial data fetch when page loads
  getFilteredDoctorData();

   //Custom Selct2 Placeholder
   $('#doctors').select2({
    placeholder: "Select a doctor", // Custom placeholder for patients
    allowClear: true
  });

  // Print button click handler
  $('#print-btn').click(function () {
    var printWindow = window.open('', '', 'height=600,width=800');
    var content = document.getElementById('doctor-details').innerHTML;

    // HTML content including the header and footer images
    printWindow.document.write(`
        <html>
        <head>
            <title>Doctor Details</title>
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
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
  });


  // Download button click handler
  $('#download-btn').click(function () {
    var content = document.getElementById('doctor-details').innerHTML;

    // HTML content including the header and footer images
    var fullContent = `
        <html>
        <head>
            <title>Doctor Details</title>
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

    // Create a blob and download the HTML file
    var blob = new Blob([fullContent], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'doctor-details.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });


  // Add New Doctor button click handler
  $('#add-doctor').click(function () {
    window.location.href = '/create/doctor';
  });

  // Apply Filters button click handler
  $('#apply-filters').click(function () {
    applyFilter();
  });

  // Reset Filters button click handler
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

  // View button click handler to show modal
  $(document).on('click', '.view-button', function (e) {
    e.preventDefault();

    var doctorId = $(this).data('id');

    $.ajax({
      url: '/getDoctorDetails/' + doctorId,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        // Populate modal with doctor details
        $('#doctor-details').html(`
          <div style="display: flex; justify-content: space-between; gap: 20px;">
            <div style="flex: 1;">
              <p style="margin-bottom: 0.5rem;"><strong>Name:</strong> ${data.name}</p>
              <p style="margin-bottom: 0.5rem;"><strong>Email:</strong> ${data.email}</p>
              <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${data.phone}</p>
                            <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${data.gender}</p>

            </div>
            <div style="flex: 1;">
              <p style="margin-bottom: 0.5rem;"><strong>Designation:</strong> ${data.designation}</p>
                            <p style="margin-bottom: 0.5rem;"><strong>City:</strong> ${data.city}</p>
                                          <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> ${data.address}</p>

            </div>
          </div>
        `);

        // Show the modal
        $('#doctorDetailsModal').modal('show');
      },
      error: function (error) {
        console.log('AJAX request failed.');
        console.log(error);
      }
    });
  });
});

// Apply filters
function applyFilter() {
  getFilteredDoctorData();
}

// Reset filters
function resetFilter() {
  $('#doctors').val(''); // Clear the doctor name filter
  $('#designation').val(''); // Clear the designation filter
  getFilteredDoctorData(); // Fetch all data again
}

// Fetch filtered data
function getFilteredDoctorData() {
  var dataSet = [];

  // Get the filter values
  var doctorName = $('#doctors').val();
  var designation = $('#designation').val();

  $.ajax({
    url: '/getFilteredDoctorData', // Your actual backend URL
    type: 'get',
    dataType: 'json',
    data: { name: doctorName, designation: designation }, // Send filters in request
    success: function (data) {
      var dataSet = [];

      // Prepare data for DataTable
      $.each(data, function (index, val) {
        var action = `
          <a href="/view/doctor/${val.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/doctor/${val.id}" class="btn btn-sm btn-primary">Edit</a>
        `;

        // Conditionally include delete button if canDelete is true
        if (canDelete) {
          action += `
            <form action="${baseUrl}delete/doctor/${val.id}" method="POST" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="${csrfToken}">
              <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${val.id}">
                <i class="ti ti-trash"></i> <!-- Delete icon -->
              </button>
            </form>`;
        }

        // Add each row to the dataSet
        dataSet.push([val.id, val.name, val.email, val.phone, val.designation, action]);
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
