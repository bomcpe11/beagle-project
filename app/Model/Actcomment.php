<?php
class Actcomment extends AppModel{
	/* ------------------------------------------------------------------------------------------------- */
	public function getAll(){
		$result = $this->query('select * from actcomments');
		return $result;
	}
	public function insertData($title
								,$comment
								,$commentable_id
								,$commentable_type
								,$activity_id){
		$flag = false;
		$sql = "INSERT INTO actcomments 
				(
					title,
					comment,
					commentable_id,
					commentable_type,
					activity_id,
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
					'$activity_id',
					now(),
					now(),
					(SELECT ifnull(max(ac.seq) + 1,0) AS seq FROM actcomments ac WHERE activity_id=$activity_id)
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
		$sql = "UPDATE actcomments 
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
		$sql = "DELETE FROM actcomments WHERE id=$id";
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
	public function selectByActivityId($activity_id){
		$result=null;
		$sql="SELECT ac.*,
					CONCAT(if(LENGTH(p.position)>0,p.position,p.titleth)
							,p.nameth
							,' '
							,p.lastnameth) as commentator
					FROM actcomments ac INNER JOIN profiles p ON ac.commentable_id = p.id
					WHERE ac.activity_id='$activity_id'
					ORDER BY ac.seq";
		//$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
}