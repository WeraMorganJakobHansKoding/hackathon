<?php
/*
error_reporting(-1);
ini_set('display_errors', 1);
 */

require('dataClass.php');
require('lib/smarty/libs/Smarty.class.php');

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

foreach ($country_data['forests'] as $forests_year => $forests_value) {
    $year_int = intval($forests_year);
    $previous_year = (string) $year_int - 1;
    if (isset($country_data['forests'][$previous_year])) {
        $country_data['forests_growth'][$forests_year] = $forests_value - $country_data['forests'][$previous_year];
    } else {
        $country_data['forests_growth'][$forests_year] = NULL;
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
    $previous_year = (string) $year_int - 1;
    if (isset($country_data['population'][$previous_year])) {
        $country_data['population_growth'][$population_year] = $population_value - $country_data['population'][$previous_year];
    } else {
        $country_data['population_growth'][$population_year] = NULL;
    }
}

unset($country_data['population']);
unset($country_data['forests']);
unset($country_data['exchange_usd']);

foreach ($country_data as $country_theme_name => $country_theme_data) {
    foreach ($country_theme_data as $country_theme_year => $country_theme_year_value) {
        $finished_data[$country_theme_year][$country_theme_name]['value'] = $country_theme_year_value;
        switch($country_theme_name) {
        case 'military':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'Military expenditure';
            break;
        case 'population_growth':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'Population explosion';
            break;
        case 'forests_growth':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'Forests area';
            break;
        case 'tourists':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'International tourism';
            break;
        case 'co2':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'CO2 Emissions';
            break;
        case 'coal_energy':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'Energy from coal';
            break;
        case 'education':
            $finished_data[$country_theme_year][$country_theme_name]['title'] = 'Education expenditure';
            break;
        }
    }
}

unset($finished_data['1994']);


$content_template = new Smarty();

$content_template->assign('data', $finished_data);
$content_html = $content_template->fetch('tiles.tpl');

//echo $content_html;

echo "<pre>";
var_dump($finished_data);
echo "</pre>";

?>
