<?php

/**
 * Created by PhpStorm.
 * User: parina
 * Date: 6/14/15
 * Time: 9:51 AM
 */
include '../highBirthRate.php';
class highBirthRateTest extends PHPUnit_Framework_TestCase
{
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

    public function testAreaInfo()
    {
        $file = "testData/setAreaInfo.csv";
        $test = new highBirthRate();
        $test->setAreaIDInfo($file);
        $result = $test->getAreaIdInfo();
        $this->assertEquals($result[1], "ROGERS PARK");
        $this->assertCount(1, $result);
    }

    public function testAreaInfoWithOnlyHeader()
    {
        $file = "testData/AreaHeaderInfo.csv";
        $test = new highBirthRate();
        $test->setAreaIDInfo($file);
        $result = $test->getAreaIdInfo();
        $this->assertEmpty($result);
    }

    public function testParseTotalBirthCsv()
    {
        $file = "testData/TotalBirth99.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth1999Csv($file);
        $this->assertEquals($result[100], 50534);
        $this->assertCount(1,$result);
    }

    public function testParseTotalBirth99NonChicagoArea() //testing the hack for not being chicago
    {
        $file = "testData/TotalBirth99NonChicagoArea.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth1999Csv($file);
        $this->assertCount(1,$result);
        $this->assertEquals($result[77], 873);
    }

    public function testParseLowBirthWeight99Csv()
    {
        $file = "testData/LowBirth99.csv";
        $test = new highBirthRate();
        $result = $test->parseLowBirthWeight1999Csv($file);
        $this->assertEquals($result[1], 103);
        $this->assertCount(1,$result);
    }

    public function testParseLowBirth99OnlyHeader()
    {
        $file = "testData/LowBirth99Header.csv";
        $test = new highBirthRate();
        $result = $test->parseLowBirthWeight1999Csv($file);
        $this->assertEmpty($result);
    }

    public function testParseTotalBirth2000Csv()
    {
        $file = "testData/TotalBirth2000.csv";
        $test = new highBirthRate();
        $result = $test->parseTotalBirth2000Csv($file);
        $this->assertEquals($result[100], 50534);
        $this->assertCount(1,$result);
    }
}