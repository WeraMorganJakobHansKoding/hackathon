<?php

require('dataClass.php');

echo "<pre>";
$data_object = new Data();
var_dump($data_object->getCountryData('Argentina'));
echo "</pre>";

?>
