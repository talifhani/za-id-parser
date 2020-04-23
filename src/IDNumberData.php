<?php namespace Talifhani\ZaIdParser;

/**
 * @author Tali Luvhengo <tali@semicolon.co.za>
 */
class IDNumberData{
    private $idNumber;
    private $birthdate;
    private $age;
    private $gender;
    private $citizenship;
    private $valid;

    /**
     *
     * @param string $birthdate
     * @param int $age
     * @param string $gender
     * @param string $citizenship
     * @param bool $valid
     */
    public function __construct(string $idNumber, string $birthdate, int $age, string $gender, string $citizenship, bool $valid)
    {
        $this->idNumber         = $idNumber;
        $this->birthdate        = $birthdate;
        $this->age              = $age;
        $this->gender           = $gender;
        $this->citizenship      = $citizenship;
        $this->valid            = $valid;
    }

    /**
     * @return string
     */
    public function getIdNumber(): string
    {
        return $this->idNumber;
    }

    /**
     * @return string
     */ 
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * @return int
     */ 
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */ 
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return void
     */
    public function getCitizenShip(): string
    {
        return $this->citizenship;
    }

    /**
     * @return boolean
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    public function toArray(){
        $dateTimeBirthdate = \DateTime::createFromFormat('Y-m-d', $this->getBirthdate());
        $idArray = [];
        $idArray['birthdate'] = $dateTimeBirthdate->format('Y-m-d');
        $idArray['age'] = (new \DateTime)->diff($dateTimeBirthdate)->y;
        $idArray['gender'] = $this->genderNum >= 5000 ? 'Male' : 'Female';
        $idArray['citizenship'] = $this->citisenshipNum == 0 ? 'South African' : ($this->citisenshipNum == 1 ? 'Non South African' : 'Refugee');
        $idArray['valid'] = (bool) $this->valid;
        
        return $idArray;
    }
}
