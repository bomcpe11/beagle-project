<?php
class Comment extends AppModel {
	
	public function getComments(){
		$result = $this->query('select * from comments');
		return $result;
	}
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql="SELECT * FROM comments WHERE profile_id='$profile_id'";
		$this->log($sql);
		
		$result = $this->query($sql);
		
		return $result;
	}
}
?>