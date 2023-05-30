<?php

include_once 'db.php';
include_once 'lottoParser.php';

$config = include_once('config.php');

$db = new Db($config);
	
$parser = new LottoParser();
	
foreach ($config['drawns'] as $set) {
	
	$allNrsTable = $db->allNrs($set['table']);
	if (isset($set['table2'])) $allNrsTable2 = $db->allNrs($set['table2']);
	
	$counter = $db->lastDrawnNr($set['table'])+10;
	$lastCounter = $counter;
	$error = false;
	do {
		
		$data = $parser->load($set['url_name'], $counter);
		file_put_contents('lotto.html', $data);
		$parsed = $parser->parse($data);
				
		foreach ($parsed as $p) {
			
			try {
					
				if (!isset($allNrsTable[$p['nr']])) 
					$db->add( $set['table'], $p['nr'], $p['date'], array_slice($p['numbers'],0,$set['count']) );
				
				if (count($p['numbers'] && isset($set['table2'])) > $set['count']) {
					
					if (!isset($allNrsTable2[$p['nr']])) 
						$db->add( $set['table2'], $p['nr'], $p['date'], array_slice($p['numbers'],$set['count'],$set['count2']) );
				}
				
			} catch (Exception $e) {
				
				$error = true;
				echo $e->getMessage()."\n";
			}
		}
		$counter = $db->lastDrawnNr($set['table'])+10;
		$lastCounter = $counter;
		if ($counter == $lastCounter) break;
		echo 'Pobieram wyniki do losowania nr '.$counter."\n";
		$parser->wait();
		
	} while(!$error);
	
	$lost_numbers = $db->getDrawnsNrLost($set['table']);
	foreach ($lost_numbers as $lost) {
		
		$data = $parser->load($set['url_name'], $lost);
		file_put_contents('lotto.html', $data);
		$parsed = $parser->parse($data);
		
		foreach ($parsed as $p) {
			
			if ($p['nr'] != $lost) continue;
			
			echo 'Pobieram wyniki do losowania nr '.$lost."\n";
			try {
					
				if (!isset($allNrsTable[$p['nr']])) 
					$db->add( $set['table'], $p['nr'], $p['date'], array_slice($p['numbers'],0,$set['count']) );
				
				if (count($p['numbers'] && isset($set['table2'])) > $set['count']) {
					
					if (!isset($allNrsTable2[$p['nr']])) 
						$db->add( $set['table2'], $p['nr'], $p['date'], array_slice($p['numbers'],$set['count'],$set['count2']) );
				}
				
			} catch (Exception $e) {
				
				$error = true;
				echo $e->getMessage()."\n";
			}
		}
		
		$parser->wait();
	}
	
	if (isset($set['table2'])) {
		
		$lost_numbers = $db->getDrawnsNrLost($set['table2']);
		foreach ($lost_numbers as $lost) {
			
			$data = $parser->load($set['url_name'], $lost);
			file_put_contents('lotto.html', $data);
			$parsed = $parser->parse($data);
			
			foreach ($parsed as $p) {
				
				if ($p['nr'] != $lost) continue;
				
				echo 'Pobieram wyniki do losowania nr '.$lost."\n";
				try {				
						
					if (!isset($allNrsTable2[$p['nr']]))  
						$db->add( $set['table2'], $p['nr'], $p['date'], array_slice($p['numbers'],$set['count'],$set['count2']) );
					
				} catch (Exception $e) {
					
					$error = true;
					echo $e->getMessage()."\n";
				}
			}
			
			$parser->wait();
		}
	}
}

?>