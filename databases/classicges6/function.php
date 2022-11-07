<?php


function  send_query($query){
    
    $url = "https://my.rodapro.es/gestpv/api.php";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Content-Type: application/x-www-form-urlencoded",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = "sql=" . urlencode($query) . "&limit=50&path=C%3A%2Fclasges6activo%2Fdatos&token=ZOBKDEGIBKLAOXAVNPBJ";
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $resp = curl_exec($curl);
    curl_close($curl);
    $ret = json_decode($resp, true);
    $arr = json_decode($ret['message'], true);
    if(isset($arr['Table'])){
        return $arr['Table'];
    
    }else{
        return false;
    }
    }