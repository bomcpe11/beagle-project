<?php
class ProjectController extends AppController {
	public $names = 'ProjectController';
	public $uses = array('Profile','Research','Otherwork','Gvar');
	public $layout = 'default_new';
	/* --------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log('---- ProjectController -> index ----');
		
		$get_profile_id = @intval($this->request->query['id']);
		$sssnObjUser = $this->getObjUser();
		$objUser = $this->Profile->getDataById($get_profile_id);
		//$this->log(print_r($objUser, true));
		/*
		 * -1 = not is owner profile
		 * 1 = is owner profile
		 */
		$isOwner = '-1';
		$fullNameTh = null;
		$listResearchType = null;
		$listResearch = null;
		$listOtherwork = null;
		
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
			
			/* research */
			$listResearchType = $this->Gvar->getVarcodeVardesc1ByVarname('RESEARCH_TYPE');
			$listResearch = $this->Research->getDataByProfileId($objUser[0]['profiles']['id']);
			//$this->log(print_r($listResearch, true));
			
			/* otherword */
			$listOtherwork = $this->Otherwork->getDataByProfileId($objUser[0]['profiles']['id']);
		}
		//$this->log(print_r($isOwner));
		
		/* set data to view*/
		$this->set(compact('isOwner'
							,'fullNameTh'
							,'listResearchType'
							,'listResearch'
							,'listOtherwork'));
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function savedNewResearch(){
		$this->log('---- ProjectController -> savedNewResearch ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$researchtype = $this->request->data['researchtype'];
		$advisor = $this->request->data['advisor'];
		$organization = $this->request->data['organization'];
		$isnotfinish = ( ($this->request->data['isnotfinish']==='true')?'1':'0' );
		$yearstart = empty($this->request->data['yearstart'])?'null':intval($this->request->data['yearstart'])-543;
		$yearfinish = empty($this->request->data['yearfinish'])?'null':intval($this->request->data['yearfinish'])-543;
		$dissemination = $this->request->data['dissemination'];
		$detail = $this->request->data['detail'];

		$dataSource = $this->Research->getDataSource();
		if( $this->Research->insertData($name
										,$researchtype
										,$advisor
										,$organization
										,$objUser['id']
										,$isnotfinish
										,$yearstart
										,$yearfinish
										,$dissemination
										,$detail) ){
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
	public function editResearch(){
		$this->log('---- ProjectController -> editResearch ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$researchtype = $this->request->data['researchtype'];
		$advisor = $this->request->data['advisor'];
		$organization = $this->request->data['organization'];
		$isnotfinish = ( ($this->request->data['isnotfinish']=='true')?'1':'0' );
		$yearstart = empty($this->request->data['yearstart'])?'null':intval($this->request->data['yearstart'])-543;
		$yearfinish = empty($this->request->data['yearfinish'])?'null':intval($this->request->data['yearfinish'])-543;
		$dissemination = $this->request->data['dissemination'];
		$detail = $this->request->data['detail'];

		$dataSource = $this->Research->getDataSource();
		if( $this->Research->updateData($id
										,$name
										,$researchtype
										,$advisor
										,$organization
										,$objUser['id']
										,$isnotfinish
										,$yearstart
										,$yearfinish
										,$dissemination
										,$detail) ){
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
	public function deleteResearch(){
		$this->log('---- ProjectController -> deleteResearch ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Research->getDataSource();
		if( $this->Research->deleteData($id) ){
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
	public function savedNewOtherwork(){
		$this->log('---- ProjectController -> savedNewOtherwork ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$organization = $this->request->data['organization'];
		$yearstart = empty($this->request->data['yearstart'])? 'null': intval($this->request->data['yearstart'])-543;
		$yearfinish = empty($this->request->data['yearfinish'])? 'null': intval($this->request->data['yearfinish'])-543;
		$isnotfinish = ( ($this->request->data['isnotfinish']==='true')?'1':'0' );
		$detail = $this->request->data['detail'];

		$dataSource = $this->Otherwork->getDataSource();
		if( $this->Otherwork->insertData($name
										,$organization
										,$objUser['id']
										,$yearstart
										,$yearfinish
										,$isnotfinish
										,$detail) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลอื่นๆเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลอื่นๆ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function editOtherwork(){
		$this->log('---- ProjectController -> editOtherwork ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$organization = $this->request->data['organization'];
		$yearstart = empty($this->request->data['yearstart'])? 'null': intval($this->request->data['yearstart'])-543;
		$yearfinish =  empty($this->request->data['yearfinish'])? 'null': intval($this->request->data['yearfinish'])-543;
		$isnotfinish = ( ($this->request->data['isnotfinish']==='true')?'1':'0' );
		$detail = $this->request->data['detail'];
		
		$dataSource = $this->Otherwork->getDataSource();
		if( $this->Otherwork->updateData($id
										,$name
										,$organization
										,$objUser['id']
										,$yearstart
										,$yearfinish
										,$isnotfinish
										,$detail) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลอื่นๆเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลอื่นๆ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function deleteOtherwork(){
		$this->log('---- ProjectController -> deleteOtherwork ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Otherwork->getDataSource();
		if( $this->Otherwork->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลอื่นๆเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลอื่นๆ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function updateSortableSeq(){
		$this->log('---- ProjectController -> updateSortableSeq ----');
		
		//$this->log($this->request->data);
		$result = array();
		$flagUpdateData = false;
		$id = $this->request->data['sortable_id'];
		$data = $this->request->data['data'];
		$countData = count($data);
		
		if( $id==='research' ){
			$dataSource = $this->Research->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Research->updateSeq($data[$i]['id']
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
		}else if( $id==='otherwork' ){
			$dataSource = $this->Otherwork->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Otherwork->updateSeq($data[$i]['id']
																	,$data[$i]['seq']);
				if( !$flagUpdateData ){
					break;
				}
			}
			if( $flagUpdateData ){
				$dataSource->commit();
				$result['flg'] = 1;
				$result['msg'] = 'การแก้ไขลำดับ ข้อมูลผลงานอื่นๆเสร็จเรียบร้อย';
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