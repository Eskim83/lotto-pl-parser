<?php

/*
Autor: Maciej Włodarczak (https://eskim.pl)
Wersja: 1.0

Na podstawie artykułu: https://eskim.pl/skrypt-w-php-po-korzystajacy-z-bazy-sqlite/
*/

include_once 'parser.php';

class LottoParser extends Parser {

	public function parse(string $page) {
				
		$website = new DOMDocument();
		$website->loadHTML ($page);

		$divs = $website->getElementsByTagName('div');

		foreach ($divs as $div) {

			if ($this->hasClass($div, 'game-results-container')) {

			   $element = $website->saveHTML($div); 
			   $result = new DOMDocument(); 
			   $result->loadHTML ($element);
			   break;
			}
		}
		$website = null; // usuń z pamięci cały dokument
		
		$divs = $result->getElementsByTagName('div'); // pobierz wszystkie tagi div

		$drawns = [];

		foreach ($divs as $div) {

			if ($this->hasClass($div, 'game-main-box')) {

			   $element = $result->saveHTML($div); // zapisz diva w formacie html do zmiennej $element
			   $drawn = new DOMDocument(); // utwórz nowy obiekt DOM
			   $drawn->loadHTML ($element); // zamień diva na obiekt DOM
			   $drawns[] = $drawn;
			}
		}
		
		$drawns_result = [];

		foreach ($drawns as $drawn) {

			$numbers = [];
			$data = '';
			$nr = '';

			$ps = $drawn->getElementsByTagName('p');
			foreach ($ps as $p) {
			 
				if ($this->hasClass($p, 'sg__desc-title')) {
					
					$data = trim($p->nodeValue);
				}
				
				if ($this->hasClass($p, 'result-item__number')) {
					
					$nr = trim($p->nodeValue);
					break;
				}
			}

			$divs = $drawn->getElementsByTagName('div');
			foreach ($divs as $div) {
			  
				if ($this->hasClass($div, 'scoreline-item')) {
				  
					$numbers[] = (int)trim($div->nodeValue);
				}
			  
				if ($this->hasClass($div, 'scoreline-item')) {
								
					$numbers[] = (int)trim($div->nodeValue);	
				}
			}

			$drawns_result[(int)$nr] = [
			
				'date' => $data,
				'nr' => (int)$nr,
				'numbers' => $numbers
			];
		}

		return array_reverse($drawns_result);
	}
}

?>