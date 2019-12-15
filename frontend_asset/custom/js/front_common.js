$(document).ready(function(){

    //Bootstrap tooltip initialize
    $('[data-toggle="tooltip"]').tooltip();

    function show_loader(){
        $('#tl_front_loader').show();
    }

    function hide_loader(){
        $('#tl_front_loader').hide();
    }

    /* Common messages */
    var proceed_err = 'Please fill required fields before proceeding.',
    err_unknown = 'Something went wrong. Please try again.';

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "5000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    //user can not enter alphabet and first digit is dot
    $('.floatValue').keypress(function(event) {
        if (this.value.length == 0 && event.which == 48 ){//first character zero not allow
            return false;
        }
        if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
            $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    }).on('paste', function(event) {
        event.preventDefault();
    });//End

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    }, "Numbers and special characters are not allowed."); 

    jQuery.validator.addMethod("email", function(value, element) {
     return this.optional( element ) || ( /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test( value ) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test( value ) );
    }, 'Please enter valid email address.');

    jQuery.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
           event.preventDefault();
           return false;
        }
    }, "please use only alphanumeric or alphabetic characters");

    jQuery.validator.addMethod('passwordSame', function(value, element) {

        // The two password inputs
        var newpassword = $("#new_Password").val();
        var oldPassword = $("#old_Password").val();
        // Check for equality with the password inputs
        if(newpassword == oldPassword ){
            return false;
        }else{
            return true;
        }
    });

    jQuery.validator.addMethod('budgetMinCheck', function(value, element) {
        // The two password inputs
        var budgetMinCheck = Number($("#job_budget").val());
        
        if(budgetMinCheck < 1){
            return false;
        }else{
            return true;
        }
    });

    jQuery.validator.addMethod('offerMinCheck', function(value, element) {
        
        var min_rate = Number($("#minPrice").val());
        var job_offer = Number($("#job_budget").val());
        if(job_offer < min_rate){
            return false;
        }else{
            return true;
        }
    });

    jQuery.validator.addMethod('CheckInputValue', function(value, element) {
        // The two password inputs
        var value = $("#no_of_days").val();
        if(value == 0){
            return false;
        }else{
            return true;
        }
    });

    jQuery.validator.addMethod('passwordCheck', function(value, element) {
        
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();

        if(password == confirmPassword){
            return true;
        }else{
            return false;
        }
    });

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;
        var byteCharacters = atob(b64Data);
        var byteArrays = [];
        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }
        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

    

    var social_client_form = $("#socialForm");
    social_client_form.validate({
        rules:{
            socialFirstName : {
               required: true,
               minlength:2,
            },
            socialLastName : {
               required: true,
               minlength:2,
            },
            address: {
               required: true,
            },
            country:{
                required: true,
            },
            socialEmail:{
               required: true ,
            },
            
        },
        messages:{
            socialFirstName : {
                required: "Please enter First name" ,
                minlength:"Name should be at least 2 characters",
            },
            socialLastName : {
                required: "Please enter Last name" ,
                minlength:"Name should be at least 2 characters",
            },
            address : {
                required: "Please enter address" ,
            },
            country : {
                required: "Please enter country" ,
            },
            socialEmail:{
                required: "Please enter email",
            },             
        },
        errorPlacement: function(error, element){
            
            //if input parent elemnt has 'input-group' class then place error element after that parent div
            if (element.parent().hasClass('input-group')) {
               error.insertAfter(element.parent());
            }else{
                error.insertAfter($('#tt'));
            }
        }
    });

    //Social registration here
    $(document).on('click', ".socialReg",function (){
        
        if(social_client_form.valid() !== true){
            toastr.error(proceed_err); return false;
        } 
        var _that = $(this), 
        form = _that.closest('form'),      
        formData = new FormData(form[0]),
        f_action = form.attr('action');
        $.ajax({
            type: "POST",
            url: f_action,
            data: formData, //only input
            processData: false,
            contentType: false,
            dataType: "JSON", 
            beforeSend: function () { 
                show_loader(); 
            },
            success: function (data, textStatus, jqXHR) {  
                hide_loader();   
                if (data.status == 1){ 
                    toastr.success(data.msg);  
                    window.setTimeout(function () {
                         window.location.href = data.url;
                    }, 500);
                }else if(data.status == -1){
                    toastr.error(data.msg);
                    window.setTimeout(function () {
                        window.location.href = data.url ;
                    }, 1000);
                }else {
                    toastr.error(data.msg);    
                } 
                setTimeout(function() {
                    $(".alert").hide(10000);
                }, 4000);
            },
        });
    });
    //End


    //USER REGISTRATION VALIDATION
    var signUpForm = $("#userSignup");  
    signUpForm.validate({
        rules:{
            First_name:{
               required: true , 
               lettersonly: true,   
            },
            Last_name:{
               required: true , 
               lettersonly: true,   
            },
            email:{
                required: true ,
                email: true,    
            },
            password : {
                required: true ,
                minlength:6,
                maxlength:10
            },
            confirmPassword:{
                required: true,
                passwordCheck : true
            },
            address1:{
                required: true,
            },
            countryt:{
                required: true,
            },
            gender1:{
                required: true,
            }
       },
        messages:{
            First_name:{
                required: "Please enter First name"   
            },
            Last_name:{
                required: "Please enter First Last name"   
            },
            email:{
                required: "Please enter email"   
            },
            password:{
                required: "Please enter password",
                minlength:"Password should be at least 6 characters ",
                maxlength:"Password should be not more than 10 characters",
            },
            confirmPassword:{
                required: "Please enter confirmation password",
                passwordCheck : "Your password and confirmation password do not match",
            }, 
            address1:{
               required: "Please enter address", 
            },
            countryt:{
               required: "Please enter country", 
            },
            gender1:{
               required: "Please enter gender", 
            },

        }
    });//END USER VALIDATION HERE

    //User Registration here
    $('body').on('click', ".signup", function (event) {
        if(signUpForm.valid() !== true){
            toastr.error(proceed_err); return false;
        }
        var _that = $(this), 
        form = _that.closest('form'),      
        formData = new FormData(form[0]),
        f_action = form.attr('action');
        $.ajax({
            type: "POST",
            url: f_action,
            data: formData, //only input
            processData: false,
            contentType: false,
            dataType: "JSON", 
            beforeSend: function () { 
                show_loader(); 
            },
            success: function (data, textStatus, jqXHR) {  
                hide_loader();   
                if (data.status == 1){ 
                    toastr.success(data.msg);  
                    window.setTimeout(function () {
                        window.location.href = data.url;
                    }, 500);
                }else if(data.status == -1){
                    toastr.error(data.msg);
                    window.setTimeout(function () {
                        window.location.href = data.url ;
                    }, 1000);
                }else {
                    toastr.error(data.msg);    
                } 
                setTimeout(function() {
                    $(".alert").hide(10000);
                }, 4000);
            },
        });
    });//End user registration


    //USER LOGIN VALIDATION
    var loginForm = $("#login");
    loginForm.validate({
        rules:{
            email:{
                required: true ,
                email: true,   
            },
            password: {
                required: true ,
                minlength:6,
                maxlength:10
            },
        },
         messages:{
            email:{
                required: "Please enter email",
            },
            password:{
                required: "Please enter password",
                minlength:"Password should be at least 6 characters ",
                maxlength:"Password should be not more than 10 characters",
            },                 
        }
    });// END USER LOGIN VALIDATION HERE

    // USER LOGIN
    $('body').on('click', ".login_user", function (event) {
        
        if(loginForm.valid() !== true){
            toastr.error(proceed_err); return false;
        }
        var _that = $(this), 
        form = _that.closest('form'), 
        formData = new FormData(form[0]),
        f_action = form.attr('action');
        $.ajax({
            type: "POST",
            url: f_action,
            data: formData, //only input
            processData: false,
            contentType: false,
            dataType: "JSON", 
            beforeSend: function () { 
                show_loader(); 
            },
            success: function (data) {
                hide_loader();
                if(data.status == 1){ 
                    toastr.success(data.msg);
                    window.setTimeout(function () {
                      window.location.href = data.url;
                    }, 1000);
                }else if(data.status == -1){
                    toastr.error(data.msg);
                    window.setTimeout(function () {
                        window.location.href = data.url ;
                    }, 1000);
                }else{
                  toastr.error(data.msg); 
               }
               setTimeout(function() {
                    $(".alert").hide(10000);
                }, 4000);
            },
            error:function (){     
            }
        });
    });//END USER LOGIN HERE

});// End DOM

