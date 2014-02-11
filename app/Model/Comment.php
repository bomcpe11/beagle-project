<?php
class Comment extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function insertData($title
								,$comment
								,$commentable_id
								,$commentable_type
								,$profile_id){
		$flag = false;
		$sql = "INSERT INTO comments 
				(title,comment,commentable_id,commentable_type,profile_id,created_at,updated_at)
				VALUES('$title','$comment','$commentable_id','$commentable_type','$profile_id',now(),now())";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getComments(){
		$result = $this->query('select * from comments');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql="SELECT * FROM comments WHERE profile_id='$profile_id'";
		//$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataForProfile($profile_id){
		$result=null;
		$sql="SELECT c.*
					,p.login
				FROM comments c,profiles p
				WHERE c.commentable_id=p.id
					AND profile_id='$profile_id'";
		//$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
}
?>