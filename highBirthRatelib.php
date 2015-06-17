<?php

/**
 * highBirthRatelib.php file has all the methods for running the code and these methods have been called in highBirthRate.php file
 * highBirthRatelib.php and highBirthRate.php should be under one directory
 * Created by PhpStorm.
 * User: parina
 * Date: 6/13/15
 * Time: 8:45 AM
 */
class highBirthRate
{
    /**
     * Variable are defined as arrays
     * @var array
     */
    var $result_total_birth1999 = [];
    var $result_low_birth_weight1999 = [];
    var $result_low_birth_weight2000 = [];
    var $result_total_birth2000 = [];
    var $community_area = [];

    /**
     * Check File Path method is being called
     * File that is being parsed is: "https://data.cityofchicago.org/Health-Human-Services/Public-Health-Statistics-Births-and-birth-rates-in/4arr-givg"
     * Method for the public health statistics file for births and birth rate for the year 1999 which gives total birth and birth rate for each community area in Chicago
     * returns array of total birth for each community area in Chicago
     * @param $file
     * @return array
     */
    public function parseTotalBirth1999Csv($file)
    {
        try {
            $this->checkFilePath($file);
        }
        catch(Exception $e)
        {
            echo $e->getMessage() . ":\t $file\n"; exit(0);
        }
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            if($line_of_text[0] === 'Community Area'){
                continue;
            }
            /**This is a hack, because the id for chicago is 100 in the birth file and 0 in the low birth csv file */
            elseif ($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
                $this->result_total_birth1999[100] = $line_of_text[2];
            } else {
                $this->result_total_birth1999[$line_of_text[0]] = $line_of_text[2]; //area id = number of max births in year 1999
            }
        }
        fclose($file_handle);
        unset($this->result_total_birth1999['']);
        return $this->result_total_birth1999;
    }

    /**
     * Maps community area id with community area name
     * @return array
     */
    public function getAreaIdInfo()
    {
        return $this->community_area;
    }

    /**
     * Checking if the file exists and making it accessible for testing
     * @param $file
     * @throws Exception
     */
    public function checkFilePath($file)
    {
        if(!file_exists($file))
        {
            throw new Exception("Invalid file");
        }
    }

    /**
     * Check File Path method is being called
     * File that is being parsed is: "https://data.cityofchicago.org/Health-Human-Services/Public-Health-Statistics-Low-birth-weight-in-Chica/fbxr-9u99"
     * Method for the public health statistics file for Low birth weight in Chicago for the year 1999 which gives low weight birth rate for each community area in Chicago
     * returns array of low weight birth rate for each community area in Chicago
     * @param $file
     * @return array
     */
    public function parseLowBirthWeight1999Csv($file)
    {
        try {
            $this->checkFilePath($file);
        }
        catch(Exception $e)
        {
            echo $e->getMessage() . ":\t $file\n"; exit(0);
        }
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            if($line_of_text[0] === 'Community Area'){
                continue;
            }
            $this->result_low_birth_weight1999[$line_of_text[0]] = $line_of_text[2]; //area id = number of low births in 1999
        }
        fclose($file_handle);
        unset($this->result_low_birth_weight1999['']);
        return $this->result_low_birth_weight1999;
    }

    /**
     * Maps community area id with community area name
     * @param $file
     */
    public function setAreaIDInfo($file)
    {
        try {
            $this->checkFilePath($file);
        }
        catch(Exception $e)
        {
            echo $e->getMessage() . ":\t $file\n"; exit(0);
        }
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            if($line_of_text[0] === 'Community Area'){
                continue;
            }
            $this->community_area[$line_of_text[0]] = $line_of_text[1];
        }
        unset($this->community_area['']);
    }

    /**
     * Calculates correlation of 'High Birth weight rate' from [$total_births (which is birth and birth rate for year 1999) - $low_birth_wight (which is low birth weight rate for year 1999)] for each community area
     * @param $total_births
     * @param $low_birth_weight
     * @return array
     */
    public function getHighBirth1999($total_births, $low_birth_weight)
    {
        $high_weight_birth_rate = [];
        foreach ( $low_birth_weight as $area_id => $low_birth) {
            $high_weight_birth_rate[$area_id] = ($total_births[$area_id] - $low_birth_weight[$area_id]);
        }
        return $high_weight_birth_rate;
    }

    /**
     * Check File Path method is being called
     * File that is being parsed is: "https://data.cityofchicago.org/Health-Human-Services/Public-Health-Statistics-Births-and-birth-rates-in/4arr-givg"
     * Method for the public health statistics file for births and birth rate for the year 2000 which gives total birth and birth rate for each community area in Chicago
     * returns array of total birth for each community area in Chicago
     * @param $file
     * @return array
     */

    public function parseTotalBirth2000Csv($file)
    {
        try {
            $this->checkFilePath($file);
        }
        catch(Exception $e)
        {
            echo $e->getMessage() . ":\t $file\n"; exit(0);
        }
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            if($line_of_text[0] === 'Community Area'){
                continue;
            }
            /**This is a hack, because the id for chicago is 100 in the birth file and 0 in the low birth csv file */
            elseif ($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
                $this->result_total_birth2000[100] = $line_of_text[6];
            } else {
                $this->result_total_birth2000[$line_of_text[0]] = $line_of_text[6]; //area id = number of max births in year 2000
            }
        }
        fclose($file_handle);
        unset($this->result_total_birth2000['']);
        return $this->result_total_birth2000;
    }

    /**
     * Check File Path method is being called
     * File that is being parsed is: "https://data.cityofchicago.org/Health-Human-Services/Public-Health-Statistics-Low-birth-weight-in-Chica/fbxr-9u99"
     * Method for the public health statistics file for Low birth weight in Chicago for the year 2000 which gives low weight birth rate for each community area in Chicago
     * returns array of low weight birth rate for each community area in Chicago
     * @param $file
     * @return array
     */

    public function parseLowBirthWeight2000Csv($file)
    {
        try {
            $this->checkFilePath($file);
        }
        catch(Exception $e)
        {
            echo $e->getMessage() . ":\t $file\n"; exit(0);
        }
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            if($line_of_text[0] === 'Community Area'){
                continue;
            }
            $this->result_low_birth_weight2000[$line_of_text[0]] = $line_of_text[6]; //area id = number of low births in 2000
        }
        fclose($file_handle);
        unset($this->result_low_birth_weight2000['']);
        return $this->result_low_birth_weight2000;
    }

    /**
     * Calculates the correlation of 'High Birth weight rate' from [$total_births (which is birth and birth rate for year 2000) - $low_birth_wight (which is low birth weight rate for year 2000)] for each community area
     * @param $total_births
     * @param $low_birth_weight
     * @return array
     */

    public function getHighBirth2000($total_births, $low_birth_weight)
    {
        $high_weight_birth_rate = [];
        foreach ( $low_birth_weight as $area_id => $low_birth) {
            $high_weight_birth_rate[$area_id] = ($total_births[$area_id] - $low_birth_weight[$area_id]);
        }
        return $high_weight_birth_rate;
    }

}