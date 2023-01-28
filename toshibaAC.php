<?php
/* script pour lire la temperature sur Climatiseur AC Toshiba avec Wifi intégré.
 Copyright (C) 2023 - Nash
 Basé sur le travail de h4de5 : https://gist.github.com/h4de5/7f97db0f4efc265e48904d4a84dab4fb
 
 Il faut créer deux capteurs HTTP sur Eedomus.
 Url d'appel http://192.168.1.200/script/?exec=toshibaAC.php&consumerId=[VAR1]&token=[VAR2]
 VAR1 : consumerId
 VAR2 : Token de connexion
 
 
L'API thosiba donne cette information : 
'ACStateData' => '31431641316402101603fe0b000010ff000000',

Les valeurs en HEXA correspondent à ces informations : 
    _operationStatus = "ff";
    _mode = "ff";
    _temp = "ff";
    _fanSpeed = "ff";
    _airSwing = "ff";
    _powerSelection = "ff";
    _meritFeature = "ff";
    _pure = "ff";
    _indoorTemp = "ff";
    _outdoorTemp = "ff";
    _errorCode = "ff";
    _timerType = "ff";
    _relativeHours = "ff";
    _relativeMins = "ff";
    _selfCleaning = "ff";
    _ledStatus = "ff";
    _schedulerStatus = "ff";
    _utcHours = "ff";
    _utcMins = "ff";
    
*/

$consumerId=getArg('consumerId');
$token=getArg('token');
$headers = array('Authorization: Bearer '.$token);	

// new url since 2022-07-14
$api_url='https://mobileapi.toshibahomeaccontrols.com/api/AC/GetConsumerACMapping?consumerId='.$consumerId;
//echo $api_url;

$reponse = httpQuery($api_url, 'GET',  $post = NULL, $oauth_token = NULL, $headers);
$json = sdk_json_decode($reponse);

$ACStateData=str_split($json['ResObj'][0]["ACList"][0]["ACStateData"],2);
$xml="<root><indoortemp>".hexdec($ACStateData[8])."</indoortemp><outdoortemp>".hexdec($ACStateData[9])."</outdoortemp></root>";
sdk_header('text/xml');
echo $xml;


//var_dump($reponse);
	
?>
