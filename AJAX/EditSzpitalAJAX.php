<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    EditSzpitalAJAX.php
 * Encoding:    UTF-8
 * Created:     2016-08-16
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
error_reporting(E_ERROR | E_PARSE);

require_once "../common.inc.php";
include '../DB/Connection.php';

$baza = "`bartilev_klinika_demo`";


if (isset($_POST['action'])) {

    switch ($_POST['action']) {
        case 'init':
            $where = " WHERE `idSzpital` = '" . $_POST['id_record'] . "';";
            break;
        case 'edit':
            $SQL_edit = "UPDATE $baza.`szpital` SET "
                . "`nazwa`='".$_POST['nazwa']."',"
                . "`skrot_nazwy`='".$_POST['skrot_nazwy']."',"
                . "`urodz_ulica`='".$_POST['urodz_ulica']."',"
                . "`urodz_ulica_nr`='".$_POST['urodz_ulica_nr']."',"
                . "`urodz_ulica_nr_mieszkanie`='".$_POST['urodz_ulica_nr_mieszkanie']."',"
                . "`urodz_kod_poczt`='".$_POST['urodz_kod_poczt']."',"
                . "`urodz_miasto`='".$_POST['urodz_miasto']."',"
                . "`urodz_kraj`='".$_POST['urodz_kraj']."'"
                . " WHERE `idSzpital` = '".$_POST['id_record']."';";
            $SQL .= "<br>SQL_edit: [$SQL_edit]";
        $mq = mysqli_query($DBConn, $SQL_edit);
        
        if($mq){
            $info .= "Dane Szpitala zmienione";
        }else{
            $error .= "Dane Szpitala NIE zmienione";
        }

            $where = " WHERE `idSzpital` = '".$_POST['id_record']."';";
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
    array_push($rows, $r);
}

//$SQL = array('SQL' => "$SQL");
//$error = array('error' => "$error");
//$info = array('info' => "$info");

//array_push($rows, $SQL);
//array_push($rows, $info);
//array_push($rows, $error);

echo json_encode($rows);
