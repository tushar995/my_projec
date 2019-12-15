    function show_loader(){
        $('#tl_front_loader').show();
    }

    function hide_loader(){
        $('#tl_front_loader').hide();
    }
    var googleUser = {};
    var startApp = function() {
        gapi.load('auth2', function(){
          // Retrieve the singleton for the GoogleAuth library and set up the client.
          auth2 = gapi.auth2.init({
            client_id: '284708269414-8nviufui2jitrpg6l21c8aog7idgk55a.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
          });
          attachSignin(document.getElementById('customBtn'));
        });
    };

    function attachSignin(element) {
        auth2.attachClickHandler(element, {},
        function(googleUser) {
            data = googleUser.getBasicProfile();
            // console.log(data);
            // return false;
            var first_name = data.ofa;
            var last_name = data.wea;
            var socialId = data.Eea;
            var email =  (data.U3 != '' && typeof data.U3 != "undefined" ) ? data.U3 : '';
            var socialType = 'gmail' ;
            var profileImage = data.Paa; 
            var gData = {first_name:first_name,last_name:last_name,socialId: data.Eea,email: data.U3,socialType: "gmail",profileImage:data.Paa,};
            $.ajax({
                "url": base_url+"home/socialLogin",
                type: "POST",
                data: gData,
                dataType:"JSON",
                beforeSend: function () { 
                    show_loader(); 
                },
                success: function (data) {
                    hide_loader();
                    if(data.status == 1){// If social id found into DB
                        toastr.success(data.msg);  
                        window.setTimeout(function () {
                            window.location.href = data.url;
                        }, 500);
                    }else if(data.status == 2){ // If social id not found into DB
                        $('#socialFirstName').val(first_name);
                        $('#socialLastName').val(last_name);
                        if(email != '' && typeof email != "undefined"){
                            $('#socialEmail').val(email);
                            $("#socialEmail").attr('readonly','readonly');
                        }
                        $('#clientSocialType').val(socialType);
                        $('#clientSocialId').val(socialId);
                        $('#clientprofileImage').val(profileImage);
                        $("#socialclientImg").attr("src",profileImage);
                        $("#googlemodal").modal('show');
                    }else {
                        toastr.error(data.msg);    
                    } 
                    setTimeout(function() {
                        $(".alert").hide(1000);
                    }, 4000); 
                },
            });
          
        }, function(error) {
          //alert(JSON.stringify(error, undefined, 2));
        });
    }
    startApp();