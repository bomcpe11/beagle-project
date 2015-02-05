<?php
class Province extends AppModel {
	public function getRowAlls(){
		$result = $this->query('select * from provinces t');
		return $result;
	}

	public function getForDDL(){
		$result = $this->query('select id, name from provinces t');
		return $result;
	}
}
?>