<?php

header("Access-Control-Allow-Origin: *");

function error_handler() {
    http_response_code('500');
    echo "error";
}

if (isset($_GET['input']))
{
   set_error_handler('error_handler');
    
        date_default_timezone_set('America/Los_Angeles');    
         
        $csymbol = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET['input'] ;
        $contents = file_get_contents($csymbol);
        
        if($contents) {
            $json = json_decode($contents , true);

            $json['Change'] = round($json['Change'],2);
            $json['ChangePercent'] = round($json['ChangePercent'],2)."%";
            $json['Timestamp'] = date('d F Y, h:i:t A', strtotime($json['Timestamp']));
            $json['ChangePercentYTD'] = round($json['ChangePercentYTD'],2)."%";
            $json['ChangeYTD'] = round($json['ChangeYTD'],2);
            $json['High'] = round($json['High'],2);
            $json['Low'] = round($json['Low'],2);
            $json['Open'] = round($json['Change'],2);
           
         
            echo json_encode($json);
        } else {
            http_response_code('404');
             echo "error";
        }
}

if (isset($_GET['lookup']))
{
    $url ='http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input='.urlencode(str_replace(" ","+",$_GET['lookup']));
    set_error_handler('error_handler');
    
    
    $json = json_decode(file_get_contents($url),true);
    if ($json == null) {
        http_response_code('404');
        echo "error";
    } else {
        echo json_encode($json);
    }
}


if(isset($_GET['highstockip']))
{
    set_error_handler('error_handler');
    $url="http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters=%7b%22Normalized%22:false,%22NumberOfDays%22:1095,%22DataPeriod%22:%22Day%22,%22Elements%22:%5b%7b%22Symbol%22:%22".$_GET['highstockip']."%22,%22Type%22:%22price%22,%22Params%22:%5b%22ohlc%22%5d%7d%5d%7d";
    $highstock = file_get_contents($url);
    if($highstock) {
        echo($highstock);
    } else {
        http_response_code('404');
        echo "error";
    }
} 

?>