<?php

/* * **************************************************
 * Project:     Klinika_Local
 * Filename:    index.php
 * Encoding:    UTF-8
 * Created:     2016-08-05
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 * ************************************************* */
require_once "common.inc.php";
include 'DB/Connection.php';
include 'View/Static/header.html';

if (isset($_SESSION["user_demo"]) && isset($_SESSION["logCrud_demo"])) {
    include 'View/Static/Menu_PHP.html';

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "";
    }

    switch ($page) {
        case 'nyform':
            include 'Formularz.php';
            break;
        case 'list':
            include 'Lista.php';
            break;
        case 'edit':
            include 'Edit.php';
            break;
        case 'EditCrud':
            include 'EditCrud.php';
            break;
        case 'listHosp':
            include 'ListHosp.php';
            break;
        case 'editSzpital':
            include 'editSzpital.php';
            break;
        case 'addHosp':
            include 'addSzpital.php';
            break;
        case 'listMothers':
            include 'listMothers.php';
            break;
        default:
            include 'View/Static/ShowCrud.html';
            break;
    }
} else {
    include 'View/Static/Login.html';
}
?>

<?php

if($TEST_VER){
    include 'TEST_DATA/test_data.php';
}

include 'View/Static/footer.html';
