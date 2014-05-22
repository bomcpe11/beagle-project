<?php
class AchieveController extends AppController{
	public $names = 'AchieveController';
	public $uses = array('Profile','Award');
// 	public $layout = 'default_new';
	/* ------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log('---- AchieveController -> index ----');
		
		$get_profile_id = @intval($this->request->query['id']);
		$sssnObjUser = $this->getObjUser();
		$objUser = $this->Profile->getDataById($get_profile_id);
		//$this->log(print_r($objUser, true));
		/*
		 * 	-1 	= not is owner profile
		 * 	1 	= is owner profile
		 */
		$isOwner = '-1';
		$fullNameTh = '';
		$listAward = '';
		
		if( !empty($objUser) ){
			/* owner profile */
			if( $get_profile_id==$sssnObjUser['id'] ){
				$isOwner = '1';
			}
			
			/* fullName */
			if( $objUser[0]['profiles']['position'] ){
				$fullNameTh = $objUser[0]['profiles']['position']
								.$objUser[0]['profiles']['nameth']
								.' '
								.$objUser[0]['profiles']['lastnameth'];
			} else{
				$fullNameTh = $objUser[0]['profiles']['titleth']
								.$objUser[0]['profiles']['nameth']
								.' '
								.$objUser[0]['profiles']['lastnameth']; 
			} 
			
			/* award */
			$listAward = $this->Award->getDataByProfileId($objUser[0]['profiles']['id']);
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
		$profile_id = $this->request->data['profile_id'];
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
		$detail = $this->request->data['detail'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->insertData($name
									,$awardname
									,$organization
									,$profile_id
									,''
									,$detail) ){
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
		$profile_id = $this->request->data['profile_id'];
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
		$detail = $this->request->data['detail'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->updateData($id
									,$name
									,$awardname
									,$organization
									,'0000'
									,$detail) ){
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