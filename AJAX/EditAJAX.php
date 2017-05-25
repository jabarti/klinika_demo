<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    EditAJAX.php
 * Encoding:    UTF-8
 * Created:     2016-08-06
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
error_reporting(E_ERROR | E_PARSE);

require_once "../common.inc.php";
include '../DB/Connection.php';

$baza = "`bartilev_klinika_demo`";

$valid = false;
$actions = '';
$error = "";
$SQL = '';
$outp = '';
$user = '';
$IP = '';
$info = '';
$SQL_info = "";
$przerwa = "\n============================================\n";
$Szpital_akcja_edit = true;
$NEW_id_szpital = "";
$POSTdata = "";
$Szpit_OLD_ID = "";

//$id_wpisu = "4/2016";

foreach ($_POST as $k => $v) {
    $POSTdata .= "\n[$k => $v]";
}


if (isset($_POST['action'])) {

    $action = $_POST['action'];
//    $action = "edit";

    switch ($action) {
        case 'init':
            $info .= "\n(" . __LINE__ . ")aktion:init" . $przerwa;
            $id_wpisu = $_POST['id_wpisu'];
            break;

        case 'edit':
            // Najpierw czy szpital się zmienił, potem form, form2, itd
            $info .= "\n(" . __LINE__ . ") aktion:edit" . $przerwa;

            if (!isset($_POST['ID_Wpisu'])) {
                $id_wpisu = $_POST['id_wpisu_pre'];
            } else {
                $id_wpisu = $_POST['ID_Wpisu'];
            }
            $info .= "\n(" . __LINE__ . ") ID_wpisu:" . $id_wpisu;

            if ($_POST['miejsce_urodzenia_quest'] == 0) {     // Szpital!!
                $nazwa = $_POST['miejsce_urodzenia_sz'];
                $info .= "\n(" . __LINE__ . ") nazwa:" . $nazwa;
            } else {
                $nazwa = $_POST['miejsce_urodzenia_im'];
                $info .= "\n(" . __LINE__ . ") nazwa:" . $nazwa;
            }
            // sprawdzam czy nie ma takiej nazwy SZPITALA już w tym mieście
            $SQL_Szpital_Test = "SELECT count(*) FROM $baza.`szpital` WHERE `nazwa` = '" . $nazwa . "' AND `urodz_miasto` = '" . $_POST['urodz_miasto'] . "' AND `czyNIESzpital` = '" . $_POST['miejsce_urodzenia_quest'] . "';";
            $SQL_info .= "\n(" . __LINE__ . ")SQL_Szpital_Test:[$SQL_Szpital_Test]" . $przerwa;

            $mq = mysqli_query($DBConn, $SQL_Szpital_Test);
            $ile_rec = mysqli_fetch_row($mq);
            $ile_rec = $ile_rec[0];
            $info .= "\n(" . __LINE__ . ")Ile recordów szpitali: $ile_rec";

            if ($ile_rec == 0) {
                $info .= "\n(" . __LINE__ . ")NOWY REKORD FAKTYCZNIE";
                $Szpital_akcja_edit = false;
            } else if ($ile_rec == 1) {
                $Szpital_akcja_edit = true;
                $info .= "\n(" . __LINE__ . ")EDYCJA STAREGO";

                // Pobieramy ID_Szpitala jeśli UPDATE
                $SQL_Szpital_Old_id = "SELECT `idSzpital` FROM $baza.`szpital` WHERE `nazwa` = '" . $nazwa . "' AND `urodz_miasto` = '" . $_POST['urodz_miasto'] . "' AND `czyNIESzpital` = '" . $_POST['miejsce_urodzenia_quest'] . "';";
                $SQL_info .= "\n(" . __LINE__ . ")SQL_Szpital_Old_id:[$SQL_Szpital_Old_id]" . $przerwa;
                $mq = mysqli_query($DBConn, $SQL_Szpital_Old_id);
                $Szpit_OLD_ID = mysqli_fetch_row($mq);

//                foreach($Szpit_OLD_ID as $ki => $vi){
//                    $SQL_info .= "\nrec: $ki => $vi";
//                }

                $Szpit_OLD_ID = $Szpit_OLD_ID[0];
                $info .= "\n(" . __LINE__ . ")OLD_ID: $Szpit_OLD_ID";
            } else {
                $Szpital_akcja_edit = "ERROR";
                $info .= "\n(" . __LINE__ . ")EDYCJA STAREGO?? Wiele rekordów o takiej nazwie, ERROR!, ale robimy kolejny!";
            }

            if ($Szpital_akcja_edit && $Szpit_OLD_ID != "") {
                $SQL_Szpital = "UPDATE $baza.`szpital` SET `nazwa`='" . $nazwa . "',`urodz_ulica`='" . $_POST['urodz_ulica'] . "',
                                    `urodz_ulica_nr`='" . $_POST['urodz_ulica_nr'] . "',`urodz_ulica_nr_mieszkanie`='" . $_POST['urodz_ulica_nr_mieszkanie'] . "',
                                    `urodz_kod_poczt`='" . $_POST['urodz_kod_poczt'] . "',`urodz_miasto`='" . $_POST['urodz_miasto'] . "',`urodz_kraj`='" . $_POST['urodz_kraj'] . "',
                                    `czyNIESzpital`='" . $_POST['miejsce_urodzenia_quest'] . "' 
                                    WHERE `idSzpital`= '" . $Szpit_OLD_ID . "';";
            } else {
                $SQL_Szpital = "INSERT INTO $baza.`szpital`"
                        . "( `nazwa`, `urodz_ulica`, `urodz_ulica_nr`, `urodz_ulica_nr_mieszkanie`, "
                        . "`urodz_kod_poczt`, `urodz_miasto`, `urodz_kraj`, `czyNIESzpital`) "
                        . "VALUES ('" . $nazwa . "','" . $_POST['urodz_ulica'] . "','" . $_POST['urodz_ulica_nr'] . "',"
                        . "'" . $_POST['urodz_ulica_nr_mieszkanie'] . "','" . $_POST['urodz_kod_poczt'] . "','" . $_POST['urodz_miasto'] . "',"
                        . "'" . $_POST['urodz_kraj'] . "','" . $_POST['miejsce_urodzenia_quest'] . "');";
            }

            $SQL_info .= "\n(" . __LINE__ . ")SQL_Szpital:[$SQL_Szpital]" . $przerwa;

            $mq = mysqli_query($DBConn, $SQL_Szpital);
            if ($mq) {
                $info .= "\n(" . __LINE__ . ")Szpital dodany lub zmieniony";

                // Jeśli był zmieniany, musze pobrać nowe ID itp
                if (!$Szpital_akcja_edit) {
                    $SQL_take_data = "SELECT `idSzpital` FROM $baza.`szpital` WHERE `nazwa` = '" . $nazwa . "' AND `urodz_miasto` = '" . $_POST['urodz_miasto'] . "';";
                    $SQL_info .= "\n(" . __LINE__ . ")SQL_take_data:[$SQL_take_data]" . $przerwa;

                    $mq = mysqli_query($DBConn, $SQL_take_data);
                    if ($mq) {
                        $NEW_id_szpital = mysqli_fetch_row($mq);
                        $NEW_id_szpital = $NEW_id_szpital[0];
                        $info .= "\n(" . __LINE__ . ")NOWE ID: " . $NEW_id_szpital;
                    } else {
                        // jeśli był UPDATE to nowe ID = stare ID
                        $NEW_id_szpital = $Szpit_OLD_ID;
                        $error .= "\n(" . __LINE__ . ")Szpital NIE dodany lub zmieniony";
                    }
                }
            } else {
                $error .= "\n(" . __LINE__ . ")Szpital NIE dodany lub zmieniony";
            }

            $Set_Form_01 = "";
            $Set_Form_02 = "";
            $Set_Form_03 = "";
            $Set_Matka = "";
            $changeCycki = false;   // jeśli cycki zostaną ODZNACZONE, to w ogóle się nie pojawią na liście itrzeba usunąć checkboxa!!!

            foreach ($_POST as $k => $v) {
                switch ($k) {
                    // Dane niezmienne!!!
                    case 'ID_Wpisu':
                    case 'data_utworzenia':
                    case 'Matka_idMatka':
                    case 'idMatka':     //??? czy nie zmieniać?
                    // weszły do szpital wcześniej
                    case 'urodz_ulica':
                    case 'urodz_ulica_nr':
                    case 'urodz_ulica_nr_mieszkanie':
                    case 'urodz_kod_poczt':
                    case 'urodz_miasto':
                    case 'urodz_kraj':
                        break;

                    // FORM 1
                    case 'imie_dziecka':
                    case 'data_urodzenia_dziecko':
                    case 'ktore_dziecko':

                    case 'imie_dziecka_pop':
                    case 'karmienie_piers_pop':
                    case 'karmienie_piers_pop_opis':
                        
                    case 'imie_dziecka_pop2':
                    case 'karmienie_piers_pop2':
                    case 'karmienie_piers_pop2_opis':

                    case 'urodzone_czas':
                    case 'ile_wczesniej':
                    case 'porod':
                    case 'jaki_porod':
                    case 'leki_porod':
                    case 'leki_polog':
//                    case 'powod_zgloszenia':
//                    case 'miejsce':
                        $Set_Form_01 .= "`$k` = '$v',";
                        break;
                    case 'miejsce_urodzenia_quest':
                        $Set_Form_01 .= "`miejsce` = '$v',";
                        if ($NEW_id_szpital == "") {
                            $Set_Form_01 .= "`id_SzpitalOrInne` = '$Szpit_OLD_ID',";
                        } else {
                            $Set_Form_01 .= "`id_SzpitalOrInne` = '$NEW_id_szpital',";
                        }

                        $info .= "\n(" . __LINE__ . ")NOWE ID_Szp: " . $NEW_id_szpital;
                        break;
                    case 'powod_zgloszenia':
                        $Set_Form_01 .= "`$k` = '$v'";
                        break;

                    // FORM 2
                    case 'pierwsze_karmienie':
                    case 'problem_dziecko':
                    case 'problem_dziecko_opis':
                    case 'problem_mama':
                    case 'problem_mama_opis':
                    case 'karmienie_piersia':
                    case 'karmienie_piersia_opis':
                    case 'kapturek':
                    case 'kapturek_opis':
                    case 'dopajanie':
                    case 'dopajanie_czym':
                    case 'dopajanie_jak_dlugo':
                    case 'dopajanie_opis':
                    case 'nawal':
                    case 'nawal_opis':
                    case 'pobyt':
                    case 'karmienie_piers':
                    case 'karmienie_piers_czest':
                    case 'karmienie_piers_dlugo':
                    case 'kapturek2':
                    case 'kapturek2_opis':
                    case 'dopajanie2':
                    case 'dopajanie2_czym':
                    case 'dopajanie2_jak_dlugo':
                    case 'dopajanie2_opis':
                    case 'karmienie_noc':
                    case 'karmienie_noc_opis':
                    case 'sciaganie_pokarm':
                    case 'sciaganie_pokarm_cel':
                    case 'sciaganie_pokarm_ile':
                    case 'pieluchy':
                    case 'pieluchy':
                    case 'stolec':
                    case 'aktywnosc':
                    case 'zachowanie_karmienia':
                    case 'kolka':
                    case 'uspokajacz':
                    case 'uspokajacz_opis':
                    case 'leki_matka':
                        $Set_Form_02 .= "`$k` = '$v',";
                        break;

                    case 'leki_dziecko': //ostatnie z serii
                        $Set_Form_02 .= "`$k` = '$v'";
                        break;

                    // FORM 3
                    case 'piers_wielkosc':
//                    case 'cycki':
                    case 'obszar':
                    case 'zmiana_opis_pict':
                    case 'brodawka':
                    case 'brodawka_jaka':
                    case 'zmiany':
                    case 'zmiany_opis':
                    case 'stan_emocjonalny':
                    case 'obserwacja_dziecka':
                    case 'masa_ur':
                    case 'data_01':
                    case 'masa_min':
                    case 'data_02':
                    case 'masa_inne_a':
                    case 'data_03a':
                    case 'masa_inne_b':
                    case 'data_03b':
                    case 'masa_inne_c':
                    case 'data_03c':
                    case 'masa_inne_d':
                    case 'data_03d':
                    case 'masa_inne_e':
                    case 'data_03e':
                    case 'masa_inne_f':
                    case 'data_03f':
                    case 'masa_obecna':
                    case 'data_04':
                    case 'przyrost_sredni':
                    case 'zachowanie_dziecka_wizyta':
                    case 'otwieranie_ust':
                    case 'ulozenie_ust':
                    case 'ulozenie_jezyka':
                    case 'ruchy_kasajace':
                    case 'ruchy_ssace':
                    case 'ocena_karmienie_piers':
                    case 'rozpoznanie':
                    case 'korekta_poz':
                    case 'trening_ssania':
                    case 'dokarmianie':
                        $Set_Form_03 .= "`$k` = '$v',";
                        break;
                    
                    case 'cycki':
                        $changeCycki = true;
                        if ($v == "on") {
                            $var = true;
                        } else {
                            $var = false;
                        }
                        $Set_Form_03 .= "`$k` = $var,";
                        break;

                    case 'zalecenia_inne': //ostatnie z serii
                        if (!$changeCycki) { // cycki nie zaznaczone, lub zostały odznaczone!! i nie weszły do case 'cycki'
                            $Set_Form_03 .= "`cycki` = false,";
                        }
                        $Set_Form_03 .= "`$k` = '$v'";
                        break;

                    //Matka
//  (`idMatka`, `mama_firstname`, `mama_lastname`, `data_urodzenia_matka`, `ulica`, `ulica_nr`, 
//  `ulica_nr_mieszkanie`, `kod_poczt`, `miasto`, `telefon`, `email`

                    case 'mama_firstname':
                    case 'mama_lastname':
                    case 'data_urodzenia_matka':
                    case 'ulica':
                    case 'ulica_nr':
                    case 'ulica_nr_mieszkanie':
                    case 'ulica_nr_mieszkanie':
                    case 'kod_poczt':
                    case 'miasto':
                    case 'telefon':
                        $Set_Matka .= "`$k` = '$v',";
                        break;

                    case 'email': //ostatnie z serii
                        $Set_Matka .= "`$k` = '$v'";
                        break;

                    default:
                        $error .= "`$k` = '$v',";
                        break;
                }
            }

            $SQL_Edit_Upp_Form_01 = "UPDATE $baza.`formularz` SET " . $Set_Form_01 . " WHERE `ID_Wpisu` = '$id_wpisu';";
            $SQL_info .= "SQL_Edit_Upp_Form_01:[$SQL_Edit_Upp_Form_01]" . $przerwa;

            $mq = mysqli_query($DBConn, $SQL_Edit_Upp_Form_01);
            if ($mq) {
                $info .= "\n(" . __LINE__ . ") Weszło do FORM_01!";

                // FORM 02
                $SQL_Edit_Upp_Form_02 = "UPDATE $baza.`formularz_2` SET " . $Set_Form_02 . " WHERE `ID_Wpisu` = '$id_wpisu';";
                $SQL_info .= "SQL_Edit_Upp_Form_02:[$SQL_Edit_Upp_Form_02]" . $przerwa;

                $mq2 = mysqli_query($DBConn, $SQL_Edit_Upp_Form_02);

                if ($mq2) {
                    $info .= "\n(" . __LINE__ . ") Weszło do FORM_02!";

                    // FORM 03
                    $SQL_Edit_Upp_Form_03 = "UPDATE $baza.`formularz_3` SET " . $Set_Form_03 . " WHERE `ID_Wpisu` = '$id_wpisu';";
                    $SQL_info .= "SQL_Edit_Upp_Form_03:[$SQL_Edit_Upp_Form_03]" . $przerwa;

                    $mq3 = mysqli_query($DBConn, $SQL_Edit_Upp_Form_03);

                    if ($mq3) {
                        $info .= "\n(" . __LINE__ . ") Weszło do FORM_03!";

                        // Matka
                        $SQL_Edit_Upp_Matka = "UPDATE $baza.`matka` SET " . $Set_Matka . " WHERE `idMatka` = '" . $_POST['idMatka'] . "';";
                        $SQL_info .= "SQL_Edit_Upp_Matka:[$SQL_Edit_Upp_Matka]" . $przerwa;

                        $mqM = mysqli_query($DBConn, $SQL_Edit_Upp_Matka);

                        if ($mqM) {
                            $info .= "\n(" . __LINE__ . ") Weszło do MATKA!";
                        } else {
                            $error .= "\n(" . __LINE__ . ") NIE Weszło do MATKA!";
                        }
                    } else {
                        $error .= "\n(" . __LINE__ . ") NIE Weszło do FORM_03!";
                    }
                } else {
                    $error .= "\n(" . __LINE__ . ") NIE Weszło do FORM_02!";
                }
            } else {
                $error .= "\n(" . __LINE__ . ") NIE Weszło do FORM_01!";
            }

            // MATKA!!!!!!!!!!!!!!!!!!!!!!!!!
//            UPDATE `matka` SET `idMatka`=[value-1],`mama_firstname`=[value-2],`mama_lastname`=[value-3],`data_urodzenia_matka`=[value-4],`ulica`=[value-5],`ulica_nr`=[value-6],`ulica_nr_mieszkanie`=[value-7],`kod_poczt`=[value-8],`miasto`=[value-9],`telefon`=[value-10],`email`=[value-11] WHERE 1

            break;

        case 'takeSzpitals':

            $SQL_takeSzpitals = "Select * FROM $baza.`szpital` WHERE `czyNIESzpital` = false;";
            $SQL .= "<br>SQL_takeSzpitals:[$SQL_takeSzpitals]";

            $mq = mysqli_query($DBConn, $SQL_takeSzpitals);
            $Szpitale = array();
            while ($row = mysqli_fetch_assoc($mq)) {
                array_push($Szpitale, $row);
            }
            break;

        case 'delete':
            $info .= "\n(" . __LINE__ . ")aktion:delete" . $przerwa;
            $id_record = $_POST['id_wpisu'];
            $SQL_Delete = "DELETE FROM $baza.`formularz` WHERE `ID_Wpisu`  = '$id_record';";
            mysqli_query($DBConn, $SQL_Delete);

            if (mysqli_query($DBConn, $SQL_Delete)) {
                $SQL_Delete_2 = "DELETE FROM $baza.`formularz_2` WHERE `ID_Wpisu`  = '$id_record';";
                mysqli_query($DBConn, $SQL_Delete_2);

                if (mysqli_query($DBConn, $SQL_Delete_2)) {
                    $SQL_Delete_3 = "DELETE FROM $baza.`formularz_3` WHERE `ID_Wpisu`  = '$id_record';";
                    mysqli_query($DBConn, $SQL_Delete_3);

                    if (mysqli_query($DBConn, $SQL_Delete_3)) {
                        $SQL_Delete_4 = "DELETE FROM $baza.`id_wpis_queue` WHERE `ID_Wpisu`  = '$id_record';";
                        mysqli_query($DBConn, $SQL_Delete_4);
                        if (mysqli_query($DBConn, $SQL_Delete_4)) {
                            
                        } else {
                            $error .= "\n(" . __LINE__ . ")ERR: $SQL_Delete_4]";
                        }
                    } else {
                        $error .= "\n(" . __LINE__ . ")ERR: $SQL_Delete_3]";
                    }
                } else {
                    $error .= "\n(" . __LINE__ . ")ERR: $SQL_Delete_2]";
                }
            } else {
                $error .= "\n(" . __LINE__ . ")ERR: $SQL_Delete]";
//                echo json_encode($error);
            }
            break;

        default:
            $info .= "\n(" . __LINE__ . ")aktion:default";

            break;
    }
}

// AKCJE SZUKANIA:

$SQL_get_Record = "SELECT * FROM $baza.`FullForm` WHERE `ID_Wpisu` = '$id_wpisu'";
$SQL_info .= "SQL_get_Record: [$SQL_get_Record]" . $przerwa;

$result = mysqli_query($DBConn, $SQL_get_Record);

$rows = array();
$info .= "\n========================= DANE ============================";
while ($r = mysqli_fetch_assoc($result)) {
    array_push($rows, $r);
}

array_push($rows, $Szpitale);

if ($TEST_VER) { // To nie idzie na bartilevi.pl
    $info = array("sql" => "$SQL_info", "info" => "$info", "error" => "$error", "postData" => "$POSTdata");
    array_push($rows, $info);
}

echo json_encode($rows);
