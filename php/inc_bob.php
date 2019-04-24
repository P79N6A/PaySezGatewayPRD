<?php
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

//print_r(geoip_record_by_name(get_client_ip()));
$region = geoip_record_by_name(get_client_ip());
//$region = geoip_region_by_name('php.net');
$timezone = geoip_time_zone_by_country_and_region($region['country_code'], $region['region']);
var_dump($timezone);
/*

$timezones = array();

foreach (range('A', 'Z') as $i) {
    foreach (range('A', 'Z') as $j) {
        $country = $i . $j;

        foreach (range('A', 'Z') as $k) {
            foreach (range('A', 'Z') as $l) {
                $region = $k . $l;

                if ($timezone = geoip_time_zone_by_country_and_region($country, $region)) {
                    $timezones[$country][$timezone] = true;
                }
            }
        }

        foreach (range(0, 99) as $m) {
            if ($timezone = geoip_time_zone_by_country_and_region($country, sprintf('%02d', $m))) {
                $timezones[$country][$timezone] = true;
            }
        }
    }
}

var_dump($timezones);
?>