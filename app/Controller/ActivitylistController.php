<?php
class ActivitylistController extends AppController {
	public $names = "ActivitylistController";
	public $uses = array('Activity','Profile');
	
	public function index() {
		$this->setTitle('ข้อมูลกิจกรรม');

	}
	
	function getActivitylist(){
		$this->log('Start :: ActivitylistController :: getActivitylist');
		$result = $this->Activity->getActivites();
		$this->log($result);
		
		$this->layout = "ajax";
	    $this->set('message', json_encode(array("result"=>$result)));
	    $this->render("response");
		 
		$this->log("END :: ActivitylistController :: getActivitylist");
		
	}
	
	function deleteActivity(){
		$this->log('Start :: ActivitylistController :: deleteActivity');
		$id = $this->request->data["id"];
		$this->log("IDDDDDDDDDD  -> ". $id);
		//$rs = $this->Activity->deleteActivites($id);
		//$status['id'] = $rs;
		$this->log("END :: ActivitylistController :: deleteActivity");
	}
	
	private function testNuengNaja(){
		$stt = array('01:00:00','00:00:00','04:00:00'); // must show 00:00-22:00
		$edt = array('20:00:00','22:00:00','20:00:00');
		$data = array();
		$i=0;
		foreach($stt as $rs){
			array_push($data,array('start'=>$stt[$i],'end'=>$edt[$i]));
			$i++;
		}
		
		$j=0;
		foreach($data as $pri){
		
			$showtime .= substr($data[$j]['start'],0,5).'-'. substr($data[$j]['end'],0,5).',';
			$j++;
		}
		
		echo $showtime;
	}
}