<?php

class Data
{

    public $themes = array('int_tourists', 'military_expense', 'co2_emissions', 'demographic_explosion', 'violent_death');
    public $countries = array('Argentina' => 'ARG', 'Brasil' => 'BRA', 'Canada' => 'CAN', 'Chile' => 'CHL', 'Colombia' => 'COL', 'USA' => 'USA', 'Mexico' => 'MEX', 'Venezuela' => 'VEN', 'Germany' => 'DEU', 'Austria' => 'AUT', 'Spain' => 'ESP', 'France' => 'FRA', 'Greece' => 'GRC', 'Iceland' => 'ISL', 'Russia' => 'RUS', 'UK' => 'GBR', 'Ukraine' => 'UKR', 'China' => 'CHN', 'Japan' => 'JPN', 'Thailand' => 'THA', 'India' => 'IND', 'Saudi Arabia' => 'SAU', 'Pakistan' => 'PAK', 'Israel' => 'ISR', 'South Africa' => 'ZAF', 'Nigeria' => 'NGA', 'Cameroon' => 'CMR'); 

    function __construct($country, $data_theme, $year)
    {
        require('accounts.php');
        require('lib/quandl/Quandl.php');

        if (!in_array($data_theme, $this->themes) OR !array_key_exists($country, $this->countries)) {
            return FALSE;
        }

        $quandle_call = new Quandl($quandl_api_token);
        $quandle_call->cache_handler = 'dataCache';
    }

    function dataCache($action, $url, $data=NULL)
    {
        $cache_key = md5("quandl:$url");
        $cache_file = __DIR__ . "/$cache_key";

        if ($action == "get" and file_exists($cache_file)) {
            return file_get_contents($cache_file);
        } else if ($action == "set") {
            file_put_contents($cache_file, $data);
        }

        return false;
    }

}
