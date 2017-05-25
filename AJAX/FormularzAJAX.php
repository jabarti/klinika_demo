<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    FormularzAJAX.php
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
$isError = false;
$isError_opis = "";
$SQL = '';
$outp = '';
$user = '';
$IP = '';
$info = '';
$NEW_FORM_ID = "";

$Fin_Arr = array(
    "valid" => $valid,
    "actions" => $actions,
    "error" => $error,
    "isError" => $isError,
    "isError_opis" => $isError_opis,
    "SQL" => $SQL,
    "outp" => $outp,
    "user" => $user,
    "IP" => $IP,
    "NewID" => $NEW_FORM_ID,
    "info" => $info);

$ID_last_Szpital = "";


if (isset($_POST['action'])) {
    $actions .= "AKCJA JEST: (" . $_POST['action'] . ")";

    foreach ($_POST as $k => $v) {
        $outp .= "<br>'$k' => '$v',";
    }

    switch ($_POST['action']) {
        
        case 'addNytt':
            $Matka_kolumns = "";
            $Matka_values = "";

            $Szpital_kolumns = "";
            $Szpital_values = "";

            $Form_01_kolumns = "";
            $Form_01_values = "";

            $Form_02_kolumns = "";
            $Form_02_values = "";

            $Form_03_kolumns = "";
            $Form_03_values = "";

            $czySzpital = true;
            if ($_POST['miejsce_urodzenia_quest'] == 0) {
                $miejsce_urodzenia = $_POST['miejsce_urodzenia_sz'];
                $czySzpital = true;
            } else {
                $miejsce_urodzenia = $_POST['miejsce_urodzenia_im'];
                $czySzpital = false;
            }

            $error .= "<br>Dane które nie weszły:<br>";

            if (isset($_POST['cycki'])) {
                $info .= "<br>1A. CYCKI chkbx: (" . $_POST['cycki'] . ")";
            } else {
                $info .= "<br>1B. CYCKI chkbx not set";
                $Form_03_kolumns .= "`cycki`,";
                $Form_03_values .= "false,";
            }

            foreach ($_POST as $k => $v) {
                switch ($k) {

                    //MATKA
                    case 'mama_firstname':
                    case 'mama_lastname':
                    case 'data_urodzenia_matka':
                    case 'ulica':
                    case 'ulica_nr':
                    case 'ulica_nr_mieszkanie':
                    case 'kod_poczt':
                    case 'miasto':
                    case 'telefon':
                        $Matka_kolumns .= "`$k`,";
                        $Matka_values .= "'$v',";
                        break;
                    case 'email':           // ostatnie z serii!!
                        $Matka_kolumns .= "`$k`";
                        $Matka_values .= "'$v'";
                        break;

                    //SZPITAL
                    case 'miejsce_urodzenia_quest':
                        $Szpital_kolumns .= "`czyNIESzpital`,";
                        $Szpital_values .= "'$v',";
                        break;
                    case 'miejsce_urodzenia_sz':
                        if ($czySzpital) {
                            $Szpital_kolumns .= "`nazwa`,";
                            $Szpital_values .= "'$v',";
                        }
                        break;
                    case 'miejsce_urodzenia_im':
                        if (!$czySzpital) {
                            $Szpital_kolumns .= "`nazwa`,";
                            $Szpital_values .= "'$v',";
                        }
                        break;
                    case 'urodz_ulica':
                    case 'urodz_ulica_nr':
                    case 'urodz_ulica_nr_mieszkanie':
                    case 'urodz_kod_poczt':
                    case 'urodz_miasto':
                        $Szpital_kolumns .= "`$k`,";
                        $Szpital_values .= "'$v',";
                        break;
                    case 'urodz_kraj':      // ostatnie z serii
                        $Szpital_kolumns .= "`$k`";
                        $Szpital_values .= "'$v'";
                        break;

                    // FORMULARZ 01
                    case 'ID_Wpisu_nr':
                        break;

                    case 'data_utworzenia':
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
                    case 'powod_zgloszenia':
                        $Form_01_kolumns .= "`$k`,";
                        $Form_01_values .= "'$v',";
                        break;

                    // FORMULARZ 02
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
                    case 'stolec':
                    case 'aktywnosc':
                    case 'aktywnosc':
                    case 'zachowanie_karmienia':
                    case 'kolka':
                    case 'uspokajacz':
                    case 'uspokajacz_opis':
                    case 'leki_matka':
                        $Form_02_kolumns .= "`$k`,";
                        $Form_02_values .= "'$v',";
                        break;    
                    
                    case 'leki_dziecko':       // ostatnie z serii
                        $Form_02_kolumns .= "`$k`";
                        $Form_02_values .= "'$v'";
                        break;

                    // FORMULARZ 03

                    case 'cycki':  // checkbox

                        $Form_03_kolumns .= "`$k`,";
                        $Form_03_values .= "true,";

                        $info .= "<br>CYCKI chkbx: ($k) => ($v)";
                        break;

                    case 'piers_wielkosc':
                    case 'cycki_jakie':
                    case 'zmiana_opis_pict':
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
                        $Form_03_kolumns .= "`$k`,";
                        $Form_03_values .= "'$v',";
                        break;
                    case 'zalecenia_inne':      // ostatnie z serii
                        $Form_03_kolumns .= "`$k`";
                        $Form_03_values .= "'$v'";
                        break;

                    default:
                        $error .= "('$k' => '$v'),";
                        break;
                }
            }

// MATKA !!!!!!
            // Wrzucenie Matki do DB
            // TEST czy matka taka jest w BD

            $czyMatkaByłaBD = false;
            $isAddMatkaOK = false;

            $MataTESTsql = "SELECT `idMatka` FROM $baza.`matka` WHERE "
                    . "     `mama_firstname` = '" . $_POST['mama_firstname'] . "'"
                    . "AND  `mama_lastname` = '" . $_POST['mama_lastname'] . "' "
                    . "AND  `data_urodzenia_matka` = '" . $_POST['data_urodzenia_matka'] . "' LIMIT 1;";
            $SQL .= "<br>MataTESTsql:[$MataTESTsql]";
            $Matka_SQL_q = mysqli_query($DBConn, $Matka_SQL);

            if ($Matka_SQL_q) {
                $MamaSql_q_TEST = mysqli_query($DBConn, $MataTESTsql);
                $row = mysqli_fetch_array($MamaSql_q_TEST);
                $Last_Mama_ID = $row[0];

                $info .= "<br>Last_Mama_ID: $Last_Mama_ID";
                $error .= "<br>Taka Matka już jest w BD!!";

                $czyMatkaByłaBD = true;
                $isAddMatkaOK = true;
            } else {
                $czyMatkaByłaBD = false;
                $info .= "<br>Takiej Matki BRAK w BD!";
            }

            // Nie sprawdzamy czy mama już jest w Bazie - Klient's demand
            $Matka_SQL = "INSERT INTO $baza.`matka` ($Matka_kolumns) VALUES ( $Matka_values );";
            $SQL .= "<br>Matka_SQL:[$Matka_SQL]";

            // Matki nie ma w BD, to dodajemy
            if (!$czyMatkaByłaBD) {
                if ($_POST['mama_firstname'] != "" && $_POST['mama_lastname'] != "" && $_POST['data_urodzenia_matka'] != "") {
                    $Matka_SQL_q = mysqli_query($DBConn, $Matka_SQL);

                    if ($Matka_SQL_q) {
                        $MamaSql_q_TEST = mysqli_query($DBConn, $MataTESTsql);
                        $row = mysqli_fetch_array($MamaSql_q_TEST);
                        $Last_Mama_ID = $row[0];
                        $isAddMatkaOK = true;

                        $info .= "<br>Last_Mama_ID: $Last_Mama_ID";
                    } else {
                        $error .= ", MAMA insert nie OK";
                    }
                } else {
                    $error .= "<br>Nie ma wystarczających danych do dodania matki!!!!!";
                }
            }

// SZPITAL !!!!!
            // Sprawdzam, czy takie miejsce w BD
            // Są dwie możliwości szpital albo inne miejsce
            $ID_last_Szpital = "";
            $CzyIdwBD = true;

            // Sprawdzam, czy coś w ogóle przyszło
            if ($miejsce_urodzenia == "") {
                $czyPustaNazwa = true;
            } else {
                $czyPustaNazwa = false;
            }

            if (!$czyPustaNazwa) {
                $TakeLastIdSzpit = "SELECT `idSzpital` FROM $baza.`szpital` WHERE "
                        . "`nazwa` = '$miejsce_urodzenia' "
                        . "AND `urodz_ulica` = '" . $_POST['urodz_ulica'] . "' LIMIT 1;;";
                $SQL .= "<br>TakeLastIdSzpit:[$TakeLastIdSzpit]";

                $mysql_q1 = mysqli_query($DBConn, $TakeLastIdSzpit);

                if (mysqli_num_rows($mysql_q1) > 0) {
                    while ($row = mysqli_fetch_assoc($mysql_q1)) {
                        $info .= "<br>idSzpital: " . $row['idSzpital'];
                        $ID_last_Szpital = $row['idSzpital'];
                    }
                    $CzyIdwBD = true;
                    $error .= "<br>[BYŁ SZPITAL w BD], CzyIdwBD = $CzyIdwBD";
                } else {
                    $CzyIdwBD = false;
                    $info .= "[NIE BYŁO SZPITALA w BD - zapis do BD], CzyIdwBD = $CzyIdwBD";

                    // Dodawanie rekordu
                    $Szpital_SQL = "INSERT INTO $baza.`szpital` ($Szpital_kolumns) "
                            . "VALUES ($Szpital_values);";

                    $SQL .= "<br>Szpital_SQL:[$Szpital_SQL]";

                    $SzpitalSql_q_test = mysqli_query($DBConn, $Szpital_SQL);

                    if ($SzpitalSql_q_test) {
                        $TakeLastIdSzpit = "SELECT `idSzpital` FROM $baza.`szpital` WHERE "
                                . " `nazwa` = '$miejsce_urodzenia' "
                                . "  AND `urodz_ulica` = '" . $_POST['urodz_ulica'] . "' LIMIT 1;;";
                        $SQL .= "<br>TakeLastIdSzpit2:[$TakeLastIdSzpit]";

                        $mysql_q1 = mysqli_query($DBConn, $TakeLastIdSzpit);

                        if (mysqli_num_rows($mysql_q1) > 0) {
                            while ($row = mysqli_fetch_assoc($mysql_q1)) {
                                $info .= "<br>idSzpital: " . $row['idSzpital'];
                                $ID_last_Szpital = $row['idSzpital'];
                            }
                            $CzyIdwBD = true;
                            $info .= "Szpital dodany do BD!! & ID_last_Szpital = $ID_last_Szpital";
                        } else {
                            $error .= "Błąd z dodaniem szpitala";
                        }
                    } else {
                        $error .= "<br>Szpital nie został dodany!!!!";
                    }
                }
            } else {
                $error .= "<br>Szpital bez nazwy - brak procesowania!!!";
                $ID_last_Szpital = '1';
            }

// FORMULARZ
            $rok_formularza = $_POST['data_utworzenia'];
            $SQL_Take_Last_ID = "SELECT `ID_Wpisu` FROM $baza.`formularz` WHERE year(`data_utworzenia`) = year('$rok_formularza');";
            $SQL .= "<br>SQL_Take_Last_ID:[$SQL_Take_Last_ID]";

            $mq_01 = mysqli_query($DBConn, $SQL_Take_Last_ID);

            $array_ID = array();
            $info .= "<br>Form IDs: ";
            while ($row = mysqli_fetch_array($mq_01)) {
                $info .= $row[0] . ", ";
                $arrID = split('/', $row[0]);
                array_push($array_ID, $arrID[0]);
            }

            // Jeśli nie wprowadzono wpisu w Formularzu, utworzenie nasępnego automatycznie
            $ID_Wpisu = $_POST['ID_Wpisu_nr'];

            if ($ID_Wpisu == "") {
//            $arrID = split('/',$row[0]);
                $info .= ", 1.OLD ID_Wpis: [" . max($array_ID) . "]";
                $id_temp = max($array_ID) + 1;
                $info .= ", 1. NEW ID_Wpis: [$id_temp]";
                $IsProperID = true;
            } else {
                $info .= ", 2.OLD ID_Wpis: [" . max($array_ID) . "]";
                if (in_array($ID_Wpisu, $array_ID)) {
                    $info .= "UWAGA! Wpis o tym numerze już istnieje!!!";
                    $IsProperID = false;
                    $isError = true;
                    $isError_opis = "Istnieje formularz o takim ID";
                } else {
                    $id_temp = $ID_Wpisu;
                    $info .= ", 2.NEW ID_Wpis (z formularza): [$id_temp]";
                    $IsProperID = true;
                }
            }
//          Sprawdzenie czy taki formularz już jest w BD (wg. ID_Wpis i danych wprowadzanych)
//          $data_temp = substr($data_urodzenia_dziecko, 0,10);        // uzyskanie formatu daty rrrr-mm-dd
            $IsFormularzInDB_sql = "SELECT `ID_Wpisu` FROM $baza.`formularz` WHERE "
                    . "`Matka_idMatka` = '$Last_Mama_ID' "
                    . "AND `imie_dziecka` = '" . $_POST['imie_dziecka'] . "' "
                    . "AND `data_urodzenia_dziecko` = '" . $_POST['data_urodzenia_dziecko'] . "';";
            $SQL .= "<br>$IsFormularzInDB_sql:[$IsFormularzInDB_sql]";

            $msql_q_FID = mysqli_query($DBConn, $IsFormularzInDB_sql);

            if (mysqli_num_rows($msql_q_FID) > 0) {
                while ($row = mysqli_fetch_assoc($msql_q_FID)) {
                    $info .= "<br>id: " . $row["ID_Wpisu"];
                    $$ID_Wpisu = $row["ID_Wpisu"];
                    $IsFormularzInDB = true;
                    $info .= "<br>[Jest taki Wpis w Formularz]";
                }
                $info .= ",ID_Wpisu[$ID_Wpisu][$IsFormularzInDB_sql] , ";
            } else {
                $info .= "<br>[Brak takiego Wpisu w Formularz]";
                $IsFormularzInDB = false;
            }

            // Wprowadzenie rekordu do BD (Formularz)
            $dataUtw_rok = substr($rok_formularza, 0, 4);

            $NEW_FORM_ID = "$id_temp/$dataUtw_rok";
            $info .= "\nNEW_FORM_ID: $NEW_FORM_ID,";

            $info .= "<br>[DATA: ($rok_formularza)($dataUtw_rok)($NEW_FORM_ID)]";

//            $Form_01_kolumns = "";
//            $Form_01_values = "";

            $Formularz_SQL = "INSERT INTO $baza.`formularz` ( $Form_01_kolumns"
                    . "`ID_Wpisu`, `Matka_idMatka`, `miejsce`,`id_SzpitalOrInne`) "
                    . "VALUES ( $Form_01_values "
                    . "'$NEW_FORM_ID', '$Last_Mama_ID', '" . $_POST['miejsce_urodzenia_quest'] . "','$ID_last_Szpital');";

            $SQL .= "<br>Formularz_SQL:[$Formularz_SQL]";

// ID_WPIS_QUEUE - tabela pomocnicza
            // Kolejnośc prawidłowa ID_Wpis(string)
            $ID_Wpis_queue_SQL = "INSERT INTO $baza.`id_wpis_queue`(`ID_Wpisu`, `ID`, `Rok`) "
                    . "VALUES ('$NEW_FORM_ID','$id_temp','$dataUtw_rok')";
            $SQL .= "<br>ID_Wpis_queue_SQL:[$ID_Wpis_queue_SQL]";

            $IsForm1OK = false;

            if (!$IsFormularzInDB && $IsProperID && $isAddMatkaOK) {

                $FormularzSql_q = mysqli_query($DBConn, $Formularz_SQL);


                if ($FormularzSql_q) {
                    $info .= "<br>[Formularz1 insert OK]:";
                    $IsForm1OK = true;
                    $ID_Wpis_q = mysqli_query($DBConn, $ID_Wpis_queue_SQL); // <= INSERT do ID_Wpis_queue
                    if (!$ID_Wpis_q) {
                        $error.= "<br>Error: [$ID_Wpis_queue]";
                    }
                } else {
                    $error .= ", [Formularz1 insert NOT OK] [$FormularzSql]";
                }
            } else {
                $error .= ", [Formularz BYŁ w BD lub złe id:($NEW_FORM_ID)]";
            }

// FORMULARZ 2
            $IsForm2OK = false;

            if ($IsForm1OK) {
                $Formularz2_SQL = "INSERT INTO $baza.`formularz_2`"
                        . "(`ID_Wpisu`, $Form_02_kolumns) "
                        . "VALUES "
                        . "('$NEW_FORM_ID', $Form_02_values);";
                $SQL .= "<br>Formularz2_SQL:[$Formularz2_SQL]";

                $mq2 = mysqli_query($DBConn, $Formularz2_SQL);
                if ($mq2) {
                    $info .= "<br>[Form2 w BD!!]";
                    $IsForm2OK = true;
                } else {
                    $error .= "<br>[Form2 ERROR][$Formularz2_SQL]";
                }
            }

// FORMULARZ 3        
            if ($IsForm2OK) {
                $Formularz3_SQL = "INSERT INTO $baza.`formularz_3`"
                        . "(`ID_Wpisu`,$Form_03_kolumns ) "
                        . "VALUES "
                        . "('$NEW_FORM_ID', $Form_03_values);";
                $SQL .= "<br>Formularz3_SQL:[$Formularz3_SQL]";

                $mq3 = mysqli_query($DBConn, $Formularz3_SQL);
                if ($mq3) {
                    $info .= "<br>[Form3 w BD!!]";
                } else {
                    $error .= "<br>[Form3 ERROR]";
                }
            } else {
                $error .= "<br>[Form2/3 ERROR](IsForm2OK == false)($IsForm2OK)";
            }

            $Fin_Arr = array(
                "valid" => false,
                "actions" => $actions,
                "error" => $error,
                "isError" => $isError,
                "isError_opis" => $isError_opis,
                "SQL" => $SQL,
                "outp" => $outp,
                "user" => $user,
                "IP" => $IP,
                "NewID" => $NEW_FORM_ID,
                "info" => $info);
            break;
            
        case 'takeSzpitals':
            
            $SQL_takeSzpitals = "Select * FROM $baza.`szpital` WHERE `czyNIESzpital` = false;";
            $SQL .= "<br>SQL_takeSzpitals:[$SQL_takeSzpitals]";
            
            $mq = mysqli_query($DBConn, $SQL_takeSzpitals);
            $outp = array();
            while($row = mysqli_fetch_row($mq)){
                array_push($outp, $row);
            }

            $Fin_Arr = array(
                "valid" => false,
                "actions" => $actions,
                "error" => $error,
                "isError" => $isError,
                "isError_opis" => $isError_opis,
                "SQL" => $SQL,
                "outp" => $outp,
                "user" => $user,
                "IP" => $IP,
                "NewID" => $NEW_FORM_ID,
                "info" => $info);
            break;
    }
}


echo json_encode($Fin_Arr);
