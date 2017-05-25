/****************************************************
 * Project:     Klinika_Local
 * Filename:    EditCrudController.js
 * Encoding:    UTF-8
 * Created:     2016-08-10
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {
    var url = "AJAX/EditCrudAJAX.php"; // the script where you handle the form input.

// POBRANIE PODSTAWOWYCH  DANYCH
    $.ajax({
        type: "POST",
        url: url,
        data: 'action=init', // serializes the form's elements.
        success: function (response) {
            var data = jQuery.parseJSON(response);
            Make_Records(data);
        },
        error: function (response) {
            alert("ERROR" + response);
        }
    });

// SUBMIT FORM
    $('#EditCrudForm').submit(function (e) {
        var old_pass = $('#losenord').val();
        if (old_pass != "") {
            var check = equal2entry("new_losenord", "new_losenord2");
            if (check) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#EditCrudForm").serialize() + '&action=edit', // serializes the form's elements.
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        Make_Records(data);
                    },
                    error: function (response) {
                        alert("ERROR" + response);
                    }
                });
            } else {
                alert("Hasła nie mogą być różne!");
            }
        } else {
//            alert("Bez podania starego hasła nie można zmienić hasła!!!!")
            if (confirm("Bez podania starego hasła nie można zmienić hasła!!!!\nCzy zmienić pozostałe dane?")) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#EditCrudForm").serialize() + '&action=edit', // serializes the form's elements.
                    success: function (response) {
                        var data = jQuery.parseJSON(response);
                        Make_Records(data);
                    },
                    error: function (response) {
                        alert("ERROR" + response);
                    }
                });
            } else {

            }

        }
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    // Czy oba nowe hasła są identyczne
    $('#new_losenord2').change(function () {
        equal2entry("new_losenord", "new_losenord2");
    });

    // FUNKCJA PAKUJĄCA DANE DO FORMULARZA
    function Make_Records(data) {

        $('#idUsers').val(data[0]['idUsers']);
        $('#anvandersnamn').val(data[0]['anvandersnamn']);
        $('#imie').val(data[0]['imie']);
        $('#nazwisko').val(data[0]['nazwisko']);
        $('#email').val(data[0]['email']);
        $('#last_logg').val(data[0]['last_logg']);
        $('#IP').val(data[0]['IP']);
        $('#new_losenord2_error').hide();
        $('#new_losenord2_success').hide();
    }

    // porównuje wartości dwóch pól po Id pól
    function equal2entry(id1, id2) {
        var id1val = $('#' + id1).val();
        var id2val = $('#' + id2).val();
        var check = false;

        if (id1val == id2val) {
            $('#' + id2 + "_success").show();
            $('#' + id2 + "_error").hide();
            check = true;
        } else {
            $('#' + id2 + "_error").show();
            $('#' + id2 + "_success").hide();
            check = false;
        }
        return check;
    }

});


