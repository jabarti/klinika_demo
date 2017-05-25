/****************************************************
 * Project:     Klinika_Local
 * Filename:    EditController.js
 * Encoding:    UTF-8
 * Created:     2016-08-06
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {

    var url = "AJAX/EditAJAX.php"; // the script where you handle the form input.
    var Url_id_record = getUrlProperty("id_record");
    $('#cycki_show').hide();

    // POBRANIE PODSTAWOWYCH  DANYCH
    $.ajax({
        type: "POST",
        url: url,
        data: 'action=init&id_wpisu=' + Url_id_record, // serializes the form's elements.
        success: function (response) {
            var data = jQuery.parseJSON(response);

//            LoadCyckiPict(data);
            Make_Records(data);
            loadUstawienia();
            LoadCyckiPict(data);
            CountAge();

            $('#sql').val(data[2]['sql']);
            $('#info').val(data[2]['info']);
            $('#error').val(data[2]['error']);
            $('#post').val(data[2]['post']);
        },
        error: function (response) {
            alert("ERROR w EditCtrl 26" + response);
        }
    });

// EDYCJA REKORDU
    $('#submit').click(function () {
//        alert("edit")
        $.ajax({
            type: "POST",
            url: url,
            data: $("#EditForm").serialize() + '&action=edit&id_wpisu_pre=' + Url_id_record, // serializes the form's elements.
            success: function (response) {
                var data = jQuery.parseJSON(response);
                if (data != null) {
                    Make_Records(data);
                    loadUstawienia()
                }
                $('#sql').val(data[2]['sql']);
                $('#info').val(data[2]['info']);
                $('#error').val(data[2]['error']);
                $('#post').val(data[2]['post']);
            },
            error: function (response) {
                alert("ERROR w EditCtrl 43" + response);
            }
        });
    });

    // KASOWANIE REKORDU   
    $('#delete').click(function () {
//        alert("delete")
        if (confirm("Delete form?")) {
            $.ajax({
                type: "POST",
                url: url,
                data: 'action=delete&id_wpisu=' + Url_id_record, // serializes the form's elements.
                success: function (response) {
                    window.location.href = 'index.php?page=list';
                },
                error: function (response) {
                    alert("ERROR w EditCtrl 59" + response);
                }
            });
        }
    });


// FUNKCJA PAKUJĄCA DANE DO FORMULARZA
    function Make_Records(data) {

////        $("#data_utworzenia").mask("9999-99-99", {placeholder: "yyyy-mm-dd"});
//        $("#data_urodzenia_matka").mask("9999-99-99", {placeholder: "yyyy-mm-dd"});
//        $("#data_urodzenia_dziecko").mask("9999-99-99", {placeholder: "yyyy-mm-dd"});
//        $("#kod_poczt").mask("99-999");
//        $("#urodz_kod_poczt").mask("99-999");
//        $("#telefon").mask("+99 999 999 999", {placeholder: "+48 xxx xxx xxx"});

        $('#data_utworzenia').val(data[0]['data_utworzenia']);
        $('#ID_Wpisu').val(data[0]['ID_Wpisu']);

        $('#idMatka').val(data[0]['Matka_idMatka']); //<= hidden!!!

        $('#mama_firstname').val(data[0]['mama_firstname']);
        $('#mama_lastname').val(data[0]['mama_lastname']);
        $('#data_urodzenia_matka').val(data[0]['data_urodzenia_matka']);
        $('#ulica').val(data[0]['ulica']);
        $('#ulica_nr').val(data[0]['ulica_nr']);
        $('#ulica_nr_mieszkanie').val(data[0]['ulica_nr_mieszkanie']);
        $('#kod_poczt').val(data[0]['kod_poczt']);
        $('#miasto').val(data[0]['miasto']);
        $('#telefon').val(data[0]['telefon']);

        $('#imie_dziecka').val(data[0]['imie_dziecka']);
        $('#data_urodzenia_dziecko').val(data[0]['data_urodzenia_dziecko']);
        $('#ktore_dziecko').val(data[0]['ktore_dziecko']);

        if (data[0]['ktore_dziecko'] == 2) {
            $('#dziecko_pop_show').show();
            $('#imie_dziecka_pop').val(data[0]['imie_dziecka_pop']);
            radioAddProperties("karmienie_piers_pop", data, null);
            $('#karmienie_piers_pop_opis').val(data[0]['karmienie_piers_pop_opis']);
        } else if (data[0]['ktore_dziecko'] > 2) {
            $('#dziecko_pop_show').show();
            $('#imie_dziecka_pop').val(data[0]['imie_dziecka_pop']);
            radioAddProperties("karmienie_piers_pop", data, null);
            $('#karmienie_piers_pop_opis').val(data[0]['karmienie_piers_pop_opis']);
//            $('#dziecko_pop_show').show();
            $('#dziecko_pop2_show').show();
            $('#imie_dziecka_pop2').val(data[0]['imie_dziecka_pop2']);
            radioAddProperties("karmienie_piers_pop2", data, null);
            $('#karmienie_piers_pop2_opis').val(data[0]['karmienie_piers_pop2_opis']);
        } else {
            $('#dziecko_pop_show').hide();
            $('#dziecko_pop2_show').hide();
        }

        //SZPITAL TO DO!!!!
        // id_SzpitalOrInne, miejsce
        // radiobutton
        pobierz_szpitale();


        $('#urodz_ulica').val(data[0]['urodz_ulica']);
        $('#urodz_ulica_nr').val(data[0]['urodz_ulica_nr']);
        $('#urodz_ulica_nr_mieszkanie').val(data[0]['urodz_ulica_nr_mieszkanie']);
        $('#urodz_kod_poczt').val(data[0]['urodz_kod_poczt']);
        $('#urodz_miasto').val(data[0]['urodz_miasto']);
        $('#urodz_kraj').val(data[0]['urodz_kraj']);

        $('#urodzone_czas').val(data[0]['urodzone_czas']); // <= SELECT!!!!! --> attr("selected","selected")???, obsługa hidden
        $('#ile_wczesniej').val(data[0]['ile_wczesniej']);


        $('#porod').val(data[0]['porod']); // <= SELECT!!!!! --> attr("selected","selected")???, obsługa hidden
        $('#jaki_porod').val(data[0]['jaki_porod']);

        $('#leki_porod').val(data[0]['leki_porod']);
        $('#leki_polog').val(data[0]['leki_polog']);

        $('#powod_zgloszenia').val(data[0]['powod_zgloszenia']);

        $('#pierwsze_karmienie').val(data[0]['pierwsze_karmienie']);

        radioAddProperties("problem_dziecko", data, ["problem_dziecko_opis"]);

        radioAddProperties("problem_mama", data, ["problem_mama_opis"]);

        radioAddProperties("karmienie_piersia", data, ["karmienie_piersia_opis"]);

        radioAddProperties("kapturek", data, ["kapturek_opis"]);
//        alert("kapt shof?")

        radioAddProperties("dopajanie", data, ["dopajanie_czym", "dopajanie_opis", "dopajanie_jak_dlugo"]);

        radioAddProperties("nawal", data, ["nawal_opis"]);

        radioAddProperties("pobyt", data, null);

        radioAddProperties("karmienie_piers", data, ["karmienie_piers_czest", "karmienie_piers_dlugo"]);

        radioAddProperties("kapturek2", data, ["kapturek2_opis"]);
//        alert("kapt2 shof?")

        radioAddProperties("dopajanie2", data, ["dopajanie2_czym", "dopajanie2_jak_dlugo", "dopajanie2_opis"]);

        radioAddProperties("karmienie_noc", data, ["karmienie_noc_opis"]);

        radioAddProperties("sciaganie_pokarm", data, ["sciaganie_pokarm_cel", "sciaganie_pokarm_ile"]);

//        ShowHide("uspokajacz", ["uspokajacz_opis"]);
//        ShowHide("zmiany", ["zmiany_opis"]);

        szpitalAction(data);


        $('#pieluchy').val(data[0]['pieluchy']);
        $('#stolec').val(data[0]['stolec']);

        radioAddProperties("aktywnosc", data, null);

        $('#zachowanie_karmienia').val(data[0]['zachowanie_karmienia']);

        radioAddProperties("kolka", data, null);
        radioAddProperties("uspokajacz", data, ["uspokajacz_opis"]);

        $('#leki_matka').val(data[0]['leki_matka']);
        $('#leki_dziecko').val(data[0]['leki_dziecko']);

        radioAddProperties("piers_wielkosc", data, null);

//        alert("ustawienia cycki")
        checkboxAddProperties("cycki", data, ["obszar", "zmiana_opis_pict"])
//        alert("Po ust cycków")

//        LoadCyckiPict();

        $('#brodawka').val(data[0]['brodawka']);
        $('#brodawka_jaka').val(data[0]['brodawka_jaka']);

        radioAddProperties("zmiany", data, ["zmiany_opis"]);

        $('#brodawka_jaka').val(data[0]['brodawka_jaka']);
        $('#stan_emocjonalny').val(data[0]['stan_emocjonalny']);

        $('#obserwacja_dziecka').val(data[0]['obserwacja_dziecka']);

        $('#masa_ur').val(data[0]['masa_ur']);
        $('#data_01').val(data[0]['data_01']);

        $('#masa_min').val(data[0]['masa_min']);
        $('#data_02').val(data[0]['data_02']);

        $('#masa_inne_a').val(data[0]['masa_inne_a']);
        $('#data_03a').val(data[0]['data_03a']);

        checkboxAddPropertiesBACK(["masa_inne_b", "data_03b"], data, "add_01");
        checkboxAddPropertiesBACK(["masa_inne_c", "data_03c"], data, "add_02");
        checkboxAddPropertiesBACK(["masa_inne_d", "data_03d"], data, "add_03");
        checkboxAddPropertiesBACK(["masa_inne_e", "data_03e"], data, "add_04");
        checkboxAddPropertiesBACK(["masa_inne_f", "data_03f"], data, "add_05");

        $('#masa_obecna').val(data[0]['masa_obecna']);
        $('#data_04').val(data[0]['data_04']);
        $('#przyrost_sredni').val(data[0]['przyrost_sredni']);
        $('#zachowanie_dziecka_wizyta').val(data[0]['zachowanie_dziecka_wizyta']);


        radioAddProperties("otwieranie_ust", data, null);
        radioAddProperties("ulozenie_ust", data, null);
        radioAddProperties("ulozenie_jezyka", data, null);
        radioAddProperties("ruchy_kasajace", data, null);
        radioAddProperties("ruchy_ssace", data, null);

        $('#ocena_karmienie_piers').val(data[0]['ocena_karmienie_piers']);
        $('#rozpoznanie').val(data[0]['rozpoznanie']);

        radioAddProperties("korekta_poz", data, null);
        radioAddProperties("trening_ssania", data, null);
        radioAddProperties("dokarmianie", data, null);

        $('#zalecenia_inne').val(data[0]['zalecenia_inne']);

        // TEST
        if (data[1] != undefined) {
            $('#sql').val(data[1]['sql']);
            $('#info').val(data[1]['info']);
            $('#error').val(data[1]['error']);
            $('#post').val(data[1]['postData']);
        }
    }

// Funkcja ładująca ustawienia bazowe róznych inputów
    function loadUstawienia() {
        ShowHide("miejsce", ["urodz_ulica_nr_mieszkanie"]);

        var communicate = "Czy skasować dane "
        var zapytajnik = "?"

        $('#ktore_dziecko').change(function () {
            if ($('#ktore_dziecko').val() == 2) {
                $('#dziecko_pop_show').show();
                $('#dziecko_pop2_show').hide();
                if ($('#imie_dziecka_pop2').val() != '') {
                    if (confirm(communicate + $('#imie_dziecka_pop2').val() + zapytajnik)) {
                        $('#imie_dziecka_pop2').val('');
                        $('#karmienie_piers_pop2_opis').val('');
                        $('input:radio[name="karmienie_piers_pop2"]').prop('checked', false);
                    }
                }
            } else if ($('#ktore_dziecko').val() > 2) {
                $('#dziecko_pop_show').show();
                $('#dziecko_pop2_show').show();
            } else {
                $('#dziecko_pop_show').hide();
                if ($('#imie_dziecka_pop').val() != '') {
                    if (confirm(communicate + $('#imie_dziecka_pop').val() + zapytajnik)) {
                        $('#imie_dziecka_pop').val('');
                        $('#karmienie_piers_pop_opis').val('');
                        $('input:radio[name="karmienie_piers_pop"]').prop('checked', false);
                    }
                }

                $('#dziecko_pop2_show').hide();
            }
        });
        
        ShowHide("problem_dziecko", ["problem_dziecko_opis"]);
        ShowHide("problem_mama", ["problem_mama_opis"]);
        ShowHide("karmienie_piersia", ["karmienie_piersia_opis"]);
        ShowHide("kapturek", ["kapturek_opis"]);
//        alert("kapt shof?")
        ShowHide("dopajanie", ["dopajanie_czym", "dopajanie_opis", "dopajanie_jak_dlugo"]);
        ShowHide("nawal", ["nawal_opis"]);
        ShowHide("karmienie_piers", ["karmienie_piers_czest", "karmienie_piers_dlugo"]);
        ShowHide("kapturek2", ["kapturek2_opis"]);
//        alert("kapt2 shof?")
        ShowHide("dopajanie2", ["dopajanie2_czym", "dopajanie2_jak_dlugo", "dopajanie2_opis"]);
        ShowHide("karmienie_noc", ["karmienie_noc_opis"]);
        ShowHide("sciaganie_pokarm", ["sciaganie_pokarm_cel", "sciaganie_pokarm_ile"]);
        ShowHide("uspokajacz", ["uspokajacz_opis"]);
        ShowHide("zmiany", ["zmiany_opis"]);

        ShowHideCyc();
//        szpitalAction(data)

//        ShowHide_chbx("add_01", ["data_03a", "masa_inne_a"])


        ShowHide_opt("urodzone_czas", ["ile_wczesniej"], "o czasie");
        ShowHide_opt("porod", ["jaki_porod"], "normalny");
        ShowHide_opt("brodawka", ["brodawka_jaka"], "prawidlowa");

//        $('#planetmap').mapper({
//            dataType: "provinces",
//            data: [
//                {id: "rec1"}
//            ],
//            fillColor: "blue",
//            fillOpacity: 0.85,
//            strokeColor: "red",
//            strokeWidth: 5,
//            strokeOpacity: 1
//        });
    }

// Funkcja ustawiająca akcje dla input radiobutton (chowanie przynależnych im pól opisu)
    function ShowHide(name, params) {
        var leng = params.length;
        var clean = false;

        var communikate = "";

        if (leng > 1) {
            communikate = "Czy wyczyścić wszystkie wpisy?";
        } else {
            communikate = "Czy wyczyścić również wpis?";
        }

        if ($("input[name='" + name + "']:checked").val() == 0) {
            for (var i = 0; i < leng; i++) {
                $('#' + params[i] + '_show').hide();
//                alert(params[i] + '_show HIDE');
            }
        } else {
            for (var i = 0; i < leng; i++) {
                $('#' + params[i] + '_show').show();
//                alert(params[i] + '_show SHOW');
            }
        }

        $("input[name='" + name + "']").click(function () {
//            alert("klik")
            if ($("input[name='" + name + "']:checked").val() == 0) {

                clean = confirm(communikate)
                for (var i = 0; i < leng; i++) {
                    $('#' + name + '_show').hide();
//                    alert($('#' + params[i]).val())
                    if (clean) {
                        $('#' + params[i]).removeAttr('value');
                        $('#' + params[i]).val('');
                    }
                }
            } else {
                for (var i = 0; i < leng; i++) {
                    $('#' + name + '_show').show();
                }
            }
        });
    }

// Funkcja ustawiająca akcje dla input checkbox (chowanie przynależnych im pól opisu)
    function ShowHide_chbx(name, params) {
//        alert("ShowHide_chbx" + name)
        var leng = params.length;
        var clean = false;

        var communikate = "";

        if (leng > 1) {
            communikate = "Czy wyczyścić wszystkie wpisy?";
        } else {
            communikate = "Czy wyczyścić również wpis?";
        }

        if ($("input[name='" + name + "']:checked").val() == 0) {
            for (var i = 0; i < leng; i++) {
                $('#' + params[i] + '_show').hide();
            }
        } else {
            for (var i = 0; i < leng; i++) {
                $('#' + params[i] + '_show').show();
            }
        }

        $("input[name='" + name + "']").click(function () {
            if ($("input[name='" + name + "']:checked").val() == 0) {

                clean = confirm(communikate)
                for (var i = 0; i < leng; i++) {
                    $('#' + name + '_show').hide();
//                    alert($('#' + params[i]).val())
                    if (clean) {
                        $('#' + params[i]).removeAttr('value');
                        $('#' + params[i]).val('');
                    }
                }
            } else {
                for (var i = 0; i < leng; i++) {
                    $('#' + name + '_show').show();
                }
            }
        });
    }

// Funkcja ustawiająca akcje dla input typu select-option (chowanie przynależnych im pól opisu)
    function ShowHide_opt(id, params, opt) {
        var leng = params.length;
        var clean = false;
        var communikate = "";

        if (leng > 1) {
            communikate = "Czy wyczyścić wszystkie wpisy?";
        } else {
            communikate = "Czy wyczyścić również wpis?";
        }

        if ($("#" + id).val() != opt) {
            for (var i = 0; i < leng; i++) {
                $('#' + id + '_show').show();
            }
        } else {
            for (var i = 0; i < leng; i++) {
//                alert("399: "+params[i])
                $('#' + id + '_show').hide();
            }
        }

        $("#" + id).change(function () {
            if ($("#" + id).val() != opt) {
                for (var i = 0; i < leng; i++) {
                    $('#' + id + '_show').show();
                }
            } else {
                clean = confirm(communikate);
                for (var i = 0; i < leng; i++) {
                    $('#' + id + '_show').hide();
                    if (clean) {
                        $('#' + params[i]).removeAttr('value');
                        $('#' + params[i]).val("");
                    }
                }
            }
        });
    }

// Funkcja do obsługi radio buttons - treść i array params do show/hide inputs
    function radioAddProperties(name, data, params) {
//        alert( "name: " +name + ", val: "+ data[0][name])
        $('input:radio[name="' + name + '"]').filter('[value="' + data[0][name] + '"]').attr('checked', true);
        var showNotPar = $('input:radio[name="' + name + '"][value="0"]').val();
//        alert(data[0][name] + ", " + showNotPar);
        if (params !== null) {
            if (data[0][name] != showNotPar && data[0][name] != -1) {
                for (var i = 0; i < params.length; i++) {
//                    alert(params[i] + " => " + data[0][params[i]]);
                    var text = data[0][params[i]];
                    $('#' + params[i]).val(text);
                    $('#' + name + "_show").show();
                }
            } else {
                $('#' + name + "_show").hide();
            }
        }
    }
// Funkcja do obsługi radio buttons - treść i array params do show/hide inputs
//    function radioAddProperties(name, data, params) {
//        $('input:radio[name="' + name + '"]').filter('[value="' + data[0][name] + '"]').attr('checked', true);
//        var showNotPar = $('input:radio[name="' + name + '"][value="0"]').val();
////        alert(data[0][name] + ", " + showNotPar);
//        if (params !== null) {
//            if (data[0][name] != showNotPar) {
//                for (var i = 0; i < params.length; i++) {
////                    alert(params[i] + " => " + data[0][params[i]]);
//                    var text = data[0][params[i]];
//                    $('#' + params[i]).val(text);
//                    $('#' + name + "_show").show();
//                }
//            } else {
//                $('#' + name + "_show").hide();
//            }
//        }
//    }

// Funkcja początkowa, nadaje wartości polom checkboxa
    function checkboxAddProperties(name, data, params) {
//        if(name == 'cycki'){
//            alert(name + ", " + data[0][name])
//        }
        var prop = data[0][name];
//        alert(prop)
        if (prop == 0) {
            prop = false;
        } else {
            prop = true;
//                alert(prop +"nie 0 tylko \"O\"")
        }

        // nadanie wartości:
        $('input:checkbox[name="' + name + '"]').attr('checked', prop);

        if (params != "") {
            if (prop) {
                for (var i = 0; i < params.length; i++) {
//                    console.log(params[i] + " => " + data[0][params[i]]);
                    $('#' + params[i]).val(data[0][params[i]]);
                }
                $('#' + name + "_show").show();
            } else {
                $('#' + name + "_show").hide();
            }
        } else {
            $('#' + name + "_show").hide();
        }
    }

// Funkcja początkowa, nadaje wartości polom i zaznacza chechbox.
    function checkboxAddPropertiesBACK(params, data, name) {
        var isChecked = true;
        var communikate = "Czy wyczyścić wszystkie wpisy?";

        if (params != null) {
            var leng = params.length;

            for (var i = 0; i < leng; i++) {
                var property = data[0][params[i]];
//                alert(params[i] + " => " + property)
                $('#' + params[i]).val(property);
                if (property == "") {
                    isChecked = false;
//                    alert("property: ("+property+") JEST null!!, Zatem isChecked="+isChecked)
                    // jeśli choć jedna property jest == 0 to nie wyświetlamy

                } else {
//                    alert("property: ("+property+") NIE jest null!!, Zatem isChecked="+isChecked)
                }
            }
        } else {
            isChecked = false;
        }

//        alert("Finalnie:" + name + " is checked?: " + isChecked)
        $('input:checkbox[name="' + name + '"]').attr('checked', isChecked);

        if (isChecked) {
//            console.log("pokazuje: " + name + "_show");
            $("#" + name + "_show").show();
        } else {
//            console.log("NIE pokazuje: " + name + "_show");
            $("#" + name + "_show").hide();
        }

        $('input:checkbox[name="' + name + '"]').click(function () {
//            alert("cklick")
            if (isCheckbxChecked(name)) {
                $("#" + name + "_show").show();
            } else {
                $("#" + name + "_show").hide();
//                if (confirm(communikate)) {
                if (true) {
                    for (var i = 0; i < leng; i++) {

                        $('#' + params[i]).val("");
                    }
                }
            }
        });
    }

    // Funkcja ustawiająca checkboxa "cycki" (chowanie przynależnych im pól opisu)
    function ShowHideCyc() {
//        alert("ShowHideCyc")
        var clean = false;
        var communikate = "Czy wyczyścić wszystkie wpisy?";

        if (!isCheckbxChecked("cycki")) {  // Buton jest NIE checked
//            clean = confirm(communikate)
//            clean = true
            $('#cycki_show').hide();
//            if (clean) {
//                $('#obszar').removeAttr('value');
//                $('#zmiana_opis_pict').removeAttr('value');
//                $('#obszar').val('');
//                $('#zmiana_opis_pict').val('');
//            }
        } else {
            $('cycki_show').show();
        }

        $("#cycki").click(function () {
//            alert("ShowHideCyc click")
            if (!isCheckbxChecked("cycki")) {
//                clean = confirm(communikate)

                if (confirm(communikate)) {
                    $('#obszar').removeAttr('value');
                    $('#zmiana_opis_pict').removeAttr('value');
                    $('#obszar').val('');
                    $('#zmiana_opis_pict').val('');
                }
                $('#cycki_show').hide();
            } else {
                $('#cycki_show').show();
            }
        });
    }

// For test!!
    function isCheckbxChecked(id, nr) {

        var chbx = $('#' + id).is(":checked");
        alert(nr + " -> Chbx: " + chbx)
        return chbx;
    }

    function isCheckbxChecked(id) {

        var chbx = $('#' + id).is(":checked");
        return chbx;
    }

    function szpitalAction(data) {

        if (data[0]['miejsce'] == 0) {   // szpital!!!
            $("input[name='miejsce_urodzenia_quest']").filter('[value="0"]').attr('checked', true);
            $("#szpital_show").show();
            $("#innemiejsce_show").hide();
            $("#urodz_ulica_nr_mieszkanie").hide();
            $("#miejsce_urodzenia_sz").val(data[0]['nazwa'])
        } else {
            $("input[name='miejsce_urodzenia_quest']").filter('[value="1"]').attr('checked', true);
            $("#szpital_show").hide();
            $("#innemiejsce_show").show();
            $("#urodz_ulica_nr_mieszkanie").show();
            $("#miejsce_urodzenia_im").val(data[0]['nazwa'])
        }
        var communikate = "Czy wyczyścić wszystkie wpisy?";

        $("input[name='miejsce_urodzenia_quest']").click(function () {
            var conf = confirm(communikate);
            if (this.value == 0) {
                $("#szpital_show").show();
                $("#innemiejsce_show").hide();
                $("#urodz_ulica_nr_mieszkanie").hide();
                if (conf) {
                    $("#miejsce_urodzenia_im").val("");
                    $("#urodz_ulica").val("");
                    $("#urodz_ulica_nr").val("");
                    $("#urodz_ulica_nr_mieszkanie").val("");
                    $("#urodz_kod_poczt").val("");
                    $("#urodz_kod_poczt").val("");
                    $("#urodz_miasto").val("");
                    $("#urodz_kraj").val("");
                }
            } else {
                $("#szpital_show").hide();
                $("#innemiejsce_show").show();
                $("#urodz_ulica_nr_mieszkanie").show();
                if (conf) {
                    $("#miejsce_urodzenia_sz").val("");
                    $("#urodz_ulica").val("");
                    $("#urodz_ulica_nr").val("");
                    $("#urodz_ulica_nr_mieszkanie").val("");
                    $("#urodz_kod_poczt").val("");
                    $("#urodz_kod_poczt").val("");
                    $("#urodz_miasto").val("");
                    $("#urodz_kraj").val("");
                }
            }
        });
    }

    function LoadCyckiPict(data) {
        var opisObsz = data[0]['obszar'];
//        alert(opisObsz)
        var ind = opisObsz.indexOf(':');
        var id_ob = opisObsz.substring(0, ind);

//        alert(id_ob)
        if (opisObsz != "") {
//            alert("ładuję zaznaczone zdjęie")
            $('#map_img_image').attr('src', 'img/cycki_03/anatomy_03' + opisObsz + '.jpg');
        } else {
//            alert("ładuję puste zdjęie")
            $('#map_img_image').attr('src', 'img/cycki_03/anatomy_03.jpg');
        }
//        alert("adding value"  + opisObsz)
        document.getElementById("obszar").value = opisObsz;
//        alert($('#obszar').val())


    }

    function  pobierz_szpitale() {
        var names = [];
        var index_i = "";
        var index_j = "";


        $.ajax({
            type: "POST",
            url: url,
            data: '&action=takeSzpitals', // serializes the form's elements.
            success: function (response) {
                var data = jQuery.parseJSON(response);

                for (var i = 0; i < data.length; i++) {
                    for (var j = 0; j < data[i].length; j++) {
//                        console.log(data[i][j]['skrot_nazwy']);
                        if (data[i][j]['skrot_nazwy'] != null) {
                            names.push(data[i][j]['skrot_nazwy']);
                        } else {
                            names.push(data[i][j]['nazwa']);
                        }
                    }
                }

                for (var i = 0; i < names.length; i++) {
//            alert(ar[i]);
                    $('#pobrane_miejsce').append("<option value='" + names[i] + "' >" + names[i] + "</option>");
                }

                $('#pobrane_miejsce').on("change", function (event) {
                    var index = '';
                    for (var i = 0; i < data.length; i++) {
                        for (var j = 0; j < data[i].length; j++) {
                            if (data[i][j]['skrot_nazwy'] == this.value) {
//                                alert (data[i][j]['skrot_nazwy'])
                                index_i = i;
                                index_j = j;
                            }
                        }
                    }

                    $("input[name='miejsce_urodzenia_quest'][value='0']").attr('checked', true);

                    $("#show_szpital").show()
                    $("#miejsce_urodzenia_sz").val(data[index_i][index_j]['nazwa']);
                    $("#show_innemiejsce").hide();
                    $("#urodz_ulica_nr_mieszkanie").hide();
                    $("#urodz_ulica").val(data[index_i][index_j]['urodz_ulica']);
                    $("#urodz_ulica_nr").val(data[index_i][index_j]['urodz_ulica_nr']);
                    $("#urodz_kod_poczt").val(data[index_i][index_j]['urodz_kod_poczt']);
                    $("#urodz_miasto").val(data[index_i][index_j]['urodz_miasto']);
                    $("#urodz_kraj").val(data[index_i][index_j]['urodz_kraj']);
                });
            },
            error: function (response) {
                alert("ERROR" + response);
//                   $("#errorPass").show();
            }
        });
    }

    function CountAge() {
        // wpisuje wiek matki
        $("#data_urodzenia_matka").ready(function () {
            var data_u = new Date($("#data_urodzenia_matka").val());
            var text = CalculateAge(data_u);
            $("#wiek_matki_dzis").val(text);

            var temp = $("#data_utworzenia").val();
            var data_y = new Date(temp);

            if (temp != "") {
                var text2 = CalculateAge2(data_u, data_y);
                $("#wiek_matka_wtedy").val(text2);
            }
        });

        $("#data_urodzenia_matka").change(function () {
            var data_u = new Date($("#data_urodzenia_matka").val());
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
        $("#data_urodzenia_dziecko").ready(function () {

            var data_u = new Date($("#data_urodzenia_dziecko").val());
            var text = CalculateAge(data_u);
            $("#wiek_dziecka_dzis").val(text);

            var temp = $("#data_utworzenia").val();
            var data_y = new Date(temp);

            if (temp != "") {
                var text2 = CalculateAge2(data_u, data_y);
                $("#wiek_dziecka_wtedy").val(text2);
            }
        });

        $("#data_urodzenia_dziecko").change(function () {

            var data_u = new Date($("#data_urodzenia_dziecko").val());
            var text = CalculateAge(data_u);
            $("#wiek_dziecka_dzis").val(text);

            var temp = $("#data_utworzenia").val();
            var data_y = new Date(temp);

            if (temp != "") {
                var text2 = CalculateAge2(data_u, data_y);
                $("#wiek_dziecka_wtedy").val(text2);
            }
        });
    }


});
