<?php

/**
 * Created by PhpStorm.
 * User: parina
 * Date: 6/14/15
 * Time: 9:51 AM
 * highBirthRateTest.php is under directory : https://github.com/parinam/hw2_chicago_data_challenge/tree/master/tests
 * All the test data for the unit test cases is under directory: https://github.com/parinam/hw2_chicago_data_challenge/tree/master/tests/testData
 * To run unit test cases, install phpunit
 * To run individual tests, run the following command : For example- phpunit --filter testParseTotalBirth99 highBirthRateTest.php, that is phpunit --filter [name of the method] [File Name]
 * To run all tests in one go, run the following command:  phpunit highBirthRateTest.php [These tests run in 26 ms]
 */
include '../highBirthRatelib.php';
class highBirthRateTest extends PHPUnit_Framework_TestCase
{
    // This unit test case checks if the file path exists if not it will throw an exception
    public function testForInvalidFile()
    {
        $file = "/home/parina/test.xsl";
        $test = new highBirthRate();
        try {
            $result = $test->checkFilePath($file);
        }
        catch (Exception $e){
            $this->assertEquals("Invalid file", $e->getMessage());
        }
    }

    // This unit test case checks if no file path is given
    public function testNoFileProvided()
    {
        $file = '';
        $test = new highBirthRate();
        try{
            $result = $test->checkFilePath($file);
        }
        catch (Exception $e){
            $this->assertEquals("Invalid file", $e->getMessage());
        }
    }
/**
 * Unit Test for setAreaIDInfo which takes first entry from Low birth weight csv and is copied in test data file setAreaInfo.csv .
 * To copy the first two line of Low birth weight csv into the file setAreaInfo.csv, run following command:
 * cat ../../Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv | head -2 > setAreaInfo.csv
 * If I change the assertEquals($result[2], "ROGERS PARK"); will fail as 'community area id' for "ROGERS PARK" is '1'.
 */

    public function testAreaInfo()
    {
        $file = "testData/setAreaInfo.csv";
        $test = new highBirthRate();
        $test->setAreaIDInfo($file);
        $result = $test->getAreaIdInfo();
        $this->assertEquals($result[1], "ROGERS PARK");
        $this->assertCount(1, $result);
    }
    /**
     * This unit test case checks for Only header of any of the csv file
     * To copy the header of Low birth weight csv into the file AreaHeaderInfo.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv | head -1 > AreaHeaderInfo.csv
     * Result in empty as the test data only contains the header and no values.
     */

    public function testAreaInfoWithOnlyHeader()
    {
        $file = "testData/AreaHeaderInfo.csv";
        $test = new highBirthRate();
        $test->setAreaIDInfo($file);
        $result = $test->getAreaIdInfo();
        $this->assertEmpty($result);
    }

    /**
     * This unit test case checks for Birth and Birth Rate csv [year 1999] for 'Chicago' community area which consists of total birth.
     * To copy the header of Birth and Birth Rate csv into the file TotalBirth99.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv  | head -2 > TotalBirth99.csv
     * Method parseTotalBirth1999csv has the logic that 'community area id' ='0' set to 'community area id' ='100' because in 'low birth weight csv' file 'Chicago' has 'community area id' ='100' and the value of 'community area id' in 'birth and birth rate csv' file has '0'
     * If I change the assertEquals($result[99], 50534), it will throw an error as community area id ='100' has value 50534
     */

    public function testParseTotalBirthCsv()
    {
        $file = "testData/TotalBirth99.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth1999Csv($file);
        $this->assertEquals($result[100], 50534);
        $this->assertCount(1,$result);
    }

    /**
     * This unit test case checks for only areas under 'Chicago' [year 1999] and not community area id ='100' which is Total Birth of Chicago
     * To copy the last entry 'Birth and Birth Rate csv' into the file TotalBirth99NonChicagoArea.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv  | tail -1 >> TotalBirth99NonChicagoArea.csv
     * If I change the value of assertEquals($result[77],870), this will throw an error.
     */

    public function testParseTotalBirth99NotChicago()
    {
        $file = "testData/TotalBirth99NonChicagoArea.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth1999Csv($file);
        $this->assertCount(1,$result);
        $this->assertEquals($result[77], 873);
    }