//google autocomplete setup
function setupAutocomplete(the_input_arr, i) {
    // var google = '';
    var autocomplete = [];
    var the_input_loc = the_input_arr[0]; //location input jquery object
    var the_input_lat = the_input_arr[1]; //latitude input jquery object
    var the_input_long = the_input_arr[2]; //longitude input jquery object

    autocomplete.push(new google.maps.places.Autocomplete(the_input_loc[0]));
    var idx = autocomplete.length - 1;

    //Set only those fields which are requiered to reduce billing cost for place search API
    autocomplete[idx].setFields(['address_components', 'formatted_address', 'geometry', 'icon', 'name']);
    
     //clear old lat-long on change
    $(the_input_loc).on('change', function() {
        the_input_lat.val('');
        the_input_long.val('');
    });

    google.maps.event.addListener(autocomplete[idx], 'place_changed', function(){
        // Get the place details from the autocomplete object.
        var place = autocomplete[idx].getPlace();
        if (!place.geometry) {
            toastr.error(valid_loc_msg);
            return;
        }
        //location is correct, grab lat long here
        toastr.remove();
        var place_lat = place.geometry.location.lat();
        var place_long = place.geometry.location.lng();
        the_input_lat.val(place_lat);
        the_input_long.val(place_long);

        if(place.address_components.length < 6){
            if(place.address_components.length == 4){
                $("#suburb").val(place.address_components[1].long_name); 
                $('#countryName').val(place.address_components[3].long_name);
                $('#stateName').val(place.address_components[2].long_name);   
                $("#cityName").val(place.address_components[1].long_name);
                $("#hourlyCityName").val(place.address_components[1].long_name);
            }else{
                $("#suburb").val(place.address_components[0].long_name); 
                $('#countryName').val(place.address_components[3].long_name);
                $('#stateName').val(place.address_components[2].long_name);   
                $("#cityName").val(place.address_components[0].long_name);
                $("#hourlyCityName").val(place.address_components[1].long_name);
            }   
        }else if(place.address_components.length == 6){
            if($.isNumeric(place.address_components[5].long_name)){// If contry index get zip code.
                $("#suburb").val(place.address_components[2].long_name);
                $('#countryName').val(place.address_components[4].long_name);
                $('#stateName').val(place.address_components[3].long_name);   
                $("#cityName").val(place.address_components[2].long_name);
                $("#hourlyCityName").val(place.address_components[1].long_name);
            }else{
                $("#suburb").val(place.address_components[3].long_name);
                $('#countryName').val(place.address_components[5].long_name);
                $('#stateName').val(place.address_components[4].long_name);   
                $("#cityName").val(place.address_components[3].long_name);
                $("#hourlyCityName").val(place.address_components[1].long_name);
            }
        }else{
            $("#suburb").val(place.address_components[4].long_name); 
            $('#countryName').val(place.address_components[6].long_name);
            $('#stateName').val(place.address_components[5].long_name);   
            $("#cityName").val(place.address_components[4].long_name); 
            $("#hourlyCityName").val(place.address_components[4].long_name);
        }
    });
}

