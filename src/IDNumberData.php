<?php namespace Semicolon\ZaIdValidator;

/**
 * @author Tali Luvhengo <tali@semicolon.co.za>
 */
class IDNumberData{
    private $birthdate;
    private $age;
    private $gender;
    private $citizinsheShip;
    private $valid;

    /**
     *
     * @param string $birthdate
     * @param int $age
     * @param string $gender
     * @param string $citizinsheShip
     * @param bool $valid
     */
    public function __construct(string $birthdate, int $age, string $gender, string $citizinsheShip, bool $valid){
        $this->birthdate        = $birthdate;
        $this->age              = $age;
        $this->gender           = $gender;
        $this->citizinsheShip   = $citizinsheShip;
        $this->valid            = $valid;
    }

    /**
     * Get the value of birthdate
     */ 
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * Get the value of age
     */ 
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return void
     */
    public function getCitizinsheShip(): string
    {
        return $this->citizinsheShip;
    }

    /**
     * @return boolean
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    public function toArray(){
        $dateTimeBirthdate = DateTime::createFromFormat('Y-m-d', $this->getBirthdate());
        $idArray = [];
        $idArray['birthdate'] = $dateTimeBirthdate->format('Y-m-d');
        $idArray['age'] = (new DateTime)->diff($dateTimeBirthdate)->y;
        $idArray['gender'] = $this->genderNum >= 5000 ? 'Male' : 'Female';
        $idArray['citizenship'] = $this->citisenshipNum == 0 ? 'South African' : ($this->citisenshipNum == 1 ? 'Non South African' : 'Refugee');
        $idArray['valid'] = $this->valid;
        
        return $idArray;
    }
}
