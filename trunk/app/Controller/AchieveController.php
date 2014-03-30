<?php
class AchieveController extends AppController{
	public $names = 'AchieveController';
	public $uses = array('Award');
	public $layout = 'default_new';
	/* ------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log('---- AchieveController -> index ----');
		
		/*$get_profile_id = @intval($this->request->query['id']);
		$sssnObjUser = $this->getObjUser();
		$objUser = $this->Profile->getDataById($get_profile_id);*/
		$objUser = $this->getObjUser();
		//$this->log(print_r($objUser, true));
		$isOwner = false;
		$fullNameTh = null;
		$listAward = null;
		
		
		if( !empty($objUser) ){
			/* owner profile */
			/*if( $get_profile_id==$sssnObjUser['id'] ){
				$isOwner = true;
			}*/
			
			/* fullName */
			if( $objUser['position'] ){
				$fullNameTh = $objUser['position'].$objUser['nameth'].' '.$objUser['lastnameth'];
			} else{
				$fullNameTh = $objUser['titleth'].$objUser['nameth'].' '.$objUser['lastnameth']; 
			} 
			
			/* award */
			$listAward = $this->Award->getDataByProfileId($objUser['id']);
			//$this->log(print_r($listAward, true));
		}
		
		/* set data to view*/
		$this->set(compact('isOwner'
							,'fullNameTh'
							,'listAward'));
	}
/* ------------------------------------------------------------------------------------------------ */
	public function savedNewAward(){
		$this->log('---- AchieveController -> savedNewAward ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->insertData($name
								,$awardname
								,$organization
								,$objUser['id']
								,'') ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลที่ได้รับเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลที่ได้รับ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editAward(){
		$this->log('---- AchieveController -> editAward ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->updateData($id
									,$name
									,$awardname
									,$organization
									,'0000') ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลที่ได้รับเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลที่ได้รับ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteAward(){
		$this->log('---- AchieveController -> deleteAward ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Award->getDataSource();
		if( $this->Award->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลผลการวิจัยเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลผลการวิจัย กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function updateSortableSeq(){
		$this->log('---- AchieveController -> updateSortableSeq ----');
		
		//$this->log($this->request->data);
		$result = array();
		$flagUpdateData = false;
		$id = $this->request->data['sortable_id'];
		$data = $this->request->data['data'];
		$countData = count($data);
		
		if( $id==='award' ){
			$dataSource = $this->Award->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Award->updateSeq($data[$i]['id']
																	,$data[$i]['seq']);
				if( !$flagUpdateData ){
					break;
				}
			}
			if( $flagUpdateData ){
				$dataSource->commit();
				$result['flg'] = 1;
				$result['msg'] = 'การแก้ไขลำดับ ข้อมูลผลงานวิจัยเสร็จเรียบร้อย';
			}else{
				$dataSource->rollback();
				$result['flg'] = -1;
				$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			}
		}else{
			$result['flag'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}