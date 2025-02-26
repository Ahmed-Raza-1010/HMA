$(document).ready(function(){r(),$("#patient_name").select2({placeholder:"Select a patient",allowClear:!0}),$("#doctor_id").select2({placeholder:"Select a doctor",allowClear:!0}),$(document).ready(function(){$("#print-btn").click(function(){var e=window.open("","","height=600,width=800"),n=document.getElementById("ipd-details").innerHTML,t=`
          <html>
          <head>
              <title>IPD Case Details</title>
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
      `;e.document.write(t),e.document.close(),e.focus(),e.print()})}),$("#download-btn").click(function(){var e=document.getElementById("ipd-details").innerHTML,n=`
        <html>
        <head>
            <title>IPD Case Details</title>
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
    `,t=new Blob([n],{type:"text/html"}),a=URL.createObjectURL(t),o=document.createElement("a");o.href=a,o.download="ipd-details.html",document.body.appendChild(o),o.click(),document.body.removeChild(o),URL.revokeObjectURL(a)}),$("#add-ipd-case").click(function(){window.location.href="/create/ipd-case"}),$("#apply-filters").click(function(){c()}),$("#reset-filters").click(function(){p()}),$(document).on("click",".delete-button",function(e){e.preventDefault();var n=$(this).closest("form");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"Cancel",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(t){t.isConfirmed&&n.submit()})}),$(document).on("click",".view-button",function(e){e.preventDefault();var n=$(this).data("id");$.ajax({url:"/getIPDCaseDetails/"+n,type:"get",dataType:"json",success:function(t){$("#ipd-details").html(`
            <div style="display: flex; justify-content: space-between; gap: 20px;">
              <div style="flex: 1;">
                <p style="margin-bottom: 0.5rem;"><strong>Pateint Name:</strong> ${t.patient_name}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Doctor Name:</strong> ${t.doctor_name}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Gender:</strong> ${t.gender}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Contact # :</strong> ${t.phone}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Diagnose:</strong> ${t.provisional_diagnose}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Appointment Date:</strong> ${t.appointment_date}</p>
                <p style="margin-bottom: 0.5rem;"><strong>History:</strong> ${t.history}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Respiratory:</strong> ${t.respiratory}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Visit No:</strong> ${t.visit_no}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Presenting Complaint:</strong> ${t.presenting_complaint}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Treatment:</strong> ${t.treatment}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Special Instruction:</strong> ${t.special_instruction}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Follow Up Days:</strong> ${t.follow_up_days}</p>

              </div>
            </div>
          `),$("#ipdCaseDetailsModal").modal("show")},error:function(t){console.log("AJAX request failed."),console.log(t)}})})});$(document).on("click",".view-diagnose-btn",function(){var e=$(this).data("id");$.ajax({url:"/getIPDCaseDetails/"+e,type:"GET",dataType:"json",success:function(n){$("#diagnose-details").html(`
              <p style="margin-bottom: 0.5rem;">${n.provisional_diagnose}</p>
          `),$("#detailsModal").modal("show")},error:function(n){console.log("Error fetching details:",n)}})});$(document).on("click",".create-operational-note",function(e){e.preventDefault();var n=$(this).data("patient-id"),t=$(this).data("ipd-id");window.location.href=`/create/operational-note?patient_id=${n}&ipd_id=${t}`});$(document).on("click",".create-discharge-plan",function(e){e.preventDefault();var n=$(this).data("patient-id"),t=$(this).data("ipd-id");window.location.href=`/create/discharge-plan?patient_id=${n}&ipd_id=${t}`});function c(){r()}function p(){$("#patient_name").val(""),$("#appointment_date").val(""),r()}function r(){var e=$("#patient_name").val(),n=$("#appointment_date").val();$.ajax({url:"/getFilteredIPDData",type:"get",dataType:"json",data:{patient_name:e,appointment_date:n},success:function(t){var a=[];$.each(t,function(d,i){var s=`
          <a href="/view/ipd-case/${i.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/ipd-case/${i.id}" class="btn btn-sm btn-primary">Edit</a>

          <button type="button" class="btn btn-sm btn-icon create-operational-note"
                                data-patient-id="${i.patient_id}"
                                data-ipd-id="${i.id}"
                                data-ipd-id="${i.id}"
                                title="Add Operational Note">
            <i class="ti ti-notes"></i> <!-- Operational Note icon -->
          </button>

          <button type="button" class="btn btn-sm btn-icon create-discharge-plan"
                                data-patient-id="${i.patient_id}"
                                data-ipd-id="${i.id}"
                                data-ipd-id="${i.id}"
                                title="Add Discharge Note">
            <i class="ti ti-checkup-list"></i> <!-- Discharge Plan icon -->
          </button>`;canDelete&&(s+=`
            <form action="/delete/ipd-case/${i.id}" method="POST" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="${csrfToken}">
              <button type="button" class="btn btn-sm btn-icon delete-button"
                                    data-id="${i.id}"
                                    title="Delete Case">
                <i class="ti ti-trash"></i> <!-- Delete icon -->
              </button>
            </form>`);var l=`
                    <button class="btn btn-sm view-diagnose-btn" data-id="${i.id}">
                        <i class="fas fa-eye"></i>
                    </button>
                    `;a.push([i.id,i.patient_name,i.gender,l,i.phone,s])});var o=$(".datatables-ipd-cases").DataTable();o.destroy(),$(".datatables-ipd-cases").DataTable({aaSorting:[],data:a,columnDefs:[{className:"text-nowrap text-left",targets:[0,1,2,3,4,5]}],drawCallback:function(d){feather.replace(),$('[data-toggle="tooltip"]').tooltip()}})},error:function(t){console.log("AJAX request failed."),console.log(t)}})}
