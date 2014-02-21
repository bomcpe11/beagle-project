<?php
class Webboard extends AppModel {
	/* ------------------------------------------------------------------------------------------------ */
	public function getWebboards(){
		$result = $this->query('select * from webboards');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function insertData($name
								,$researchtype
								,$advisor
								,$organization
								,$profile_id
								,$isnotfinish
								,$yearfinish
								,$dissemination){
		$flag=false;
		
		//$sql="INSERT INTO webboards (QuestionID, CreateDate, Question, Details, Name, View, Reply) VALUES (NULL, '2014-02-20 20:16:17', 'ทดสอบ คำถาม Webboard 3', 'อยากทราบว่า AAAAAA?', 'name3', '0', '0')";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteData($id){
		$flag=false;
		$sql="DELETE FROM webboards WHERE QuestionID='$id'";
		$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
		
	}
}
?>