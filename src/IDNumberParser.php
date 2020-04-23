<?php namespace Talifhani\ZaIdParser;

/**
 * @author Tali Luvhengo <tali@semicolon.co.za>
 */
class IDNumberParser
{
    private $birthYearNum;
    private $birthMonthNum;
    private $birthDayNum;
    private $genderNum;
    private $citisenshipNum;
    private $raceIshNum;
    private $checkBit;

    private $matches;
    private $idNumber;

    public function __construct(string $idNumber)
    {
        $this->breakDownIDNumber($idNumber);
    }

    /**
     *
     * @param string $idNumber
     * @return void
     */
    private function breakDownIDNumber(string $idNumber)
    {
        if(strlen($idNumber) !== 13) {
            throw new \Exception("ID must be 13 digits long");
        }

        $matches = [];
        preg_match("!^(\d{2})(\d{2})(\d{2})(\d{4})(\d{1})(\d{1})(\d{1})$!", $idNumber, $matches);
        array_shift($matches);//remove idNum

        list(
            $this->birthYearNum,
            $this->birthMonthNum,
            $this->birthDayNum,
            $this->genderNum,
            $this->citisenshipNum,
            $this->raceIshNum,
            $this->checkBit,
            ) = $matches;

        $this->matches = $matches;
        $this->idNumber = $idNumber;
    }

    /**
     *
     * @param string $idNumber
     * @return IDNumberData
     */
    public function parse(): IDNumberData
    {
        $birthYear = $this->getBirthYearFromTwoDigitYear($this->birthYearNum);

        $dateTimeBirthdate = (new \DateTime())->setDate($birthYear, $this->birthMonthNum, $this->birthDayNum);
        
        return new IDNumberData(
            $this->idNumber,
            $dateTimeBirthdate->format('Y-m-d'),
            (new \DateTime)->diff($dateTimeBirthdate)->y,
            $this->genderNum >= 5000 ? 'Male' : 'Female',
            $this->citisenshipNum == 0 ? CitizenShipEnum::SOUTH_AFRICAN : ($this->citisenshipNum == 1 ? CitizenShipEnum::NON_SOUTH_AFRICAN : CitizenShipEnum::REFUGEE),
            $this->checkBit == $this->calculateCheckBit($this->idNumber)
        );
    }

    /**
     * @param string $idNumber
     * @return integer
     */
    private function calculateCheckBit(string $idNumber): int
    {
        $withoutChecksum = substr($idNumber, 0, -1);
		return (new Luhn)->generate($withoutChecksum);
    }

    /**
     *
     * @param string $twoDigitYear
     * @return integer
     */
    private function getBirthYearFromTwoDigitYear(string $twoDigitYear): int
    {
        $birthYear = '';
        $thisYear = (int) (new \DateTime)->format('Y');
        $hundredYearsAgo = $thisYear - 100;

        $thisCentury = (int) substr($thisYear, 0, 2);
        $previousCentury = $thisCentury - 1;
        $yearBasedOnPreviousCentury = (int) $previousCentury.$twoDigitYear;

        $birthYear = ($yearBasedOnPreviousCentury < $hundredYearsAgo)
            ? $thisCentury.$twoDigitYear
            : $previousCentury.$twoDigitYear;

        return $birthYear;
    }
}
