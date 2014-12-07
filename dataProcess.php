<?php

require('dataClass.php');

if (isset($_GET['c'])) {
    $country = $_GET['c'];
} else {
    return FALSE;
}

$data_handler = new Data();
$data_container = $data_handler->getCountryData($country);

foreach ($data_container as $theme_name => $theme_properties) {
    foreach ($theme_properties->column_names as $column_titles_key => $column_titles_value) {
        if ($column_titles_value === 'Value') {
            $theme_value_key = $column_titles_key;
        }
        if ($column_titles_value === 'Date') {
            $theme_date_key = $column_titles_key;
        }
    }
    foreach ($theme_properties->data as $data_property) {
        $date_value = strtotime($data_property[$theme_date_key]);
        $year_value = date('Y', $date_value);
        if ($data_property[$theme_value_key] < 0.00000001) {
            $country_data[$theme_name][$year_value] = NULL;
        } else if (2010 >= intval($year_value)) {
            $country_data[$theme_name][$year_value] = $data_property[$theme_value_key];
        }
    }
}

if ($country !== 'USA') {
    foreach ($country_data['military'] as $military_year => $military_value) {
        if (isset($country_data['exchange_usd'][$military_year])) {
            $country_data['military'][$military_year] = $military_value * $country_data['exchange_usd'][$military_year];
        } else {
            $country_data['military'][$military_year] = NULL;
        }
    }

    foreach ($country_data['gni'] as $gni_year => $gni_value) {
        if (isset($country_data['exchange_usd'][$gni_year])) {
            $country_data['gni'][$gni_year] = $gni_value * $country_data['exchange_usd'][$gni_year];
        } else {
            $country_data['gni'][$gni_year] = NULL;
        }
    }
}

foreach ($country_data['education'] as $education_year => $education_value) {
    if (isset($country_data['gni'][$education_year])) {
        $country_data['education'][$education_year] = $education_value * $country_data['gni'][$education_year];
    } else {
        $country_data['education'][$education_year] = NULL;
    }
}

foreach ($country_data['population'] as $population_year => $population_value) {
    $year_int = intval($population_year);
    $previous_year = (int) $year_int - 1;
    if (isset($country_data['population'][$previous_year])) {
        $country_data['population_growth'][$population_year] = $population_value - $country_data['population'][$previous_year];
    } else {
        $country_data['population_growth'][$population_year] = NULL;
    }
}

unset($country_data['population']);
unset($country_data['gni']);
unset($country_data['exchange_usd']);

foreach ($country_data as $country_theme_name => $country_theme_data) {
    foreach ($country_theme_data as $country_theme_year => $country_theme_year_value) {
        $finished_data[$country_theme_year][$country_theme_name] = $country_theme_year_value;
    }
}

unset($finished_data['1994']);

echo "<pre>";
var_dump($finished_data);
echo "</pre>";

?>
