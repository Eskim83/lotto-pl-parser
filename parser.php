<?php

/*
Autor: Maciej Włodarczak (https://eskim.pl)
Wersja: 1.0

Na podstawie artykułu: https://eskim.pl/skrypt-w-php-po-korzystajacy-z-bazy-sqlite/
*/

class Parser {

	function load($type, $nr) {
		
		$url = "https://www.lotto.pl/$type/wyniki-i-wygrane/number,$nr";
		
		$opts = [
		  'http'=> [
			'method'=>"GET",
			'header'=>"Accept-Encoding: gzip, deflate, br\r\n" .
					  "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7\r\n" .
					  "Referer: https://eskim.pl\r\n" .
					  "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 Edg/113.0.1774.50\r\n"
			]
		];

		print_r($url);

		$context = stream_context_create ($opts);
		$webpage = file_get_contents ($url, false, $context);
		return gzdecode ($webpage);
	}
	
	public function hasClass(DOMElement $dom, string $class) {
		
		if ($dom->hasAttribute('class')) {
		
			$value = $dom->getAttribute('class');
			if (strpos($value, $class) !== false) return true;
			return false;
		}
		return false;
	}
	
	public function wait() {
	
		$time = rand(1000000,5000000);
		usleep($time);
	}
}

?>