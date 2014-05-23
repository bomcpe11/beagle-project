<?php
class Sequence extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getAlls(){
		$result = $this->query('select * from sequences');
		return $result;
	}

	public function next_val($seq_name){
		$result = $this->query("select curvalue from sequences t where name='".trim($seq_name)."'; update sequences set curvalue=curvalue+increment where name='".trim($seq_name)."';");
		return $result[0]['t']['curvalue'];
	}
	
}
?>