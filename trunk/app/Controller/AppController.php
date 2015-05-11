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
	protected $isLogin = false;
	protected $isAdmin = false;
	protected $isSuperAdmin = false;
	
	
	function beforeFilter(){
		$this->objuser = $this->Session->read('objuser');
		$this->set('objuser', $this->objuser);
		//$this->log(print_r($this->objuser,true));
		
		$this->isLogin = !empty($this->objuser);
		$this->set('isLogin', $this->isLogin);
		
// 		$this->log($this->objuser);

		$this->isSuperAdmin = ($this->objuser['role_admin']==2?true:false);
		$this->set('isSuperAdmin', $this->isSuperAdmin);
		
		$this->isAdmin = $this->isSuperAdmin || ($this->objuser['role_admin']==1?true:false);
		$this->set('isAdmin', $this->isAdmin);
		
		
		$dataProfile =  $this->getObjUser();
// 		$this->log($dataProfile);
	
		$this->set("image_file",$dataProfile['image_file']);
		$this->set("position",$dataProfile['position']);
		$this->set("titleth",$dataProfile['titleth']);
		$this->set("image_desc",$dataProfile['image_desc']);
		$this->set("nameth", $dataProfile['nameth']);
		$this->set("lastnameth",$dataProfile['lastnameth']);
		$this->set("nickname",$dataProfile['nickname']);
		
// 		echo $dataProfile['generation'];
		
		$generation = is_numeric($dataProfile['generation'])? $dataProfile['generation']: '-';
		$this->set("generation",$generation);
		
		$this->set("address",$dataProfile['address']);
		$this->set("login",$dataProfile['login']);
		$this->set("last_login_at",$this->DateThai($dataProfile['last_login_at']));
		$this->set('last_updated_at',$this->DateThai($dataProfile['updated_at']));
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
	
	protected function getIsLogin(){
		return $this->isLogin;
	}
	
	protected function getIsAdmin(){
		return $this->isAdmin;
	}
	
	protected function getIsSuperAdmin(){
		return $this->isSuperAdmin;
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
	
	function getAge($strBirthday){
		$now = date('Y-m-d');
		$diffDate = abs(strtotime($now) - strtotime($strBirthday));
		$age = floor($diffDate / (365*60*60*24)) . ' ปี';
		
		return $age;
	}
	
	function recursive_directory_size($directory, $format=FALSE)
	{
		$size = 0;
	
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/')
		{
			$directory = substr($directory,0,-1);
		}
	
		// if the path is not valid or is not a directory ...
		if(!file_exists($directory) || !is_dir($directory) || !is_readable($directory))
		{
			// ... we return -1 and exit the function
			return -1;
		}
		// we open the directory
		if($handle = opendir($directory))
		{
			// and scan through the items inside
			while(($file = readdir($handle)) !== false)
			{
				// we build the new path
				$path = $directory.'/'.$file;
	
				// if the filepointer is not the current directory
				// or the parent directory
				if($file != '.' && $file != '..')
				{
					// if the new path is a file
					if(is_file($path))
					{
						// we add the filesize to the total size
						$size += filesize($path);
	
						// if the new path is a directory
					}elseif(is_dir($path))
					{
						// we call this function with the new path
						$handlesize = recursive_directory_size($path);
	
						// if the function returns more than zero
						if($handlesize >= 0)
						{
							// we add the result to the total size
							$size += $handlesize;
	
							// else we return -1 and exit the function
						}else{
							return -1;
						}
					}
				}
			}
			// close the directory
			closedir($handle);
		}
		// if the format is set to human readable
		if($format == TRUE)
		{
			// if the total size is bigger than 1 MB
			if($size / 1048576 > 1)
			{
				return round($size / 1048576, 1).' MB';
	
				// if the total size is bigger than 1 KB
			}elseif($size / 1024 > 1)
			{
				return round($size / 1024, 1).' KB';
	
				// else return the filesize in bytes
			}else{
				return round($size, 1).' bytes';
			}
		}else{
			// return the total filesize in bytes
			return $size;
		}
	}
	
}
