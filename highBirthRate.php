<?php

/**
 * Created by PhpStorm.
 * User: parina
 * Date: 6/13/15
 * Time: 8:45 AM
 */
class highBirthRate
{
    var $result_total_birth1999 = [];
    var $result_low_birth_weight1999 = [];
    var $result_low_birth_weight2000 = [];
    var $result_total_birth2000 = [];
    var $community_area = [];
    /***
     * Method for the public health statistics file for births and birth rate for the year 1999
     * @param $file
     */
    public function parseTotalBirth1999Csv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            /**This is a hack, because the id for chicago is 100 in the birth file and 0 in the low birth csv file */
            if ($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
                $this->result_total_birth1999[100] = $line_of_text[2];
            } else {
                $this->result_total_birth1999[$line_of_text[0]] = $line_of_text[2]; //area id = number of max births in year 1999
            }
        }
        fclose($file_handle);
    }

    public function getParsedTotalBirth1999()
    {
        return $this->result_total_birth1999;
    }

    public function getParsedLowBirthWeight1999()
    {
        return $this->result_low_birth_weight1999;
    }

    public function getAreaIdInfo()
    {
        return $this->community_area;
    }

    private function checkFilePath($file)
    {
        if(!file_exists($file))
        {
            echo "Please provide correct file path. $file is not a valid file\n";
            exit(0);
        }
    }

    public function parseLowBirthWeight1999Csv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            $this->result_low_birth_weight1999[$line_of_text[0]] = $line_of_text[2]; //area id = number of low births in 1999
            $this->community_area[$line_of_text[0]] = $line_of_text[1]; //area id = Neighbourhood community name
        }
        fclose($file_handle);
    }

    /**Calculate the high birth weight rate for the year 1999
     * High birth weight rate = Total birth rate - low birth weight rate
     */
    public function getHighBirth1999()
    {
        $total_births = $this->getParsedTotalBirth1999();
        $low_birth_weight = $this->getParsedLowBirthWeight1999();
        $high_weight_birth_rate = [];
        foreach ( $low_birth_weight as $area_id => $low_birth) {
            $high_weight_birth_rate[$area_id] = ($total_births[$area_id] - $low_birth_weight[$area_id]);
        }
        return $high_weight_birth_rate;
    }

    /***
     * Method for the public health statistics file for births and birth rate for the year 2000
     * @param $file
     */


    public function parseTotalBirth2000Csv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            /**This is a hack, because the id for chicago is 100 in the birth file and 0 in the low birth csv file */
            if ($line_of_text[1] === "Chicago") { //hack for chicago, since id is different
                $this->result_total_birth2000[100] = $line_of_text[6];
            } else {
                $this->result_total_birth2000[$line_of_text[0]] = $line_of_text[6]; //area id = number of max births in year 2000
            }
        }
        fclose($file_handle);
    }

    public function getParsedTotalBirth2000()
    {
        return $this->result_total_birth2000;
    }

    public function getParsedLowBirthWeight2000()
    {
        return $this->result_low_birth_weight2000;
    }

    public function parseLowBirthWeight2000Csv($file)
    {
        $this->checkFilePath($file);
        $file_handle = fopen($file, "r");
        while (!feof($file_handle)) {
            $line_of_text = fgetcsv($file_handle, 1024);
            $this->result_low_birth_weight2000[$line_of_text[0]] = $line_of_text[6]; //area id = number of low births in 2000
            //$this->community_area[$line_of_text[0]] = $line_of_text[6]; //area id = Neighbourhood community name
        }
        fclose($file_handle);
    }

    /**Calculate the high birth weight rate for the year 2000
     * High birth weight rate = Total birth rate - low birth weight rate
     */
    public function getHighBirth2000()
    {
        $total_births = $this->getParsedTotalBirth2000();
        $low_birth_weight = $this->getParsedLowBirthWeight2000();
        $high_weight_birth_rate = [];
        foreach ( $low_birth_weight as $area_id => $low_birth) {
            $high_weight_birth_rate[$area_id] = ($total_births[$area_id] - $low_birth_weight[$area_id]);
        }
        return $high_weight_birth_rate;
    }

    public function percent($high1999, $result_total_birth2000) {
        $count1 = $high1999 / $result_total_birth2000;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        echo $count;
    }

}