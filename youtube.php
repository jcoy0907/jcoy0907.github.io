<?php
/*
Made by [egy.js](https://www.instagram.com/egy.js/);
*/
header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json');

function YT_IN_DX($url){
    $cookie_file_path = "cookies.txt";
    $agent            = "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:43.0) Gecko/20100101 Firefox/46.0";
    $ch               = curl_init();
    $headers[]        = "Connection: Keep-Alive";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}
function YT_V_INFO($v){
    $url         = "https://www.youtube.com/get_video_info?video_id=$v";
    $html        = urldecode(YT_IN_DX($url));
    $video_links = Explode_Content('playabilityStatus', 'adSafetyReason', $html);
    $json        = str_replace("\u0026", "&", $video_links);
    $json        = '{"playabilityStatus' . $json . 'adSafetyReason":{"isEmbed":true}}';
    $array       = json_decode($json, true);
    if (isset($array["playabilityStatus"]["status"]) && $array["playabilityStatus"]["status"] == "UNPLAYABLE") {
        $data = array("error" => $array["playabilityStatus"]["status"]);
    }else{
        $formats = $array["streamingData"]["formats"];
        for ($a = 0; $a <= (count($formats) - 1); $a++){
            $data[] = array(
                "url" => $array["streamingData"]["formats"][$a]["url"],
                "mimeType" => $array["streamingData"]["formats"][$a]["mimeType"],
                "quality" => $array["streamingData"]["formats"][$a]["quality"],
                "qualityLabel" => $array["streamingData"]["formats"][$a]["qualityLabel"],
                "width" => $array["streamingData"]["formats"][$a]["width"],
                "height" => $array["streamingData"]["formats"][$a]["height"],
                "audioQuality" => $array["streamingData"]["formats"][$a]["audioQuality"],
                "approxDurationMs" => $array["streamingData"]["formats"][0]["approxDurationMs"]
            );
        }
    }
    return $data;
}
function Explode_Content($first, $last, $string)
{
    $exp = explode($first, $string);
    $exp = explode($last, $exp[1]);
    return $exp[0];
}

if(isset($_GET['url']) && $_GET['url'] != ""){
    parse_str( parse_url( $_GET['url'], PHP_URL_QUERY ), $vars );

    
    $id=$vars['v'];
 
    echo json_encode(YT_V_INFO($id),JSON_PRETTY_PRINT);

}else{
    @$myObj->error = true;
    $myObj->msg = "there is no youtube link";
    
    $myObj->madeBy = "El-zahaby";
    $myObj->instagram = "egy.js";
    $myJSON = json_encode($myObj,JSON_PRETTY_PRINT);

    echo $myJSON;

}