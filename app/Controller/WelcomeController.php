<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class WelcomeController extends AppController {

	public $uses = array('Profile');

	public function index(){
		
		$this->setTitle('ยินดีต้อนรับ');
		
		$this->log('Test Logger krafffffff!!!!ครับ');
		$this->log('Test Logger krafffffff!!!!ค่ะ');
		
		//$this->trace($this->Profile->getProfiles());
		
		//$this->Session->write('objuser', 'TEST SESSION');
		//$this->log('SESSION.DETAIL='.print_r($_SESSION, true));
		
		$this->trace($this->Session->read('objuser'));
		$this->trace($this->getObjUser());
		$this->set("page_title","Welcome");
		
		$this->testStdObjectKeyValue();
	}

	private function testStdObjectKeyValue(){
		#Ref : http://stackoverflow.com/questions/10992005/php-get-the-key-from-an-array-in-a-foreach-loop
		$arr_results = $this->Profile->getProfiles();
		
		$result = $arr_results[0];
		$this->log($result);
		
		foreach($result['profiles'] as $key => $item){
			$this->log($key.'='.$item);
		}
	}
	
}