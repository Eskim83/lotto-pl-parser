<?php

class Db {

	private $database_name = 'lotto.db';
	private $config = null;
	private $connection = null;

	public function __construct(array $config) {
		
		if (!isset($config['database_name'])) {
			
			throw new Exception ( 'Database name is not set' );
		}
		
		$this->connection = new SQLite3( $config['database_name'] );
		$this->config = $config;
	}
	
	function exec(string $query) {
		
		if ( !$this->connection->exec ($query) ) {
		  
			throw new Exception ( $this->connection->lastErrorMsg() );
		}
		return true;
	}
	
	function query(string $query) {
		
		$return = [];
		$result = $this->connection->query ($query);
		
		if ( !$result ) {
		  
			throw new Exception ( $this->connection->lastErrorMsg() );
		}
		
		return $result;
	}
	
	function querySingle(string $query) {
		
		return $this->connection->querySingle ($query);	
	}
	
	private function lfields($count = 1) {
		
		$lfields = '';
		if ($count > 0) {
			
			for ($i=1; $i <= $count; $i++) $lfields .= ",l$i";
			return $lfields;
		}
		return '';
	}
  
	function create() {

		if (!isset($this->config['drawns']) || empty($this->config['drawns'])) {
			
			throw new Exception ( 'No tables' );
		}

		$queries = [];
		foreach ($this->config['drawns'] as $cfg) {
			
			
			$table = $cfg['table'];
			$lfields = $this->lfields($cfg['count']);
			
			$query = "CREATE TABLE IF NOT EXISTS $table (nr int PRIMARY KEY, drawn_date datetime $lfields)";
			echo $query."\n";
			
			$this->exec($query);
			
			if (isset($cfg['table2'])) {
				
				$table = $cfg['table2'];
				$lfields = $this->lfields($cfg['count2']);
				
				$query = "CREATE TABLE IF NOT EXISTS $table (nr int PRIMARY KEY, drawn_date datetime $lfields)";
				echo $query."\n";
				$this->exec($query);
			}
		}
	}
	
	function tables() {

		$return = [];

		$query = 'SELECT * FROM sqlite_master WHERE type = "table"';

		$result = $this->query ($query);
		while ($row -> $result->fetchArray()) {
		  
			$return[] = $row;
		}
		return $this->query ($query);
	}
	
	function allNrs(string $table_name) {
		
		$return = [];
		
		$query = "SELECT nr FROM $table_name";
		$result = $this->query($query);
		if (empty ($result) ) return 0;
		while ($row = $result->fetchArray()) {
			
			$return[$row['nr']] = true;
		}
		return $return;
	}
	
	function lastDrawnNr(string $table_name) {

		$query = "SELECT MAX(nr) FROM $table_name";
		$result = $this->querySingle($query);
		if (empty ($result) ) return 0;
		return $result;
	}
	
	function add(string $table_name, int $drawn_nr, string $drawn_date, array $numbers) {

		foreach ($numbers as $nr) 
		if (!is_int ($nr) ) throw new Exception ('Numer nie jest typu int!');

		$numbers_frm = implode(',',$numbers);

		$matches = [];
		preg_match_all('/(\d{2}.\d{2}.\d{4})|(\d{2}:\d{2})/',$drawn_date, $matches);
		$date = implode(' ',$matches[0]);

		$lfields = $this->lfields(count($numbers));

		$query = "INSERT INTO $table_name (nr, drawn_date $lfields) VALUES ($drawn_nr, \"$date\", $numbers_frm)";		
		echo $query."\n";

		return $this->exec ($query);
	}
	
	function getDrawnsNrLost($table_name) {
		
		$query = "SELECT MIN(nr) FROM $table_name ORDER BY nr ASC";
		$min = $this->querySingle ($query);
		if (empty($min)) return false;
		
		$return = [];
		$query = "SELECT nr FROM $table_name ORDER BY nr ASC";
		$result = $this->query ($query);
		
		$in_base = [];
		$last = 0;
	    while ($row = $result->fetchArray()) {
			
			$in_base[$row['nr']] = true;
			$last = $row['nr'];
		}
		
		for ($i=$min; $i<=$last; $i++) {
		
			if (!isset($in_base[$i])) $return[] = $i;
		}
		
		return $return;
	}
}

?>