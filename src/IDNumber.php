<?php namespace SemicolonZA\ZaIdValidator;

/**
 * @author Tali Luvhengo <tali@semicolon.co.za>
 */
class IDNumber
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
    public function getIDNumberData(): IDNumberData
    {
        $birthYear = $this->getBirthYearFromTwoDigitYear($this->birthYearNum);

        $dateTimeBirthdate = (new \DateTime())->setDate($birthYear, $this->birthMonthNum, $this->birthDayNum);

        return new IDNumberData(
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
        $evensum = 0;
        $oddsum = 0;

        $oddString = substr(preg_replace('/(.)./', '$1', $idNumber), 0, -1); //Extract Odd characters exclude last one
        $oddsum = array_sum(str_split($oddString)); //Sum each odd character

        $idNumArray = str_split($idNumber);

        array_walk($idNumArray, function( & $character, $index){
            $character = ($index % 2) != 0 ? $character : '';
        });

        $evenString = implode('', $idNumArray);

        $evenString = $evenString * 2;

        $evenSum = array_sum(str_split($evenString));

        $evenOddSum = $evenSum + $oddsum;

        return (10 - substr($evenOddSum, -1));
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
