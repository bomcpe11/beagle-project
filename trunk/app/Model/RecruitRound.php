<?php
class RecruitRound extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getAll(){
		$result = $this->query('select * from recruit_rounds where status=1');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function insert($name){
		$flag = false;
		$strSql = "INSERT INTO recruit_rounds (id, name, update_at) "
				."VALUES (NULL, '".$name."', now())";
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
		$strSql = "UPDATE recruit_rounds set status=0 ";
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