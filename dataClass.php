<?php

class Data
{

    public $themes = array('int_tourists', 'military_expense', 'co2_emissions', 'demographic_explosion', 'violent_death');
    public $countries = array(
        'Argentina' => array('ARG', 'ARS'),
        'Brasil' => array('BRA', 'BRL'),
        'Canada' => array('CAN', 'CAD'), 
        'Chile' => array('CHL', 'CLP'), 
        'Colombia' => array('COL', 'COP'), 
        'USA' => array('USA', 'USD'),
        'Mexico' => array('MEX', 'MXN'),
        'Venezuela' => array('VEN', 'VEF'),
        'Germany' => array('DEU', 'EUR'),
        'Austria' => array('AUT', 'EUR'),
        'Spain' => array('ESP', 'EUR'),
        'France' => array('FRA', 'EUR'),
        'Greece' => array('GRC', 'EUR'),
        'Iceland' => array('ISL', 'ISK'),
        'Russia' => array('RUS', 'RUB'),
        'UK' => array('GBR', 'GBP'),
        'Ukraine' => array('UKR', 'UAH'),
        'China' => array('CHN', 'CNY'),
        'Japan' => array('JPN', 'JPY'),
        'Thailand' => array('THA', 'THB'),
        'India' => array('IND', 'INR'),
        'Saudi Arabia' => array('SAU', 'SAR'),
        'Pakistan' => array('PAK', 'PKR'),
        'Israel' => array('ISR', 'ILS'),
        'South Africa' => array('ZAF', 'ZAR'),
        'Nigeria' => array('NGA', 'NGN'), 
        'Cameroon' => array('CMR', 'XAF')
    ); 

    function __construct()
    {
        require('accounts.php');
        require('lib/quandl/Quandl.php');

        $this->quandl_call = new Quandl($quandl_api_token);
        $this->quandl_call->cache_handler = 'dataCache';
    }

    function getCountryData($country)
    {
        $country_symbols = array(
            'WORLDBANK/' . $this->countries[$country] . '_SP_POP_TOTAL',        // Population
            'WORLDBANK/' . $this->countries[$country] . '_ST_INT_ARVL',         // Int Tourists Arrival
            'WORLDBANK/' . $this->countries[$country] . '_MS_MIL_XPND_CN',      // Military expenditure
            'WORLDBANK/' . $this->countries[$country] . '_EN_ATM_CO2E_KT',      // CO2 Emissions
            'WORLDBANK/' . $this->countries[$country] . '_EG_ELC_COAL_KH',      // kWh Energy from coal 
            'WORLDBANK/' . $this->countries[$country] . '_AG_LND_FRST_K2',      // km2 Forest area
            'WORLDBANK/' . $this->countries[$country] . '_SE_XPD_TOTL_GN_ZS',   // Education Expenditure
            'WORLDBANK/' . $this->countries[$country] . '_NY_GNP_MKTP_CN',      // GNI in local currency 
        );
    }

    // Cache handling to save on calls to API
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

    function testCall()
    {
        $test_data = $this->quandl_call->getSymbol('WORLDBANK/MEX_SP_POP_TOTL');

        return $test_data;
    }

}
