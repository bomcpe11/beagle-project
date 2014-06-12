<?php
class Gvar extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getGvars(){
		$result = $this->query('select * from gvars');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	function getVarcodeVardesc1ByVarname($byVarName) {
		$result = null;
		$strSql = "SELECT varcode, vardesc1";
		$strSql .= " FROM gvars";
		$strSql .= " WHERE varname='".$byVarName."'";
		$strSql .= " ORDER BY varcode ASC";
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e->getMessage());
		}// try catch
		
		return $result;
	}// getVarCodeVarDesc1
	function getVarcodeVardesc12ByVarname($byVarName) {
		$result = null;
		$strSql = "SELECT varcode, vardesc1, vardesc2";
		$strSql .= " FROM gvars";
		$strSql .= " WHERE varname='".$byVarName."'";
		$strSql .= " ORDER BY varcode ASC";
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e->getMessage());
		}// try catch
		
		return $result;
	}// getVarCodeVarDesc1
	/* ------------------------------------------------------------------------------------------------- */
	function getVarcodeVardesc1ByVarnameVardesc2($byVarName, $byVarDesc2) {
		$result = null;
		$strSql = "SELECT varcode, vardesc1";
		$strSql .= " FROM gvars";
		$strSql .= " WHERE varname='".$byVarName."'";
		$strSql .= " AND vardesc2='".$byVarDesc2."'";
		$strSql .= " ORDER BY varcode ASC";
	
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e->getMessage());
		}// try catch
	
		return $result;
	}// getVarCodeVarDesc1
}
?>