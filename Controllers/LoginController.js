/****************************************************
 * Project:     Klinika_Local
 * Filename:    LoginController.js
 * Encoding:    UTF-8
 * Created:     2016-08-05
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function(){
    var url = "AJAX/LoginAJAX.php"; // the script where you handle the form input.
    $("#errorPass").hide();

    // Submiting Logg form
    $("#LoginForm").submit(function(e) {

            $.ajax({
                type: "POST",
                url: url,
                data: $("#LoginForm").serialize() + '&action=login', // serializes the form's elements.
               success: function(response){
                    var data = jQuery.parseJSON(response);
//                   alert("ok: "+data.valid); // show response from the php script.
//                   $("#responsTEST").text("RESPONSE: "+data.user + " / " + data.IP)
//                   $("#LoginForm").trigger('reset');
                    location.href = location.href
                },
               error: function(response){
                   alert("ERROR"+response);
//                   $("#errorPass").show();
                }
            });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#buttLogOut").click(function () {
//            alert("LOGOT")

        $.ajax({
            type: "POST",
            url: url,
            data: $("#LoginForm").serialize() + '&action=logOut', // serializes the form's elements.
            success: function (response) {
//                       var data = jQuery.parseJSON(response);
                window.location.href = "index.php";
            },
            error: function (response) {
                alert("ERROR" + response);
            }
        });

        preventDefault(); // avoid to execute the actual submit of the form.
    });

});

