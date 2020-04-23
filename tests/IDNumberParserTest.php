<?php namespace Talifhani\ZaIdParser\Test;

use PHPUnit\Framework\TestCase;
use Talifhani\ZaIdValidator\IDNumberData;

class IDNumberParserTest extends TestCase
{
    public function testIDNumberParser()
    {
        $idNumber = '8808120685084';
        $age =  30;
        $birthdate = '1988-08-12';
        $gender = 'Female';
        $citizenship = 'South African';
        $isValid = TRUE;

        $idNumberData = (new IDNumberParser($idNumber))->parse();

        $this->assertEquals($idNumberData->getIdNumber(), $idNumber);
    }
}