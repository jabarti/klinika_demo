<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    ListaAJAX.php
 * Encoding:    UTF-8
 * Created:     2016-08-07
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

$where = "";

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'search':
            $info .= "<br>AKCJA: searcz";

            if (isset($_POST['mama_lastname'])) {
                $mama_lastname = $_POST['mama_lastname'];

                if ($mama_lastname == "") {
                    $error .= "<br>SEARCZ: Przyszły puste dane";
                } else {
                    $where = "WHERE `mama_lastname` LIKE '%$mama_lastname%'";
                }
            }

            break;
        case 'init':
            $where = "";
            $order = "";
            break;

        case 'order':
            $var_search = $_POST['poczym'];
            $var_upordown = $_POST['updown'];
            $where = "";
            $order = "";

            if ($var_upordown == "down") {
                $order = "order by `$var_search` ASC";
            } else {
                $order = "order by `$var_search` DESC";
            }

            break;

        case 'deleteRec':
            $id_record = $_POST['id_rec'];
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
                            $error .= "[ERR: $SQL_Delete_4]";
                        }
                    } else {
                        $error .= "[ERR: $SQL_Delete_3]";
                    }
                } else {
                    $error .= "[ERR: $SQL_Delete_2]";
                }
            } else {
                $error .= "[ERR: $SQL_Delete]";
                echo json_encode($error);
                
            }
            break;

        default:
            $info .= "<br>AKCJA: default";
            break;
    }
}

// AKCJE SZUKANIA:

$SQL_View_mama_dziecko = "SELECT * FROM $baza.`view_matka_dziecko` $where $order;";
$SQL .= "<br>SQL_View_mama_dziecko: [$SQL_View_mama_dziecko]";

$result = mysqli_query($DBConn, $SQL_View_mama_dziecko);

$rows = array();
while ($r = mysqli_fetch_assoc($result)) {
    array_push($rows, $r);
}

echo json_encode($rows);


