<?php
class EmailHistory extends AppModel{
	/* --------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$this->log('---- EmailHistory -> getDataByProfileId() ----');
		
		$result = null;
		$sql = "select * from email_histories eh where profile_id=:profile_id";
		//$this->log($sql);
		
		try{
			$db = $this->getDataSource();
			$result = $db->fetchAll($sql,
									array('profile_id' => $profile_id));
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function insert($profile_id,
							$recipient,
							$subject,
							$content){
		$this->log('---- EmailHistory -> insert() ----');
		
		$flg = false;
		$sql = "insert into email_histories
					(
					profile_id,
					recipient,
					subject,
					content,
					created_at
					)
					values 
					(
					:profile_id,
					:recipient,
					:subject,
					:content,
					now()
					)";
		//$this->log($sql);
		
		try{
			$db = $this->getDataSource();
			$db->fetchAll($sql,
							array('profile_id' => $profile_id,
									'recipient' => $recipient,
									'subject' => $subject,
									'content' => $content));
			$flg = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flg;
	}
}