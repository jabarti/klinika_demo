/****************************************************
 * Project:     Klinika_Local
 * Filename:    FormularzController.js
 * Encoding:    UTF-8
 * Created:     2016-08-05
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {
    var url = "AJAX/FormularzAJAX.php"
    var fromDate = "01/01/1945";
    // Ustawienia początkowe formularza
    // NyForm3
    var now = new Date();

//    $('#data_utworzenia').val(dat_text)
//    $("#data_utworzenia").mask("9999-99-99", {placeholder: "yyyy-mm-dd"});
//    $("#data_urodzenia_matka").mask("9999-99-99", {placeholder: "yyyy-mm-dd"});
//    $("#data_urodzenia_dziecko").mask("9999-99-99", {placeholder: "yyyy-mm-dd"});
//    $("#kod_poczt").mask("99-999");
//    $("#urodz_kod_poczt").mask("99-999");
//    $("#telefon").mask("+99 999 999 999", {placeholder: "+48 xxx xxx xxx"});

    var dat_text = FormatDateToString(now);

    $('#data_utworzenia').val(dat_text)
    $('#dziecko_pop_show').hide();
    $('#dziecko_pop2_show').hide();
    $('#karmienie_piers_pop_opis_show').hide();
    $('#karmienie_piers_pop2_opis_show').hide();
    $("#show_szpital").hide();
    $("#show_innemiejsce").hide();
    $("#urodz_ulica_nr_mieszkanie").hide();
    $("#pozniej_opis").hide();
    $("#wcześniej").hide();
    $("#jaki_porod").hide();

    // NyForm5
    $("#problem_dziecko_opis").hide();
    $("#problem_mama_opis").hide();
    $("#karmienie_piersia_opis").hide();
    $("#kapturek_opis").hide();
    $("#dopajanie_opis_all").hide();
    $("#nawal_opis").hide();

    // NyForm6
    $("#karmienie_piers_opis").hide();
    $("#kapturek2_opis").hide();
    $("#dopajanie2_opis_all").hide();
    $("#karmienie_noc_opis").hide();
    $("#sciaganie_pokarm_opis").hide();
    $("#uspokajacz_opis").hide();

    // NyForm7
    $("#foto_cycki").hide();
//    $("#foto_cycki_inf").hide();
    $("#brodawka_jaka").hide();
    $("#zmiany_opis").hide();

    // NyForm8
    $("#add_02_show").hide();
    $("#add_03_show").hide();
    $("#add_04_show").hide();
    $("#add_05_show").hide();
    $("#add_06_show").hide();

    pobierz_szpitale();


    // Submiting Logg form
    $("#NyFormularz").submit(function (e) {
        var isValideted = false;

        var data_utworzenia = $("#data_utworzenia").val();
        var data_matka = $("#data_urodzenia_matka").val();
        var data_dziecko = $("#data_urodzenia_dziecko").val();

        var checkDU = dateCheck(fromDate, data_utworzenia);
        var checkM = dateCheck(fromDate, data_matka);
        var checkD = dateCheck(fromDate, data_dziecko);

        if (checkM && checkD && checkDU) {
            isValideted = true;
        }

        if (!checkDU) {
            $("#data_utworzenia").focus()
        }

        if (!checkM) {
            $("#data_urodzenia_matka").focus()
        }

        if (!checkD) {
            $("#data_urodzenia_dziecko").focus()
        }


        if (isValideted) {
            $.ajax({
                type: "POST",
                url: url,
                data: $("#NyFormularz").serialize() + '&action=addNytt', // serializes the form's elements.
                success: function (response) {
                    var data = jQuery.parseJSON(response);
//                   alert("ok: "+data.outp + "\n"+ data.actions); // show response from the php script.
                    $("#message").html('<br>DATA SQL:<br>' + data.SQL +
                            '<br>DATA.OUTP' + data.outp +
//                                        '<br>DATA ACTIONS:<br>'+data.actions+
                            '<br>DATA ERRORs:<br>' + data.error +
                            '<br>DATA Info:<br>' + data.info +
                            '<br>DATA NEW ID:<br>' + data.NewIDinfo
                            );

//                alert("IS ERROR?" + data.isError)

//                alert(data.error + ", new ID " + data.NewID + "' length: " + data.NewID.length)
//                $("#NyFormularz").trigger('reset');

                    if (data.NewID != null && data.NewID.length > 5) {
                        if (confirm("Formularz zapisany!!!\nCzy chcesz przejść na stronę edycji(OK), czy dodać nowy formularz(N)?")) {
                            location.href = "index.php?page=edit&id_record=" + data.NewID;
                        }
                        $("#NyFormularz").trigger('reset');

                    } else {
                        if (data.isError == true) {
                            alert("Formularz nie został zapisany ponieważ: " + data.isError_opis);
                            $('#ID_Wpisu_nr').focus();
                        } else {
                            alert("Formularz nie został zapisany....")
                        }
                    }
                },
                error: function (response) {
                    alert("ERROR" + response);
//                   $("#errorPass").show();
                }
            });
        } else {
            alert("Wpisz poprawną(e) datę(y) od '" + fromDate + "' do dziś!");
        }

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $("#email").change(function () {
        var email = $("#email").val();

        if (isEmail(email)) {
            $("#email").css("background-color", "#00ff00");
//            $("#email_success").show().css("background-color", "#00ff00");;
//            $("#email_error").hide();
        } else {
//            $("#email").css("background-color", "#00ff00");
//            $("#email_success").hide()
            $("#email").show().css("background-color", "#ff0000");
        }
    })

    // wpisuje rok w danych formularza    
    $("#data_utworzenia").change(function () {
        var year = '';
        var data_u = new Date($("#data_utworzenia").val());

        if (data_u != null) {
            year = data_u.getFullYear();
        } else {
            year = now.getFullYear();
        }
        $("#rokFormularza").val(year);
    });

    // Sprawdzenie czy wprowdzony nr formularza w danym roku istnieje w BD !!!
    $("#ID_Wpisu_nr").on("change", function () {
        var data_u = new Date($("#data_utworzenia").val());
        var year = data_u.getFullYear();

        if (data_u != null) {
//            alert("data_u ! null")
            year = data_u.getFullYear();
        } else {
//            alert("data_u null")
            year = now.getFullYear();
        }
        var id = $("#ID_Wpisu_nr").val();
        var nyID = id + "/" + year;

        $("#rokFormularza").val(year);

//        $.ajax({
//            type: "POST",
//            url: url,
//            data: {action: "kur", checkID: nyID},
//            success: function(response){
//                alert(response);
//            },
//            error: function(){
//                alert("error in AJAX");
//            }
//        });

    });

    // wpisuje wiek matki
    $("#data_urodzenia_matka").change(function () {
        var data_u = new Date(this.value);
        var text = CalculateAge(data_u);
        $("#wiek_matki_dzis").val(text);

        var temp = $("#data_utworzenia").val();
        var data_y = new Date(temp);

        if (temp != "") {
            var text2 = CalculateAge2(data_u, data_y);
            $("#wiek_matka_wtedy").val(text2);
        }
    });

    // wpisuje wiek dziecka
    $("#data_urodzenia_dziecko").change(function () {
        var data_u = new Date(this.value);
        var text = CalculateAge(data_u);
        $("#wiek_dziecka_dzis").val(text);

        var text_date = FormatDateToString(data_u);
        $('#data_01').val(text_date);

        var temp = $("#data_utworzenia").val();
        var data_y = new Date(temp);

        if (temp != "") {
            var text2 = CalculateAge2(data_u, data_y);
            $("#wiek_dziecka_wtedy").val(text2);
        }
    });

    $('#ktore_dziecko').change(function () {
        if ($('#ktore_dziecko').val() == 2) {
            console.log("2-e dziecko");
            $('#dziecko_pop_show').show();

            $('#dziecko_pop2_show').hide();
            $('#imie_dziecka_pop2').val('');
            $('#karmienie_piers_pop2_opis').val('');
            $('input:radio[name="karmienie_piers_pop2"]').prop('checked', false);
        } else if ($('#ktore_dziecko').val() > 2) {
            console.log("3-e lub więcej dziecko");
            $('#dziecko_pop2_show').show();
        } else {
            console.log("pierwsze dziecko");
            $('#dziecko_pop_show').hide();
            $('#imie_dziecka_pop').val('');
            $('#karmienie_piers_pop_opis').val('');
            $('input:radio[name="karmienie_piers_pop"]').prop('checked', false);
            
            $('#dziecko_pop2_show').hide();
        }
    });

    $("input[name='karmienie_piers_pop']").click(function () {
//        alert("karmienie_piers_pop")
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#karmienie_piers_pop_opis_show").hide();
                break;
            case '1':
                $("#karmienie_piers_pop_opis_show").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    $("input[name='karmienie_piers_pop2']").click(function () {
//        alert("karmienie_piers_pop2")
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#karmienie_piers_pop2_opis_show").hide();
                break;
            case '1':
                $("#karmienie_piers_pop2_opis_show").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='miejsce_urodzenia_quest']").click(function () {
        if (this.value == 0) {
            $("#show_szpital").show();
            $("#show_innemiejsce").hide();
//            $("#show_innemiejsce").remove();
            $("#urodz_ulica_nr_mieszkanie").hide();
        } else {
            $("#show_szpital").hide();
//            $("#show_szpital").remove();
            $("#show_innemiejsce").show();
            $("#urodz_ulica_nr_mieszkanie").show();
        }
    });

    // radiobutton    
    $("#urodzone_czas").change(function () {
        var temp = this.value;

        switch (temp) {
            case 'o czasie':
                $("#pozniej_opis").hide();
                $("#wcześniej").hide();
                break;
            case 'wcześniej':
                $("#pozniej_opis").hide();
                $("#wcześniej").show();
                break;
            case 'później':
                $("#pozniej_opis").show();
                $("#wcześniej").hide();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("#porod").change(function () {
        var temp = this.value;

        switch (temp) {
            case 'normalny':
                $("#jaki_porod").hide();
                break;
            case 'zabiegowy':
                $("#jaki_porod").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='problem_dziecko']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#problem_dziecko_opis").hide();
                break;
            case '1':
                $("#problem_dziecko_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='problem_mama']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#problem_mama_opis").hide();
                break;
            case '1':
                $("#problem_mama_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='karmienie_piersia']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#karmienie_piersia_opis").hide();
                break;
            case '1':
                $("#karmienie_piersia_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='kapturek']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#kapturek_opis").hide();
                break;
            case '1':
                $("#kapturek_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='dopajanie']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#dopajanie_opis_all").hide();
                break;
            case '1':
                $("#dopajanie_opis_all").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='nawal']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#nawal_opis").hide();
                break;
            case '1':
                $("#nawal_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='karmienie_piers']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#karmienie_piers_opis").hide();
                break;
            case '1':
                $("#karmienie_piers_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='kapturek2']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#kapturek2_opis").hide();
                break;
            case '1':
                $("#kapturek2_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='dopajanie2']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#dopajanie2_opis_all").hide();
                break;
            case '1':
                $("#dopajanie2_opis_all").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='karmienie_noc']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#karmienie_noc_opis").hide();
                break;
            case '1':
                $("#karmienie_noc_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='sciaganie_pokarm']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#sciaganie_pokarm_opis").hide();
                break;
            case '1':
                $("#sciaganie_pokarm_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='uspokajacz']").click(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#uspokajacz_opis").hide();
                break;
            case '1':
                $("#uspokajacz_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // CHECKBOX - CYCKI
//    $("input[type='checkbox']").click(function(){
//    $("input[id='cyckiID']").click(function(){
//    $("#cyckiID").click(function () {
    $("#cycki").click(function () {
//        alert("Checkbox state (method 1) = " + $("#cyckiID").prop('checked'));
//        alert("Checkbox state (method 2) = " + $("#cyckiID").is(':checked'));

        if ($("#cycki").prop('checked')) {
            $("#foto_cycki").show();
//            $("#foto_cycki_inf").show();
        } else {
            $("#foto_cycki").hide();
//            $("#foto_cycki_inf").hide();
            $("#obszar").val("");
            $("#zmiana_opis_pict").val("");
        }

    });

    // radiobutton
    $("#brodawka").change(function () {
        var temp = this.value;
        switch (temp) {
            case 'prawidlowa':
                $("#brodawka_jaka").hide();
                break;
            case 'rzekomo_wklesla':
                $("#brodawka_jaka").show();
                break;
            case 'wklesla':
                $("#brodawka_jaka").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    // radiobutton
    $("input[name='zmiany']").change(function () {
        var temp = this.value;
        switch (temp) {
            case '0':
                $("#zmiany_opis").hide();
                break;
            case '1':
                $("#zmiany_opis").show();
                break;
            default:
                alert(" o default!");
                break;
        }
    });

    $("#add_01").click(function () {
//        alert("Checkbox state (method 1) = " + $("#cyckiID").prop('checked'));
//        alert("Checkbox state (method 2) = " + $("#cyckiID").is(':checked'));

        if ($("#add_01").prop('checked')) {
            $("#add_02_show").show();
        } else {
            $("#add_02_show").hide();
            $("input[name='masa_inne_b']").val('');
            $("input[name='data_03b']").val('');

        }

    });
    $("#add_02").click(function () {
//        alert("Checkbox state (method 1) = " + $("#cyckiID").prop('checked'));
//        alert("Checkbox state (method 2) = " + $("#cyckiID").is(':checked'));

        if ($("#add_02").prop('checked')) {
            $("#add_03_show").show();
        } else {
            $("#add_03_show").hide();
            $("input[name='masa_inne_c']").val('');
            $("input[name='data_03c']").val('');
        }

    });
    $("#add_03").click(function () {
//        alert("Checkbox state (method 1) = " + $("#cyckiID").prop('checked'));
//        alert("Checkbox state (method 2) = " + $("#cyckiID").is(':checked'));

        if ($("#add_03").prop('checked')) {
            $("#add_04_show").show();
        } else {
            $("#add_04_show").hide();
            $("input[name='masa_inne_d']").val('');
            $("input[name='data_03d']").val('');
        }

    });
    $("#add_04").click(function () {
//        alert("Checkbox state (method 1) = " + $("#cyckiID").prop('checked'));
//        alert("Checkbox state (method 2) = " + $("#cyckiID").is(':checked'));

        if ($("#add_04").prop('checked')) {
            $("#add_05_show").show();
        } else {
            $("#add_05_show").hide();
            $("input[name='masa_inne_e']").val('');
            $("input[name='data_03e']").val('');
        }

    });
    $("#add_05").click(function () {
//        alert("Checkbox state (method 1) = " + $("#cyckiID").prop('checked'));
//        alert("Checkbox state (method 2) = " + $("#cyckiID").is(':checked'));

        if ($("#add_05").prop('checked')) {
            $("#add_06_show").show();
        } else {
            $("#add_06_show").hide();
            $("input[name='masa_inne_f']").val('');
            $("input[name='data_03f']").val('');
        }

    });

    function  pobierz_szpitale() {
        var names = [];
        var ulices = [];

        $.ajax({
            type: "POST",
            url: url,
            data: '&action=takeSzpitals', // serializes the form's elements.
            success: function (response) {
                var data = jQuery.parseJSON(response);
//                   alert("ok: "+data.outp + "\n"+ data.actions); // show response from the php script.
//                $("#message").html('<br>DATA SQL:<br>' + data.SQL +
//                        '<br>DATA.OUTP' + data.outp +
////                                        '<br>DATA ACTIONS:<br>'+data.actions+
//                        '<br>DATA ERRORs:<br>' + data.error +
//                        '<br>DATA Info:<br>' + data.info
//                        );
                for (var i = 0; i < data.outp.length; i++) {
                    console.log(data.outp[i][2]);
                    names.push(data.outp[i][2])
                }

                for (var i = 0; i < names.length; i++) {
//            alert(ar[i]);
                    $('#pobrane_miejsce').append("<option value='" + names[i] + "' >" + names[i] + "</option>");
                }

                $('#pobrane_miejsce').on("change", function (event) {
                    var index = '';
                    for (var i = 0; i < data.outp.length; i++) {
                        if (data.outp[i][2] == this.value) {
                            index = i;
                        }
                    }

                    $("input[name='miejsce_urodzenia_quest'][value='0']").attr('checked', true);

                    $("#show_szpital").show()
                    $("#miejsce_urodzenia_sz").val(data.outp[index][1]);
                    $("#show_innemiejsce").hide();
                    $("#urodz_ulica_nr_mieszkanie").hide();
                    $("#urodz_ulica").val(data.outp[index][3]);
                    $("#urodz_ulica_nr").val(data.outp[index][4]);
                    $("#urodz_kod_poczt").val(data.outp[index][6]);
                    $("#urodz_miasto").val(data.outp[index][7]);
                    $("#urodz_kraj").val(data.outp[index][8]);
                });
            },
            error: function (response) {
                alert("ERROR" + response);
//                   $("#errorPass").show();
            }
        });
    }

    function dateCheck(from, check) {

        var fDate, lDate, cDate;
        fDate = Date.parse(from);
        lDate = new Date();
        cDate = Date.parse(check);

        if ((cDate <= lDate && cDate >= fDate)) {
            return true;
        }
        return false;
    }



});