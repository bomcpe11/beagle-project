<?php
class Comment extends AppModel {
	
	public function getComments(){
		$result = $this->query('select * from comments');
		return $result;
	}
}
?>