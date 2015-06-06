<?php
class Webboard extends AppModel {
	/* ------------------------------------------------------------------------------------------------ */
	public function getWebboards(){
		$result = $this->query('select * from webboards');
		return $result;
	}
	public function getWebboard($questionId){
		$result = $this->query("select * from webboards where QuestionID='".$questionId."'");
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getWebboardsLimit($start, $num){
// 		$this->log('select * from webboards order by QuestionID DESC LIMIT '.$start.' , '.$num);
		$result = $this->query('select * from webboards order by QuestionID DESC LIMIT '.$start.' , '.$num);
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function countAllRecord(){
// 		$this->log('select count(1) as count from webboards');
		$result = $this->query('select count(1) as count from webboards');
		$this->log($result);
		return $result[0][0]['count'];
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function incrementView($questionId){
		$flag=false;
		$sql = "UPDATE webboards SET View = View + 1 WHERE QuestionID = '".$questionId."' ";
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function incrementReply($questionId){
		$flag=false;
		$sql = "UPDATE webboards SET Reply = Reply + 1 WHERE QuestionID = '".$questionId."' ";
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function insertData($question
								,$details
								,$name){
		$flag=false;
		
		$sql="INSERT INTO webboards (QuestionID, CreateDate, Question, Details, Name, View, Reply) 
				VALUES (NULL, now(), '".$question."', '".$details."', '".$name."', '0', '0')";
		
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