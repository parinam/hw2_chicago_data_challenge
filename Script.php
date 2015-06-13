<?php
/**
 * Created by PhpStorm.
 * User: parina
 * Date: 6/13/15
 * Time: 2:02 PM
 */
include 'highBirthRate.php';

$birth_file = '/home/parina/Desktop/Homework2/Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv';
$low_weight_file = '/home/parina/Desktop/Homework2/Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv';

$test = new highBirthRate();
$test->parseTotalBirth1999Csv($birth_file);
$test->parseLowBirthWeight1999Csv($low_weight_file);
$high_birth_rate_1999 = $test->getHighBirth1999();
$total_births_1999 = $test->getParsedTotalBirth1999();
$low_weight_births_1999 = $test->getParsedLowBirthWeight1999();
$region = $test->getAreaIdInfo();
foreach($high_birth_rate_1999 as $area_id => $high_birth)
{
    echo "Region : $region[$area_id] \t Total Birth : $total_births_1999[$area_id] \t Low Births : $low_weight_births_1999[$area_id] \t High Births : $high_birth_rate_1999[$area_id]\n";
}


$test->parseTotalBirth2000Csv($birth_file);
$test->parseLowBirthWeight2000Csv($low_weight_file);
$high_birth_rate_2000 = $test->getHighBirth2000();
$total_births_2000 = $test->getParsedTotalBirth2000();
$low_weight_births_2000 = $test->getParsedLowBirthWeight2000();
echo "For the year 2000#######################################################\n";
foreach($high_birth_rate_2000 as $area_id => $high_birth)
{
       echo "Region : $region[$area_id] \t Total Birth : $total_births_2000[$area_id] \t Low Births : $low_weight_births_2000[$area_id] \t High Births : $high_birth_rate_2000[$area_id]\n";
}


