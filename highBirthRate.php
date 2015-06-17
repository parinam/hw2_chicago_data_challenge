<?php
/**
 * This file is under folder: https://github.com/parinam/hw2_chicago_data_challenge
 * File highBirthRate.php and highBirthRatelib.php should be under one directory
 * To run this code, go to the path where the file exists and type the command : php highBirthRate.php
 * Created by PhpStorm.
 * User: parina
 * Date: 6/13/15
 * Time: 2:02 PM
 */

/**
 * Includes highBirthRatelib.php file where all the methods have been defined
 * Takes csv birth_file and low_weight_file
 * Takes user input if the user wants the correlation data for year 1999 or 2000 and prints the result
 * Calls to the following method for year 1999 from highBirthRatelib.php file: setAreaIdInfo, parseTotalBirth1999Csv, parseLowBirthWeight1999Csv, getHighBirth1999, getAreaIdInfo
 * Calls to the following method for year 2000 from highBirthRatelib.php file: parseTotalBirth2000Csv, parseLowBirthWeight2000Csv, getHighBirth2000, getAreaIdInfo
 */
include 'highBirthRatelib.php';

$birth_file = 'Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv';
$low_weight_file = 'Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv';

echo "Please enter the year you would like to see the high birth rates of (1999 or 2000)\n";
$temp = fopen ("php://stdin","r");
$line = fgets($temp);
$line = str_replace(array("\n", "\r"), '', $line);
$test = new highBirthRate();
$test->setAreaIdInfo($low_weight_file);
if($line === '1999') {
    $total_births_99 = $test->parseTotalBirth1999Csv($birth_file);
    $total_low_weight_99 = $test->parseLowBirthWeight1999Csv($low_weight_file);
    $high_birth_rate_1999 = $test->getHighBirth1999($total_births_99, $total_low_weight_99);
    $region = $test->getAreaIdInfo();
    foreach ($high_birth_rate_1999 as $area_id => $high_birth) {
        echo "Region : $region[$area_id] \t\t\t\t Total Birth : $total_births_99[$area_id] \t Low Births : $total_low_weight_99[$area_id] \t High Births : $high_birth_rate_1999[$area_id]\n";
    }
}
elseif($line === '2000') {
    $total_births_2000 = $test->parseTotalBirth2000Csv($birth_file);
    $total_low_weight_2000 = $test->parseLowBirthWeight2000Csv($low_weight_file);
    $high_birth_rate_2000 = $test->getHighBirth2000($total_births_2000, $total_low_weight_2000);
    $region = $test->getAreaIdInfo();
    echo "For the year 2000\n";
    foreach ($high_birth_rate_2000 as $area_id => $high_birth) {
        echo "Region : $region[$area_id] \t\t Total Birth : $total_births_2000[$area_id] \t Low Births : $total_low_weight_2000[$area_id] \t High Births : $high_birth_rate_2000[$area_id]\n";
    }
}
else
{
    echo "You entered an invalid option. Please enter either 1999 or 2000\n";
    exit(0);
}


