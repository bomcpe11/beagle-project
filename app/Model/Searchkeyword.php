<?php
class Searchkeyword extends AppModel {
	
	public function getAlls(){
		$result = $this->query('select * from searchkeywords');
		return $result;
	}
	
	public function search($keyword){
		$result = null;
		$strSql = "select * from searchkeywords where keyword like '%".$keyword."%'";
// 		$this->log("strSql => ".$strSql);
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
		
		return $result;
	}
}
?>