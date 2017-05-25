<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    AddSzpitalAJAX.php
 * Encoding:    UTF-8
 * Created:     2016-08-17
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
error_reporting(E_ERROR | E_PARSE);

require_once "../common.inc.php";
include '../DB/Connection.php';

$baza = "`bartilev_klinika_demo`";

$NewID = "";
$OldID = "";


if (isset($_POST['action'])) {

    switch ($_POST['action']) {
        case 'add':
            // czy jest taki rekord?
            $SQL_takeID = "SELECT `idSzpital` FROM $baza.`szpital` "
                    . "WHERE (`nazwa` = '" . $_POST['nazwa'] . "' OR `skrot_nazwy` = '" . $_POST['skrot_nazwy'] . "') AND `urodz_miasto` = '" . $_POST['urodz_miasto'] . "';";
            $SQL .= "\nSQL_takeID: [$SQL_takeID]";
            $mq = mysqli_query($DBConn, $SQL_takeID);
            $res = mysqli_fetch_row($mq);
            
            $info .= "\n RES(OLD ID)".$res[0];
            $OldID = $res[0];

            if ($res[0] == null) {
                $info .= "\n DODAJEMY REKORD, bo RES(OLD ID) == null: ".$res[0];
                $SQL_insert = "INSERT INTO $baza.`szpital`"
                        . "(`nazwa`, `skrot_nazwy`, `urodz_ulica`, `urodz_ulica_nr`, "
                        . "`urodz_kod_poczt`, `urodz_miasto`, `urodz_kraj`, `czyNIESzpital`)"
                        . " VALUES ('" . $_POST['nazwa'] . "','" . $_POST['skrot_nazwy'] . "','" . $_POST['urodz_ulica'] . "',"
                        . "'" . $_POST['urodz_ulica_nr'] . "','" . $_POST['urodz_kod_poczt'] . "','" . $_POST['urodz_miasto'] . "',"
                        . "'" . $_POST['urodz_kraj'] . "', false);";

                $SQL .= "\nSQL_insert: [$SQL_insert]";
                $mq = mysqli_query($DBConn, $SQL_insert);
                
                if ($mq) {
                    $info .= "Dane Szpitala utworzone";
//                    $SQL_takeID_ = "SELECT `idSzpital` FROM $baza.`szpital` "
//                            . "WHERE `nazwa` = '" . $_POST['nazwa'] . "' AND `urodz_miasto` = '" . $_POST['urodz_miasto'] . "';";

                    $mq = mysqli_query($DBConn, $SQL_takeID);
                    $res = mysqli_fetch_row($mq);

                    $where = " WHERE `idSzpital` = '" . $res[0] . "';";
                    $NewID = $res[0];
                } else {
                    $error .= "Dane Szpitala NIE utworzone";
                }
            } else {
//                $info .= "\n DODAJEMY REKORD, bo RES(OLD ID) == null: ".$res[0];
                $error .= "\nTaki rekord (Szpital) jest już w BD res0(ID) =".$res[0];
            }

            break;
        default:
            break;
    }
}
//
$SQL_Szpital = "SELECT * FROM $baza.`szpital` $where;";
$SQL .= "<br>SQL_Szpital: [$SQL_Szpital]";

$result = mysqli_query($DBConn, $SQL_Szpital);

$rows = array();
while ($r = mysqli_fetch_assoc($result)) {
//    array_push($rows, $r);
}

$SQL = array('SQL' => "$SQL");
$error = array('error' => "$error");
$info = array('info' => "$info");
$newId = array('NewID' => "$NewID");
$OldID = array('OldID' => "$OldID");

array_push($rows, $SQL);
array_push($rows, $info);
array_push($rows, $error);
array_push($rows, $newId);
array_push($rows, $OldID);

echo json_encode($rows);

