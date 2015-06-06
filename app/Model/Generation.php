<?php
class Generation extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getAll(){
		$result = $this->query('select * from generations');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function insert($name){
		$flag = false;
		$strSql = "INSERT INTO generations (id, name) "
				."VALUES (NULL, '".$name."')";
		//$this->log("strSql => ".$strSql);
			
		try {
			$this->query($strSql);
	
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
			
		return $flag;
	}public function remove($id){
		$flag = false;
		$strSql = "DELETE FROM generations ";
		$strSql .= "WHERE id='".$id."'";
		$strSql .= ";";
		//$this->log("strSql => ".$strSql);
			
		try {
			$this->query($strSql);
		
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
			
		return $flag;
	}
}
?>