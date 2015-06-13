<?php


$file_low_birth_weight = "/home/parina/Desktop/Homework2/Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv";
$file_birth_rate = "/home/parina/Desktop/Homework2/Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv";
$result_low_birth_weight = [];
$result_birth_rate = [];
$result_high_birth_weight = [];
$community_area = [];

/**Parse the 1st file*/
$file_handle = fopen($file_low_birth_weight, "r");
while(!feof($file_handle)){
  $line_of_text = fgetcsv($file_handle, 1024);
  $result_low_birth_weight[$line_of_text[0]] = $line_of_text[2]; //area id = low births for year 1999
 // $result_low_birth_weight[$line_of_text[0]] = $line_of_text[3];
  $community_area[$line_of_text[0]] = $line_of_text[1]; //area id = locality
}
fclose($file_handle);
print_r($result_low_birth_weight);

/**Parse the 2nd file*/

$file_handle = fopen($file_birth_rate, "r");
while(!feof($file_handle)){
  $line_of_text = fgetcsv($file_handle, 1024);
  if($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
    $result_birth_rate[100] = $line_of_text[2];
  } 
  else{
  $result_birth_rate[$line_of_text[0]] = $line_of_text[2]; //area id = max number of  births for year 1999
  }
}
fclose($file_handle);
//print_r($result_birth_rate);
/**Calculate the high birth weight rate for year 1999
   High birth weight rate = Total birth rate - low birth weight rate 
*/

foreach($result_low_birth_weight as $area_id => $low_birth_weight)
{
  $high = ($result_birth_rate[$area_id] - $result_low_birth_weight[$area_id]);
  //$result_high_rate[$area] = $high; 
  echo "Area: $community_area[$area_id]\t\t\t Birth_Rate: $result_birth_rate[$area_id]\t\t Low_Birth: $result_low_birth_weight[$area_id]\t\t High Rate: $high\n";
}

