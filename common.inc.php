<?php
//session_start();
/**
 * common.inc.php
 *
 * Includes all necessary files for the project.
 *
 * @author Bartosz Lewiński <jabarti@wp.pl>
 *
 */

if(!isset($_SESSION)){
//    ob_start();
    session_start();
}

//if(isset($_POST)){
//    if(isset($_POST['submitLOG'])){
//        // to to co przeszło z logera, jeszcze nie wiadomo czy jest taki user!!
//        $_SESSION['submitLOG']['user'] = $_POST['user'];
//        $_SESSION['submitLOG']['password'] = sha1($_POST['password']);
//        unset($_POST['submitLOG']);
//    }else{
////        unset($_SESSION['submitLOG']);
//    }
//}

$REMOTE_ADDR = false;
//echo "REMOTE ADDR:".$_SERVER["REMOTE_ADDR"];//=> string(14) "81.234.110.249";

$ServerList = array(
                    "85.202.150.195",       // Częstochowa, Obr.Westerplatte 11
                    "85.202.149.116",       //Częstochowa, Nałkowskiej
                    "92.32.53.158",         //Mullsjö, felixplace
                    "78.72.219.220",        //Mullsjö, Tomtebovägen
                    "87.96.247.203",        //Mullsjö, Tomtebovägen 
                    "217.160.168.247",      //Germany 1
                    "217.160.165.170"       //Germany 2
                    );  
//if(in_array($_SERVER["REMOTE_ADDR"],$ServerList)){
////    echo "Admin IP Address: ".$_SERVER["REMOTE_ADDR"];
//    $REMOTE_ADDR = "true";
//    echo $_SERVER["REMOTE_ADDR"];
//}

/*Ustalenie innego czasu logu dla serwera "wlasnego" i dla "zewnętrznego"*/
//if($REMOTE_ADDR){
//    $log_hours = 22;
//    $log_min = 60*30;    
//}else{
//    $log_hours = 0;
//    $log_min = 60*45;
//}
//foreach($_SERVER as $k => $v){
//    echo "<br>$k \t=> $v";
//}
$TEST_VER = false;
if($_SERVER['SERVER_NAME'] == "localhost"){
    $TEST_VER = true;
}

// Address list
$FORM01_PATH = "View/Static/Form_01/";
$EDIT01_PATH = "View/Static/Edit_01/";

