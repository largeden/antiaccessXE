<?php

// This code demonstrates how to lookup the country by IP Address

include("geoip.inc");

// Uncomment if querying against GeoIP/Lite City.
// include("geoipcity.inc");

$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);

echo geoip_country_code_by_addr($gi, "164.124.101.2") . "<br />" .
     geoip_country_name_by_addr($gi, "164.124.101.2") . "";

geoip_close($gi);

?>
