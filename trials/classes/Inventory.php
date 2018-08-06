<?php

class Inventory
{
	public static function parse_inventory($inventory, $option = null)
	{	
		// Polyaenus says: I don't need those noisy warning levels...
		//error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING);

		if(is_array($inventory) && count($inventory) === 1) {
            $inventory = $inventory[0];
        }

        if(is_string($inventory)) {
            $inventory = explode(',', $inventory);
        }

		$temp = array();
		for ($i = 0; $i < count($inventory); $i++)
		{
		    $trimmedValue = trim($inventory[$i], ' ');
			if ($trimmedValue !== '')
			{
				$temp[] = $trimmedValue;
			}
		}
		$inventory = $temp;
		sort($inventory);
		$result = array(
            'cows' => count($inventory),
            'list' => $inventory,
		);
		if ($option && $option[0] == 'freq')
		{
			$freqs = array(); 
			foreach ($inventory as $cow)
			{
				if (!array_key_exists($cow[0], $freqs))
				{
					$freqs[$cow[0]] = 0;
				}
				$freqs[$cow[0]]++;
			}
			$result['freq'] = $freqs;
		}
		return $result;
	}
}