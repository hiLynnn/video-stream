<?php 

$ip = '103.102.56.82';
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
echo $details->city;

// PHP code to obtain country, city, 
// continent, etc using IP Address 

$ip = '103.102.56.82'; 

// Use JSON encoded string and converts 
// it into a PHP variable 
$ipdat = @json_decode(file_get_contents( 
  "http://www.geoplugin.net/json.gp?ip=" . $ip)); 

echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n"; 
echo 'City Name: ' . $ipdat->geoplugin_city . "\n"; 
echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n"; 
echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n"; 
echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n"; 
echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n"; 
echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n"; 
echo 'Timezone: ' . $ipdat->geoplugin_timezone; 

?> 
