<?php
class Activity extends AppModel {
	
	public function getActivites(){
		$result = $this->query('select * from activities ');
		return $result;
	}
	
	public function deleteActivites($idDelete){
		$sql = 'delete from activities where id ='.$idDelete;
		$result = $this->query($sql);
		return $result;
	}
	public function getDataByStmtSql($stmt_sql){
		$result = null;
		$sql = "SELECT * FROM activities WHERE $stmt_sql";
		$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
}
?>