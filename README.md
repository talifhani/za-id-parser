# South African Personal ID Validator  
Package to parse and validate South African ID Numbers.</p>  
## Installing

```shell

$ composer require talifhani/za-id-parser -vvv

```

## Usage
```php
use Talifhani\ZaIdParser\IDNumberParser;
$idNumberData = (new  IDNumberParser($idNum))->parse();

echo  "ID Number: ".$idNumberData->getIdNumber()."<br />";
echo  "Birthdate: ".$idNumberData->getBirthdate()."<br />";
echo  "Age: ".$idNumberData->getAge()."<br />";
echo  "Citizenship: ".$idNumberData->getCitizenship()."<br />";
echo  "Gender: ".$idNumberData->getGender()."<br />";
echo  "Is Valid ID: ".($idNumberData->isValid() ? 'Yes' : 'No');

print_r($idNumberData->toArray());
/*
(
    [birthdate] => 1988-09-15
    [age] => 30
    [gender] => Female
    [citizenship] => South African
    [valid] => 1
)
*/
```  

## Contributing
You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/semicolon/za-id-validator/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/semicolon/za-id-validator/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

  

## License
MIT
