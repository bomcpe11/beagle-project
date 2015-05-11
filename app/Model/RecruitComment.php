<?php
class RecruitComment extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function insertData($title
								,$comment
								,$commentable_id
								,$commentable_type
								,$profile_id){
		$flag = false;
		$sql = "INSERT INTO recruit_comments 
				(
					title,
					comment,
					commentable_id,
					commentable_type,
					profile_id,
					created_at,
					updated_at,
					seq
				)
				VALUES
				(
					'$title',
					'$comment',
					'$commentable_id',
					'$commentable_type',
					'$profile_id',
					now(),
					now(),
					(SELECT ifnull(max(c.seq),0) + 1 AS seq FROM comments c WHERE c.commentable_id=$commentable_id)
				)";
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
	public function updateSeq($id,$seq){
		$flag = false;
		$sql = "UPDATE recruit_comments 
					SET seq = $seq
					, updated_at = now()
					WHERE id = '$id'";
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
	public function deleteData($id){
		$flag = false;
		$sql = "DELETE FROM recruit_comments WHERE id=$id";
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
		$result = $this->query('select * from recruit_comments');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql="SELECT * 
				FROM recruit_comments 
				WHERE profile_id='$profile_id'
				ORDER BY seq ASC";
		//$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataForProfile($profile_id,$commentable_id){
		$result=null;
		$sql="SELECT c.*
					,CONCAT(p.before_name)
							,p.first_name
							,' '
							,p.family_name) as commentator
				FROM recruit_comments c,recruit p
				WHERE c.commentable_id=p.id
					AND c.profile_id='$profile_id'
				ORDER BY c.seq ASC";
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
}
?>