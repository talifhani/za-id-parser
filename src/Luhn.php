<?php namespace Talifhani\ZaIdParser;

class Luhn
{
	/**
	 * @param string $number
	 * @return int
	 */
	public function generate(string $number)
	{
		if ( ! ctype_digit($number))
			throw new \InvalidArgumentException('$number can only have digits');

		$length = strlen($number);
		$sum    = 0;
		$weight = 2;

		for ($i = $length - 1; $i >= 0; $i--)
		{
			$digit = $weight * $number[$i];
			$sum += floor($digit / 10) + $digit % 10;
			$weight = $weight % 2 + 1;
		}

		return (10 - $sum % 10) % 10;
	}

	/**
	 * @param $number
	 * @return bool
	 */
	public function check($number)
	{
		preg_match('(^(\d+)(\d)$)', $number, $matches);

		if (count($matches) !== 3)
			throw new \InvalidArgumentException('Invalid format!');

		return $this->generate($matches[1]) === (int) $matches[2];
	}
}