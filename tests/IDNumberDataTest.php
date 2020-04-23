<?php namespace SemicolonZA\ZaIdParser\Test;

use PHPUnit\Framework\TestCase;
use SemicolonZA\ZaIdValidator\IDNumberData;

class IDNumberDataTest extends TestCase
{
    public function testIDNumberDataModel()
    {
        $idNumber = '8808120685084';
        $age =  30;
        $birthdate = '1988-08-12';
        $gender = 'Female';
        $citizenship = 'South African';
        $isValid = TRUE;

        
        $idNumberData = new IDNumberData(
            $idNumber,
            $birthdate,
            $age,
            $gender,
            $citizenship,
            $isValid
        );

        $this->assertEquals($idNumberData->getIdNumber(), $idNumber);
    }
}