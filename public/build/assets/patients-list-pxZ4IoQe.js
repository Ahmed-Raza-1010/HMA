$(document).ready(function(){r(),$("#patients").select2({placeholder:"Select a patient",allowClear:!0}),$("#print-btn").click(function(){var e=window.open("","","height=600,width=800"),n=document.getElementById("patient-details").innerHTML,t=`
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
                  ${n}
              </div>
              <img src="${footerImage}" class="footer-img" alt="Footer Image">
          </body>
          </html>
      `;e.document.write(t),e.document.close(),e.focus(),e.print()}),$("#download-btn").click(function(){var e=document.getElementById("patient-details").innerHTML,n=`
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
                  ${e}
              </div>
              <img src="${footerImage}" class="footer-img" alt="Footer Image">
          </body>
          </html>
      `,t=new Blob([n],{type:"text/html"}),a=URL.createObjectURL(t),o=document.createElement("a");o.href=a,o.download="patient-details.pdf",document.body.appendChild(o),o.click(),document.body.removeChild(o),URL.revokeObjectURL(a)}),$("#add-patient").click(function(){window.location.href="/create/patient"}),$("#apply-filters").click(function(){d()}),$("#reset-filters").click(function(){c()}),$(document).on("click",".delete-button",function(e){e.preventDefault();var n=$(this).closest("form");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"Cancel",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(t){t.isConfirmed&&n.submit()})}),$(document).on("click",".view-button",function(e){e.preventDefault();var n=$(this).data("id");$.ajax({url:"/getPatientDetails/"+n,type:"GET",dataType:"json",success:function(t){$("#patient-details").html(`
         <div style="display: flex; justify-content: space-between; gap: 20px;">
            <div style="flex: 1;">
                <p style="margin-bottom: 0.5rem;"><strong>Name:</strong> ${t.name}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Gender:</strong> ${t.gender}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Age:</strong> ${t.age}</p>
                <p style="margin-bottom: 0.5rem;"><strong>City:</strong> ${t.city}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${t.phone}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> ${t.address}</p>
            </div>
            <div style="flex: 1;">
                <p style="margin-bottom: 0.5rem;"><strong>Height:</strong> ${t.height}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Weight:</strong> ${t.weight}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Pulse:</strong> ${t.pulse}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Blood Pressure:</strong> ${t.blood_pressure}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Temperature:</strong> ${t.temperature}</p>
            </div>
        </div>
        `),$("#patientDetailsModal").modal("show")},error:function(t){console.log("AJAX request failed."),console.log(t)}})})});function d(){r()}function c(){$("#patients").val(""),$("#filter-date").val(""),r()}function r(){var e=$("#patients").val(),n=$("#filter-date").val();$.ajax({url:"/getFilteredPatientData",type:"get",dataType:"json",data:{name:e,filterDate:n},success:function(t){var a=[];$.each(t,function(s,i){var l=`
          <a href="/view/patient/${i.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/patient/${i.id}" class="btn btn-sm btn-primary">Edit</a>
        `;canDelete&&(l+=`
            <form action="${baseUrl}delete/patient/${i.id}" method="POST" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="${csrfToken}">
              <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${i.id}">
                <i class="ti ti-trash"></i> <!-- Delete icon -->
              </button>
            </form>`),a.push([i.id,i.name,i.gender,i.phone,i.city,l])});var o=$(".datatables-users").DataTable();o.destroy(),$(".datatables-users").DataTable({aaSorting:[],data:a,columnDefs:[{className:"text-nowrap text-left",targets:[0,1,2,3,4,5]}],drawCallback:function(s){feather.replace(),$('[data-toggle="tooltip"]').tooltip()}})},error:function(t){console.log("AJAX request failed."),console.log(t)}})}
