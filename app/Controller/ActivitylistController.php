<?php
class ActivitylistController extends AppController {
	public $names = "ActivitylistController";
	public $uses = array('Activity','Profile');
	
	public function index() {
		$this->setTitle('ข้อมูลกิจกรรม');
		$this->getActivitylist();
	}
	
	function getActivitylist(){
		$this->log('Start :: ActivitylistController :: getActivitylist');
		$result = $this->Activity->getActivites();
		$this->log($result[0]["activities"]["name"]);
		$this->set("result", $result);
		 
		$this->log("END :: ActivitylistController :: getActivitylist");
		
	}
	
	function deleteActivity(){
		$this->log('Start :: ActivitylistController :: deleteActivity');
		$id = $this->request->data["id"];
		//$this->log("ID  -> ". $id ."  <- ");
		$rs = $this->Activity->deleteActivites($id);
		$this->log("RS  -> ". $rs ."  <- ");
		$status['id'] = $rs;
		$this->layout = "ajax";
		$this->set('message', json_encode(array("status"=>$status)));
		$this->render("response");
		
		$this->log("END :: ActivitylistController :: deleteActivity");
	}
}