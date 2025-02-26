$(document).ready(function(){l(),$("#patient_id").select2({placeholder:"Select a patient",allowClear:!0}),$("#ipd_case").select2({placeholder:"Select a case",allowClear:!0}),$("#print-btn").click(function(){var t=window.open("","","height=600,width=800"),a=document.getElementById("plan-details").innerHTML,a=`
          <html>
          <head>
              <title>Discharge Plan Details</title>
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
                      width: 90%;
                      margin: 0 auto;
                  }
                  .row {
                      display: flex;
                      flex-wrap: wrap;
                      margin: -15px;
                  }
                  .col-md-6, .col-md-4 {
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
              <img src="${headerImage}" alt="Header Image">
              <div class="container">
                  ${a}
              </div>
              <img src="${footerImage}" alt="Footer Image">
          </body>
          </html>
      `;t.document.write(a),t.document.close(),t.focus(),t.print()}),$("#download-btn").click(function(){var t=document.getElementById("plan-details").innerHTML,t=`
          <html>
          <head>
              <title>Discharge Plan Details</title>
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
                      width: 90%;
                      margin: 0 auto;
                  }
                  .row {
                      display: flex;
                      flex-wrap: wrap;
                      margin: -15px;
                  }
                  .col-md-6, .col-md-4 {
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
              <img src="${headerImage}" alt="Header Image" style="width: 100%; margin-bottom: 20px;">
              <div class="container">
                  ${t}
              </div>
              <img src="${footerImage}" alt="Footer Image" style="width: 100%; margin-top: 20px;">
          </body>
          </html>
      `,a=new Blob([t],{type:"text/html"}),e=URL.createObjectURL(a),i=document.createElement("a");i.href=e,i.download="discharge-plan-details.html",document.body.appendChild(i),i.click(),document.body.removeChild(i),URL.revokeObjectURL(e)}),$("#add-discharge-plan").click(function(){window.location.href="/create/discharge-plan"}),$(document).on("click",".delete-button",function(t){t.preventDefault();var a=$(this).closest("form");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"Cancel",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(e){e.isConfirmed&&a.submit()})}),$(document).on("click",".view-button",function(t){t.preventDefault();var a=$(this).data("id");$.ajax({url:"/getDischargeDetails/"+a,type:"GET",dataType:"json",success:function(e){$("#plan-details").html(`
                  <div style="display: flex; justify-content: space-between; gap: 20px;">
                      <div style="flex: 1;">
                          <p style="margin-bottom: 0.5rem;"><strong>Plan ID:</strong> ${e.id}</p>
                          <p style="margin-bottom: 0.5rem;"><strong>Visit Number:</strong> ${e.ipd_case.visit_no}</p>
                      </div>
                      <div style="flex: 1;">
                          <p style="margin-bottom: 0.5rem;"><strong>Patient Name:</strong> ${e.patient.name}</p>
                          <p style="margin-bottom: 0.5rem;"><strong>Appointment Date:</strong> ${e.ipd_case.appointment_date}</p>
                      </div>
                  </div>
              `),$("#dischargePlanModal").modal("show")},error:function(e){console.log("AJAX request failed."),console.log(e)}})});function l(){$.ajax({url:"/getFilteredDischargeData",type:"get",dataType:"json",success:function(t){var a=[];$.each(t,function(i,n){var o=`
                  <a href="/view/discharge-plan/${n.id}" class="btn btn-sm btn-light">View</a>
                  <a href="/edit/discharge-plan/${n.id}" class="btn btn-sm btn-primary">Edit</a>
                `;canDelete&&(o+=`
                    <form action="${baseUrl}delete/discharge-plan/${n.id}" method="POST" style="display:inline;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="${csrfToken}">
                      <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${n.id}">
                        <i class="ti ti-trash"></i> <!-- Delete icon -->
                      </button>
                    </form>`),a.push([n.id,n.patient_name,n.visit_no,n.appointment_date,o])});var e=$(".datatables-plans").DataTable();e.destroy(),$(".datatables-plans").DataTable({aaSorting:[],data:a,columnDefs:[{className:"text-nowrap text-left",targets:[0,1,2,3,4]}],drawCallback:function(i){feather.replace(),$('[data-toggle="tooltip"]').tooltip()}})},error:function(t){console.log("AJAX request failed."),console.log(t)}})}});
