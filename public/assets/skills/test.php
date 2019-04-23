<?php
$path = "./python.json";
$path = "c.json";
$j = file_get_contents($path);
//echo $j;
$json =  json_decode( file_get_contents($path), true );
//echo $json;
print_r($json);
?>
