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
        $parameters = array(
            'trim_start' => '1990',
            'trim_end' => '2010'
        );

        $urls['population'] = 'WORLDBANK/' . $this->countries[$country][0] . '_SP_POP_TOTL';
        $urls['tourists'] = 'WORLDBANK/' . $this->countries[$country][0] . '_ST_INT_ARVL';
        $urls['military'] = 'WORLDBANK/' . $this->countries[$country][0] . '_MS_MIL_XPND_CN';
        $urls['co2'] = 'WORLDBANK/' . $this->countries[$country][0] . '_EN_ATM_CO2E_KT';
        $urls['coal_energy'] = 'WORLDBANK/' . $this->countries[$country][0] . '_EG_ELC_COAL_KH';
        $urls['forests'] = 'WORLDBANK/' . $this->countries[$country][0] . '_AG_LND_FRST_K2';
        $urls['education'] = 'WORLDBANK/' . $this->countries[$country][0] . '_NY_GNP_MKTP_CN';
        $urls['gni'] = 'WORLDBANK/' . $this->countries[$country][0] . '_NY_GNP_MKTP_CN';

        var_dump($urls);

        $country_data['population'] = $this->quandl_call->getSymbol($urls['population'], $parameters);
        $country_data['tourists'] = $this->quandl_call->getSymbol($urls['tourists'], $parameters);
        $country_data['military'] = $this->quandl_call->getSymbol($urls['military'], $parameters);
        $country_data['co2'] = $this->quandl_call->getSymbol($urls['co2'], $parameters);
        $country_data['coal_energy'] = $this->quandl_call->getSymbol($urls['coal_energy'], $parameters);
        $country_data['forests'] = $this->quandl_call->getSymbol($urls['forests'], $parameters);
        $country_data['education'] = $this->quandl_call->getSymbol($urls['education'], $parameters);
        $country_data['gni'] = $this->quandl_call->getSymbol($urls['gni'], $parameters);

        if ($country !== 'USA') {
            $country_data['exchange_usd'] = $this->quandl_call->getSymbol('CURRFX/USD' . $this->countries[$country][1], $parameters);
        }

        if ($this->quandl_call->error) {
            echo $this->quandl_call->error . " - " . $this->quandl_call->last_url;
        }

        return $country_data;
    }

    // Cache handling to save on calls to API
    function dataCache($action, $url, $data=NULL)
    {
        $cache_key = md5("quandl:$url");
        $cache_file = "/$cache_key";

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
