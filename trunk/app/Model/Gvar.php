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
		$strSql = "SELECT varcode, vardesc1";
		$strSql .= " FROM gvars";
		$strSql .= " WHERE varname='".$byVarName."'";
		$strSql .= " ORDER BY varcode ASC";
		$strSql .= ";";
		$this->log("strSql => ".$strSql);
		
		// query $strSql
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e.getMessage());
		}// try catch
		
		return $result;
	}// getVarCodeVarDesc1
}
?>