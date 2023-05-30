<?php

return [

	'database_name' => 'lotto.db',
	'drawns' =>
		[

		[
			'table' => 'duzy_lotek_drawns',
			'url_name' => 'lotto',
			'count' => 6,
			
			'table2' => 'duzy_lotek_plus_drawns',
			'count2' => 6
		],
		
		[
			'table' => 'multi_lotek_drawns',
			'url_name' => 'multi-multi',
			'count' => 20,
			
			'table2' => 'multi_lotek_plus_drawns',
			'count2' => 1
		],
		
		[
			'table' => 'ekstra_pensja_drawns',
			'url_name' => 'ekstra-pensja',
			'count' => 6,
			
			'table2' => 'ekstra_pensja_premia_drawns',
			'count2' => 6
		],
		
		[
			'table' => 'kaskada_drawns',
			'url_name' => 'kaskada',
			'count' => 12,
		],
		
		[
			'table' => 'mini_lotto_drawns',
			'url_name' => 'mini-lotto',
			'count' => 5,
		],
		
		[
			'table' => 'euro_jackpot_drawns',
			'url_name' => 'eurojackpot',
			'count' => 7,
		],
	]
	
	
];

?>