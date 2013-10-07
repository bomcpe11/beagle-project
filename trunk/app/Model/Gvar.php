<?php
class Gvar extends AppModel {
	
	public function getGvars(){
		$result = $this->query('select * from gvars');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	function getVarcodeVardesc1ByVarname($byVarName) {
		// local variables
		$result = null;
		$strSql = "SELECT varcode, vardesc1 FROM gvars WHERE varname='".$byVarName."'";
		$this->log($strSql, LOG_DEBUG);
		
		// query $strSql
		$result = $this->query($strSql);
		
		return $result;
	}// getVarCodeVarDesc1
}
?>