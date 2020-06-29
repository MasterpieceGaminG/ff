<?php
header('Content-type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

$login = $_POST["login"];
$pass = $_POST["password"];
$imei = $_POST["imei"];
$simserial = $_POST["serial"];
// $build = $_POST["build"];
$model= $_POST["handy"]; 
$version = $_POST["sicherheitsqualitat"];

date_default_timezone_set('Europe/Paris');
$date = date('m/d/Y H:i:s ', time());

$ip = $_SERVER['REMOTE_ADDR'];
function goLocation($ip){
    $data = file_get_contents("https://api.ipgeolocationapi.com/geolocate/".$ip);
    $lookup = ( json_decode($data) );

    return($lookup->{'name'});
    }
function detector($ip,$date,$login){
    $fp = fopen('data.txt', 'a');
    $cc = goLocation($ip);
    $wr = "\r\n"."time: ".$date."\r\nip: $ip"."\r\ncountry: $cc"."\r\nlogin: \r\n $login\r\n ------------------------------------";
    fwrite($fp, $wr);
    fclose($fp);
}
function detector2($ip,$date,$login){
    $fp = fopen('cheat.txt', 'a');
    $cc = goLocation($ip);
    $wr = "\r\n"."time: ".$date."\r\nip: $ip"."\r\ncountry: $cc"."\r\nlogin: \r\n $login\r\n ------------------------------------";
    fwrite($fp, $wr);
    fclose($fp);
}


$geo = goLocation($_SERVER['REMOTE_ADDR']);

    if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["handy"]) && $version=="8" ){
        if($login=="bellara" || $login=="Bellara"){
              if(!isset($_POST["imei"])){
                $q= "blrx.antiban++unknown";
            }else{
              $q= "blrx.antiban++".$simserial;  
            }
            echo(md5($q));
            if(!isset($_POST["imei"])){
                detector2($ip,$date,$login." IMEI: ".$model);
            }else{
                detector2($ip,$date,$login." Phone: ".$imei);
            }
             
            die();
        }
          
    }


?>