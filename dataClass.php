<?php

class Data
{

    public $themes = array('int_tourists', 'military_expense', 'co2_emissions', 'demographic_explosion', 'violent_death');
    public $countries = array('Argentina' => 'ARG', 'Brasil' => 'BRA', 'Canada' => 'CAN', 'Chile' => 'CHL', 'Colombia' => 'COL', 'USA' => 'USA', 'Mexico' => 'MEX', 'Venezuela' => 'VEN', 'Germany' => 'DEU', 'Austria' => 'AUT', 'Spain' => 'ESP', 'France' => 'FRA', 'Greece' => 'GRC', 'Iceland' => 'ISL', 'Russia' => 'RUS', 'UK' => 'GBR', 'Ukraine' => 'UKR', 'China' => 'CHN', 'Japan' => 'JPN', 'Thailand' => 'THA', 'India' => 'IND', 'Saudi Arabia' => 'SAU', 'Pakistan' => 'PAK', 'Israel' => 'ISR', 'South Africa' => 'ZAF', 'Nigeria' => 'NGA', 'Cameroon' => 'CMR'); 

    function __construct()
    {
        require('accounts.php');
        require('lib/quandl/Quandl.php');

        $this->quandl_call = new Quandl($quandl_api_token);
        $this->quandl_call->cache_handler = 'dataCache';
    }

    function testCall()
    {
        $test_data = $this->quandl_call->getSymbol('WORLDBANK/MEX_SP_POP_TOTL');

        return $test_data;
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
