<?php

/**
 * Created by PhpStorm.
 * User: parina
 * Date: 6/13/15
 * Time: 8:45 AM
 */
class highBirthRate
{
    var $result_total_birth = [];
    var $result_low_birth_weight = [];
    var $result_low_birth_weight1 = [];
    var $result_total_birth1 = [];

    /***
     * Method for the public health statistics file for births and birth rate
     * @param $file
     */
    public function parseBirthRateCsv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            /**This is a hack, because the id for chicago is 100 in the birth file and 0 in the low birth csv file */
            if ($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
                $result_total_birth[100] = $line_of_text[2];
            } else {
                $result_total_birth[$line_of_text[0]] = $line_of_text[2]; //area id = number of max births in year 1999
            }
        }
        fclose($file_handle);
    }

    private function checkFilePath($file)
    {
        try {
            file_exists($file);
        } catch (Exception $e) {
            echo "Error : $e->getMessage()\n";

        }

    }

    public function parseLowBirthWeightCsv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            $result_low_birth_weight[$line_of_text[0]] = $line_of_text[2]; //area id = number of low births in 1999
            $community_area[$line_of_text[0]] = $line_of_text[1]; //area id = Neighbourhood community name
        }
        fclose($file_handle);
    }

    public function parseLowBirthRate1csv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            $result_low_birth_weight1[$line_of_text[0]] = $line_of_text[3]; //area id = number of low births in 2000
            $community_area[$line_of_text[0]] = $line_of_text[1]; //area id = neighbourhood community name
        }
        fclose($file_handle);
    }

    public function parseBirthRate1Csv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            /**This is a hack, because the id for chicago is 100 in the birth file and 0 in the low birth csv file */
            if ($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
                $result_total_birth1[100] = $line_of_text[3];
            } else {
                $result_total_birth1[$line_of_text[0]] = $line_of_text[3]; //area id = number of max births in year 2000
            }
        }
        fclose($file_handle);
    }

    /**Calculate the high birth weight rate for the year 1999
     * High birth weight rate = Total birth rate - low birth weight rate
     */
    public function parseHighBirth($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file,"r");
        while (!feof($file_handle)){
        foreach ($result_low_birth_weight as $area_id => $low_birth_weight) {
            $high = ($result_birth_rate[$area_id] - $result_low_birth_weight[$area_id]);

        }}

    }
}