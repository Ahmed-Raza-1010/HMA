$(document).ready(function(){s(),$("#patients").select2({placeholder:"Select a patient",allowClear:!0}),$("#patient_id").select2({placeholder:"Select a patient",allowClear:!0}),$("#doctor_id").select2({placeholder:"Select a doctor",allowClear:!0}),$("#print-btn").click(function(){var e=window.open("","","height=600,width=800"),n=document.getElementById("patient-details").innerHTML,t=document.getElementById("opd-details").innerHTML,a=`
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
                ${n}
                ${t}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `;e.document.write(a),e.document.close(),e.focus(),e.print()}),$("#download-btn").click(function(){var e=document.getElementById("patient-details").innerHTML,n=document.getElementById("opd-details").innerHTML,t=`
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
                ${e}
                ${n}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `,a=new Blob([t],{type:"text/html"}),r=URL.createObjectURL(a),i=document.createElement("a");i.href=r,i.download="opd-details.html",document.body.appendChild(i),i.click(),document.body.removeChild(i),URL.revokeObjectURL(r)}),$("#add-opd").click(function(){window.location.href="/create/opd-case"}),$("#apply-filters").click(function(){m()}),$("#reset-filters").click(function(){c()}),$(document).on("click",".delete-button",function(e){e.preventDefault();var n=$(this).closest("form");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"Cancel",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(t){t.isConfirmed&&n.submit()})}),$(document).on("click",".view-button",function(e){e.preventDefault();var n=$(this).data("id");$.ajax({url:"/getOpdDetails/"+n,type:"GET",dataType:"json",success:function(t){$("#patient-details").html(`
              <div style="display: flex; justify-content: space-between; gap: 20px;">
                  <div style="flex: 1;">
                      <p style="margin-bottom: 0.5rem;"><strong>Name:</strong> ${t.patient.name}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Gender:</strong> ${t.patient.gender}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>City:</strong> ${t.patient.city}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${t.patient.phone}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> ${t.patient.address}</p>
                  </div>
                  <div style="flex: 1;">
                      <p style="margin-bottom: 0.5rem;"><strong>Height:</strong> ${t.patient.height}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Weight:</strong> ${t.patient.weight}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Pulse:</strong> ${t.patient.pulse}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Blood Pressure:</strong> ${t.patient.blood_pressure}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Temperature:</strong> ${t.patient.temperature}</p>
                  </div>
              </div>
          `),$("#opd-details").html(`
              <div style="display: flex; justify-content: space-between; gap: 20px;">
                  <div style="flex: 1;">
                      <p style="margin-bottom: 0.5rem;"><strong>Doctor Name:</strong> ${t.doctor.name}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Visit No:</strong> ${t.visit_no}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Respiratory:</strong> ${t.respiratory}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Appointment Date:</strong> ${t.appointment_date}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Presenting Complaint:</strong> ${t.presenting_complaint}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>History:</strong> ${t.history}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Provisional Diagnose:</strong> ${t.provisional_diagnose}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Treatment:</strong> ${t.treatment}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Special Instruction:</strong> ${t.special_instruction}</p>
                      <p style="margin-bottom: 0.5rem;"><strong>Follow Up Days:</strong> ${t.follow_up_days}</p>
                  </div>
              </div>
          `),$("#opdDetailsModal").modal("show")},error:function(t){console.log("AJAX request failed."),console.log(t)}})})});$(document).on("click",".view-diagnose-btn",function(){var e=$(this).data("id");$.ajax({url:"/getOpdDetails/"+e,type:"GET",dataType:"json",success:function(n){$("#diagnose-details").html(`
              <p style="margin-bottom: 0.5rem;">${n.provisional_diagnose}</p>
          `),$("#detailsModal").modal("show")},error:function(n){console.log("Error fetching details:",n)}})});function m(){s()}function c(){$("#patients").val(""),$("#filter-date").val(""),s()}function s(){var e=$("#patients").val(),n=$("#filter-date").val();$.ajax({url:"/getFilteredOpdData",type:"get",dataType:"json",data:{name:e,filterDate:n},success:function(t){console.log("Filtered data received:",t);var a=[];$.each(t,function(i,o){var l=`
          <a href="/view/opd-case/${o.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/opd-case/${o.id}" class="btn btn-sm btn-primary">Edit</a>
        `;canDelete&&(l+=`
              <form action="${baseUrl}delete/opd-case/${o.id}" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="button" class="btn btn-sm btn-icon delete-button"
                                      data-id="${o.id}"
                                      title="Delete Case">
                  <i class="ti ti-trash"></i> <!-- Delete icon -->
                </button>
              </form>`);var d=`
          <button class="btn btn-sm view-diagnose-btn" data-id="${o.id}">
              <i class="fas fa-eye"></i>
          </button>
          `;a.push([o.id,o.name,o.gender,d,o.phone,l])});var r=$(".datatables-users").DataTable();r.destroy(),$(".datatables-users").DataTable({aaSorting:[],data:a,columnDefs:[{className:"text-nowrap text-left",targets:[0,1,2,3,4,5]}],drawCallback:function(i){feather.replace(),$('[data-toggle="tooltip"]').tooltip()}})},error:function(t){console.log("AJAX request failed."),console.log(t)}})}
