<?php
class Research extends AppModel {
	/* ------------------------------------------------------------------------------------------------ */
	public function getResearches(){
		$result = $this->query('select * from researches');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql="SELECT r.*
				,(SELECT vardesc1 FROM gvars g WHERE g.varname='RESEARCH_TYPE' AND g.varcode=r.researchtype) research_type
				FROM researches r 
				WHERE r.profile_id='$profile_id'";
		
		$result = $this->query($sql);
		
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
		$sql="INSERT INTO researches (
							name
							,researchtype
							,advisor
							,organization
							,profile_id
							,created_at
							,updated_at
							,isnotfinish
							,yearfinish
							,dissemination)
					VALUES('$name'
							,'$researchtype'
							,'$advisor'
							,'$organization'
							,'$profile_id'
							,'$isnotfinish'
							,now()
							,now()
							,'$yearfinish'
							,'$dissemination')";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateData($id
								,$name
								,$researchtype
								,$advisor
								,$organization
								,$profile_id
								,$isnotfinish
								,$yearfinish
								,$dissemination){
		$flag=false;
		$sql="UPDATE researches
				SET name='$name'
					,researchtype='$researchtype'
					,advisor='$advisor'
					,organization='$organization'
					,profile_id='$profile_id'
					,updated_at=now()
					,isnotfinish='$isnotfinish'
					,yearfinish='$yearfinish'
					,dissemination='$dissemination'
				WHERE id='$id'";
		//$this->log($sql);
		
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
		$sql="DELETE FROM researches WHERE id='$id'";
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