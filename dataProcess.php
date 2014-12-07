<?php

require('dataClass.php');

$new_call = new Data();

echo "<pre>";
var_dump($new_call->getCountryData('Mexico'));
echo "</pre>";

?>
