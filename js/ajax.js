$(function(){
  $("#submit").click(function submitForm(){
      $("#load").show();
        $.ajax({
            url: $('#loginForm').attr('action'),
            type: 'POST',
            data: $('#loginForm').serialize(),
            success: function(response){
              $("#loadDiv").hide();
              $("#error_message").html(response.message);
              $("#error_message").show();
              $("#login_canvas").css("height", "370px");
              $("#error_message").css("background-color", "#e6fcf5");
              $("#error_message").css("color", "#0ca678");
              $("#user").css("padding-top", "5%");
              setTimeout(function(){
                $("#loadDiv").show();
                $("#load").hide();
                $("#error_message").hide();
                $("#login_canvas").css("height", "370px");
              }, 3000);
              if(response.twoFactor === "1") {
                $("#code_field").show();
                $("#login_canvas").css("height", "425px");
                $("#error_message").css("background-color", "#e6fcf5");
                $("#login").css("padding-top", "10%");

                setTimeout(function(){
                  $("#error_message").hide();
                  $("#loadDiv").show();
                  $("#load").hide();
                  $("#login_canvas").css("height", "425px");
                  $("#error_message").css("background-color", "#f8f9fa");
                }, 3000);
                if(response.validationCode === false) {
                  $("#login_canvas").css("height", "425px");
                  $("#error_message").css("background-color", "#fff5f5");
                }
              }
            },
            error: function(response){
              
              error = response.responseJSON;
                $("#loadDiv").hide();
                $("#error_message").show();
                $('#error_message').html(error.message);
                $("#error_message").css("background-color", "#fff5f5")
                $("#error_message").css("color", "#ff6b6b");
                

                  setTimeout(function(){
                    $("#error_message").hide();
                    $("#loadDiv").show();
                    $("#load").hide();
                  }, 3000);
            }
        });
    });
});
