<?php
/****************************************************
 * Project:     Klinika_Local
 * Filename:    LoginAJAX.php
 * Encoding:    UTF-8
 * Created:     2016-08-05
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
error_reporting(E_ERROR | E_PARSE);

require_once "../common.inc.php";
include '../DB/Connection.php';

$baza = "`bartilev_klinika_demo`";

$error = "";
$valid = false;
$actions = '';
$SQL = '';
$outp = '';
$name = '';
$user = '';
$IP = '';



// sprawdzenie bieżącego IP!!!!!!!
$u = "http://ipv4.myexternalip.com/raw";

if(file_get_contents($u)){
    $IP =  file_get_contents($u);
}else{
    $IP = "127.0.0.1";
}

if(isset($_POST['action'])){
    $actions = "AKCJA JEST".$_POST['action'];
    
    switch($_POST['action']){
        case 'login':
//            echo "\nLOGIN\n";
            if(isset($_POST['email']) && isset($_POST['pass'])){
                $log = $_POST['email'];
                $pass = sha1($_POST['pass']);             
            }
                        
            if($log!="" && $pass!=""){
                $SQL = "SELECT * FROM $baza.`users` WHERE (`anvandersnamn` = '$log' OR `email` = '$log') "
                        . "AND `losenord` = '$pass';";
                
                if($result = mysqli_query($DBConn, $SQL)){
                    $rs = $result->fetch_array(MYSQLI_ASSOC);
                    $user = $rs['imie']." ".$rs['nazwisko'];
                                                            
                    if($rs['idUsers']!=""){
                        $valid = true;

                        $SQL_set_crud = "UPDATE $baza.`users` SET `activ`=true,`last_logg`=CURRENT_TIMESTAMP ,"
                                        . "`IP` = '$IP' WHERE `idUsers` = '".$rs['idUsers']."';";
                        
                        if( mysqli_query($DBConn, $SQL_set_crud)){
                            $actions .="SQL_set_crud OK";
                            
                            $_SESSION["ID_USER"] = $rs['idUsers'];
                            $_SESSION["user_demo"] = $user;
                            $_SESSION["logCrud_demo"]['IP'] = $IP;
                            $_SESSION["logCrud_demo"]['logTime'] = time();
                            $_SESSION["logCrud_demo"]['anvandersnamn'] = $rs['anvandersnamn'];
                                    
                        }else{
                            $error .="nie poszedł SQL_set_crud:[$SQL_set_crud]";
                        }
                    }
                }else{
                    $error .="nie poszedł SQL:$SQL";
                }
                
                $Fin_Arr = array(
                                "valid"=>$valid,
                                "actions"=>$actions,
                                "error"=>$error, 
                                "SQL"=>$SQL, 
                                "outp"=>$outp, 
                                "user"=>$user,
                                "IP"=>$IP);
            }else{
                $error = "puste:(log:$log)lub/i(pass:$pass)";
            }
            break;
       
        case 'logOut':  
            
            unset($_SESSION["ID_USER"]);
            unset($_SESSION["user_demo"]);
            unset($_SESSION["logCrud_demo"]);
            
            $SQL_Logg_out = "UPDATE $baza.`users` SET `activ`=false, `IP` = null WHERE `activ` = 1;";
            if( mysqli_query($DBConn, $SQL_Logg_out)){
                $actions .="SQL_set_crud OK";
                $SQL .=$SQL_Logg_out;
            }else{
                $error .="nie poszedł SQL_set_crud:[$SQL_Logg_out]";
                $SQL .= $SQL_Logg_out;
            }

            $Fin_Arr = array(
                "valid"=>false,
                "actions"=>$actions,
                "error"=>$error, 
                "SQL"=>$SQL, 
                "outp"=>$outp, 
                "user"=>$user,
                "IP"=>$IP);
            break;
                    
        case 'editCrud':        // Nie zrobione!!! => Edycja w EditCrud.php
            $log = $request->email;
            $pass = $request->pass;
            
            if($log!="" && $pass!=""){
                $SQL = "SELECT * FROM $baza.`users` WHERE (`anvandersnamn` = '$log' OR `losenord` = '$pass') AND `email` = '$log';";

                if($result = mysqli_query($DBConn, $SQL)){
                    $rs = $result->fetch_array(MYSQLI_ASSOC);
                    $outp = $rs['imie']." ".$rs['nazwisko'];
                                        
                    if($rs['idUsers']!=""){
                        $valid = true;

//                        $SQL_set_crud = "UPDATE $baza.`users` SET `activ`=true,`last_logg`=CURRENT_TIMESTAMP ,`IP` = '$IP' WHERE `idUsers` = '".$rs['idUsers']."';";
                        $SQL_set_crud = "";
                        if( mysqli_query($DBConn, $SQL_set_crud)){
                            $actions .="SQL_set_crud OK";
                        }else{
                            $error .="nie poszedł SQL_set_crud:[$SQL_set_crud]";
                        }
                    }
                }else{
                    $error .="nie poszedł SQL:$SQL";
                }
                
                $Fin_Arr = array(
                    "valid"=>$valid,
                    "actions"=>$actions,
                    "error"=>$error, 
                    "SQL"=>$SQL, 
                    "outp"=>$outp, 
                    "user"=>$user,
                    "IP"=>$IP);
            }else{
                $error = "puste:(log:$log)lub/i(pass:$pass)";
            }
            break;
            
        default:
            $Fin_Arr = array(
                "valid"=>$valid,
                "actions"=>$actions,
                "error"=>$error, 
                "SQL"=>$SQL, 
                "outp"=>$outp, 
                "user"=>$user,
                "IP"=>$IP);
            break;
    }
}else{
    $actions = "NIE JEST AKCJA";
    $Fin_Arr = array(
                    "valid"=>'err',
                    "actions"=>'err',
                    "error"=>'err', 
                    "SQL"=>'err', 
                    "outp"=>'err', 
                    "user"=>'err',
                    "IP"=>'err');
}

 echo json_encode($Fin_Arr);





