<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
@session_start();
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	private $is_AllowFooterTrace = true;
	private $objuser = null;
	
	function beforeFilter(){
		$this->objuser = $this->Session->read('objuser');
		$this->set('objuser', $this->objuser);
		
// 		$dataProfile =  $this->getObjUser();
	
// 		$this->set("image_file",$dataProfile['image_file']);
// 		$this->set("position",$dataProfile['position']);
// 		$this->set("titleth",$dataProfile['titleth']);
// 		$this->set("image_desc",$dataProfile['image_desc']);
// 		$this->set("nameth", $dataProfile['nameth']);
// 		$this->set("lastnameth",$dataProfile['lastnameth']);
// 		$this->set("login",$dataProfile['login']);
// 		$this->set("last_login_at",$this->DateThai($dataProfile['last_login_at']));
		
	}
	
	protected function setTitle($msg){
		$this->set('title_for_layout', $msg);
		$this->set('page_title', $msg);
	}
	protected function trace($msg){
		if($this->is_AllowFooterTrace){
			$this->set('footer_trace', $msg);
		}
	}
	protected function getObjUser(){
		return $this->objuser;
	}
	
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
	
}