    /**
     *This unit test case checks for Low Birth Weight Rate csv [year 1999] for 'ROGERS PARK' with the value for year 1999 as '103'.
     * To copy first two entry of Low birth weight Rate csv into the file LowBirth99.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv | head -2 > LowBirth99.csv
     */

    public function testParseLowBirthWeight99Csv()
    {
        $file = "testData/LowBirth99.csv";
        $test = new highBirthRate();
        $result = $test->parseLowBirthWeight1999Csv($file);
        $this->assertEquals($result[1], 103);
        $this->assertCount(1,$result);
    }

    /**
     * This unit test case checks for Only header of Low Birth Weight Rate csv for year 1999
     * To copy the header of Low birth weight csv into the file LowBirth99Header.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv | head -1 > LowBirth99Header.csv
     * Result is empty as the test data only contains the header and no values.
     */

    public function testParseLowBirth99OnlyHeader()
    {
        $file = "testData/LowBirth99Header.csv";
        $test = new highBirthRate();
        $result = $test->parseLowBirthWeight1999Csv($file);
        $this->assertEmpty($result);
    }

    /**
     * This unit test case checks for Birth and Birth Rate csv [year 2000] for 'Chicago' community area which consists of total birth.
     * To copy the header of Birth and Birth Rate csv into the file TotalBirth2000.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv  | head -2 > TotalBirth2000.csv
     * Method parseTotalBirth2000csv has the logic that 'community area id' ='0' set to 'community area id' ='100' because in 'low birth weight csv' file 'Chicago' has 'community area id' ='100' and the value of 'community area id' in 'birth and birth rate csv' file has '0'
     * If I change the assertEquals($result[99], 50534), it will throw an error as community area id ='100' has value 50876
     */

    public function testParseTotalBirth2000Csv()
    {
        $file = "testData/TotalBirth2000.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth2000Csv($file);
        $this->assertEquals($result[100], 50876);
        $this->assertCount(1,$result);
    }

    /**
     * This unit test case checks for only areas under 'Chicago' [year 2000] and not community area id ='100' which is Total Birth of Chicago
     * To copy the last entry 'Birth and Birth Rate csv' into the file TotalBirth2000NotChicago.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Births_and_birth_rates_in_Chicago__by_year__1999___2009.csv  | tail -1 >> TotalBirth2000NonChicagoArea.csv
     * If I change the value of assertEquals($result[77],870), this will throw an error.
     */

    public function testParseTotalBirth2000NotChicago()
    {
        $file = "testData/TotalBirth2000NonChicagoArea.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth2000Csv($file);
        $this->assertCount(1,$result);
        $this->assertEquals($result[77], 875);
    }


    /**
     *This unit test case checks for Low Birth Weight Rate csv [year 2000] for 'ROGERS PARK' with the value for year 2000 as '114'.
     * To copy first two entry of Low birth weight Rate csv into the file LowBirth2000.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv | head -2 > LowBirth2000.csv
     */

    public function testParseLowBirthWeight2000Csv()
    {
        $file = "testData/LowBirth2000.csv";
        $test = new highBirthRate();
        $result = $test->parseLowBirthWeight2000Csv($file);
        $this->assertEquals($result[1], 114);
        $this->assertCount(1,$result);
    }

    /**
     * This unit test case checks for Only header of Low Birth Weight Rate csv for year 2000
     * To copy the header of Low birth weight csv into the file LowBirth99Header.csv, run following command:
     * cat ../../Public_Health_Statistics_-_Low_birth_weight_in_Chicago__by_year__1999___2009.csv | head -1 > LowBirth2000Header.csv
     * Result is empty as the test data only contains the header and no values.
     */

    public function testParseLowBirth2000OnlyHeader()
    {
        $file = "testData/LowBirth2000Header.csv";
        $test = new highBirthRate();
        $result = $test->parseLowBirthWeight2000Csv($file);
        $this->assertEmpty($result);
    }

    /**
     * This unit test case checks the calculation done for high birth for year 1999 and 2000
     * Formula used [Total births - low birth weight]
     */
    public function testHighBirthWeight()
    {
        $test = new highBirthRate();
        $total_births[1] = 100;
        $low_birth_weight[1] = 90;
        $result = $test->getHighBirth1999($total_births, $low_birth_weight);
        $result = $test->getHighBirth2000($total_births,$low_birth_weight);
        $this->assertEquals($result[1],10);

        $this->assertCount(1,$result);
    }

}