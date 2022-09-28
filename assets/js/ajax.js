// Kannel ----------------------------



function getKannelTab(tab){

    $.ajax({'url': '/kannel/' + tab, 
    'type': 'get', 
    'data':{},
    'success': function (data) {
        $('#kannel_data').html(data);    
    }});
}  





function getsenderdata(){  
    var form_data = $('#sender_data').serialize();
    // // $("#getsenderdata").attr('disabled','disabled');   
    // // $("#getsenderdata").attr('value','Loading....');   

    $.ajax({
        type: 'POST',
        data:form_data,
        url: '/getsenderdata',
        success: function (data) {
            $("#getsendertrafic").html(data);
            // $("#getsenderdata").prop('disabled', false);
            // $("#getsenderdata").attr('value','Refresh');   
        }
    });
};

function getsmscdata(){
    var formData = $('#smsc_data').serialize();
    $.ajax({
        type: 'POST',
        data: formData,
        url: '/getsmscdata',
        success: function (data) {
            $("#getsmsctrafic").html(data);
            // $("#getsenderdata").prop('disabled', false);
            // $("#getsenderdata").attr('value','Refresh');   
        }
    });
};


// Report ------------------------------->

function getReportTab(tab){
    $.ajax({'url': '/report_data/'+ tab, 
    'type': 'get', 
    'data':{},
    'success': function (data) {
        $('#report_data').html(data);    
    }});
}  

function DeliveryReportPdu() {
    event.preventDefault();
    var formData = $('#DeliveryReportID').serialize();
    // $("#GetDeliveryPdu").prop("disabled",true); 

    $.ajax({
        'url': '/deliveryreportpdu', 
        'type': 'POST', 
        'data': formData,
        'success': function (data) {
            $('#DeliveryReportPdu').html(data);
        }
    });
}


 $(document).ready(function(){  
      $('#upload_csv_form').on("submit", function(e){  
           e.preventDefault(); //form will not submitted  
           console.log(new FormData(this))
           $.ajax({  
                url:"/csv_upload_data",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,          // The content type used when sending data to the server.  
                cache:false,                // To unable request pages to be cached  
                processData:false,          // To send DOMDocument or non processed data file it is set to false  
                success: function(data){  
                    $('#csv_upload_data').html(data); 
                }  
           })  
      });  
});  

 

// Smpp Users ------------------------------->

function getSmppTab(tab){
    $.ajax(
        {
            'url': '/smpp_users_data/'+ tab, 
            'type': 'get', 
            'data':{},
            'success': function (data) {
                $('#smpp_users_data').html(data);    
            }
        }
    );
} 

function changeRouting(UserId){
    console.log(UserId);
    var formData = $('#changeRouting-' + UserId).serialize();
    console.log(formData);
    $.ajax({
        'url': '/changeRouting', 
        'type': 'POST', 
        'data': formData,
        'success': function (data) {
            $('#changeRouting').html(data);
        }
    });
} 

// Repush



$("#getRepushData").click(function(){
    if($('#Username').val()!=="" && $('#RepushDateTime').val()!==""){

        // $("#getRepushData").attr('disabled','disabled');   
        $("#getRepushData").attr('value','Loading....');   

        $.ajax({
            type: 'POST',
            url: '/getrepushdata',
            data: $('form').serialize(),
            success: function (data) {
                $("#getRepushDataBox").html(data);
                // $("#getRepushData").prop('disabled', false);
                $("#getRepushData").attr('value','Refresh');   
            }
        });
    }
});




// whitelist ----------------------------
function getWhitelistTab(tab){
    $.ajax({
        'url': '/whitelist_data/' + tab, 
        'type': 'get', 
        'data':{},
        'success': function (data) {

            $('#whitelist_data').html(data);    
        }
    });
}  


function savesenderratio() {


        var form_data = $('#savesender').serialize();

        $.ajax({
            type: 'POST',
            data:form_data,
            url: '/savesenderratio',
            success: function (data) {
                $("#getsendertrafic").html(data);
                // $("#getsenderdata").prop('disabled', false);
                 $("#example").attr('value','Refresh');   
            }
        });

    }

$( "#reportlist_form" ).on( "submit", function() {

        var form_data = $('#reportlist_form').serialize();
         console.log(form_data);
        $.ajax({
            type:'POST',
            data:form_data,
            url: '/reportlist',
            success: function (data) {
                // console.log(data);
                $("#reporttable").html(data);
                // $("#getsenderdata").prop('disabled', false);
                // $("#getsenderdata").attr('value','Refresh');   
            }
        });

    });


    $( "#whitelist" ).on( "submit", function() {

        var form_data = $('#whitelist').serialize();
         console.log(form_data);
        $.ajax({
            type:'POST',
            data:form_data,
            url: '/add_whitelist_number',
            success: function (data) {
                // console.log(data);
                // $("#reporttable").html(data);
                // $("#getsenderdata").prop('disabled', false);
                // $("#tab-2").attr('value','Refresh');   

            }
        });

    });

    $( "#approvedUserSenderId" ).on( "submit", function() {

        var form_data = $('#approvedUserSenderId').serialize();
         console.log(form_data);
        $.ajax({
            type:'POST',
            data:form_data,
            url: '/add_AUSenderId',
            success: function (data) {
                // console.log(data);
                // $("#reporttable").html(data);
                // $("#getsenderdata").prop('disabled', false);
                // $("#tab-2").attr('value','Refresh');   

            }
        });

    });


    $( "#Forcesender1" ).on( "submit", function() {

        var form_data = $('#Forcesender1').serialize();
         console.log(form_data);
        $.ajax({
            type:'POST',
            data:form_data,
            url: '/add_Forcesender',
            success: function (data) {
                // console.log(data);
                // $("#reporttable").html(data);
                // $("#getsenderdata").prop('disabled', false);
                // $("#tab-2").attr('value','Refresh');   

            }
        });

    });
