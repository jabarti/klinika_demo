<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    EditCrudAJAX.php
 * Encoding:    UTF-8
 * Created:     2016-08-10
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
$czyDodacInfo = false;
$rows = array();

if (isset($_POST['action'])) {
//if (true) {
//    $akt = 'checkOldPass';
    switch ($_POST['action']) {
//    switch ($akt) {

        case 'init':
            $where = " WHERE `idUsers` = '" . $_SESSION["ID_USER"] . "';";
            $order = "";
            break;

        case 'edit':
            $czyDodacInfo = true;
            // jeśli jest podane old pass to można zmienić hasła
            if (isset($_POST['losenord']) && $_POST['losenord'] != "") {
                $old_pass = sha1($_POST['losenord']);
                $new_losenord = sha1($_POST['new_losenord']);

                $SQL = "SELECT `losenord` FROM `users` WHERE `idUsers` ='" . $_SESSION["ID_USER"] . "';";
                $mq = mysqli_query($DBConn, $SQL);
                $rez = mysqli_fetch_assoc($mq);

                if ($rez['losenord'] === $old_pass) {
                    $rez = array("isGoodPass" => true);
                    // update
                    $SQL_usr = "UPDATE $baza.`users` SET `losenord`='$new_losenord',`imie`='" . $_POST['imie'] . "',`nazwisko`='" . $_POST['nazwisko'] . "',`email`='" . $_POST['email'] . "' WHERE `idUsers` = '" . $_SESSION["ID_USER"] . "';";
                    $mq = mysqli_query($DBConn, $SQL_usr);
                    if ($mq) {
                        $info = array("OK" => "$SQL_usr", "sha" => "$new_losenord");
                    } else {
                        $info = array("ERROR" => "$SQL_usr");
                    }
                } else {
                    $rez = array("isGoodPass" => false);
                    // złe hasło podano stare
                }
                // Jeśli nie podano hasła, można zmienić tylko INNE DANE niż hasła
            } else {
                // Możliwy update bez haseł
                $SQL_usr = "UPDATE $baza.`users` SET `anvandersnamn` = '" . $_POST['anvandersnamn'] . "', `imie`='" . $_POST['imie'] . "',`nazwisko`='" . $_POST['nazwisko'] . "',`email`='" . $_POST['email'] . "' WHERE `idUsers` = '" . $_SESSION["ID_USER"] . "';";
                $mq = mysqli_query($DBConn, $SQL_usr);
                if ($mq) {
                    $info = array("OK" => "$SQL_usr");
                } else {
                    $info = array("ERROR" => "$SQL_usr");
                }
            }
            
            
            $where = " WHERE `idUsers` = '" . $_SESSION["ID_USER"] . "';";
            $order = "";
            
            break;


        default:
            $info .= "<br>AKCJA: default";
            break;
    }
}

// AKCJE SZUKANIA:

$SQL_View_mama_dziecko = "SELECT `idUsers`, `anvandersnamn`, `imie`, `nazwisko`, `email`, `last_logg`, `IP` FROM $baza.`users` $where $order;";
$SQL .= "<br>SQL_View_mama_dziecko: [$SQL_View_mama_dziecko]";

$result = mysqli_query($DBConn, $SQL_View_mama_dziecko);


while ($r = mysqli_fetch_assoc($result)) {
    array_push($rows, $r);
}

if ($czyDodacInfo == true) {
    array_push($rows, $rez);
    array_push($rows, $info);
}


echo json_encode($rows);


