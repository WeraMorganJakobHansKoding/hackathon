<?php

require('dataClass.php');

$data_object = new Data();
foreach ($data_object->countries as $country => $codes) {
    echo "<h1>" . $country . "</h1>";
    echo "<pre>";
    var_dump($data_object->getCountryData($country));
    echo "</pre>";
}
?>
