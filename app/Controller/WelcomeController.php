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

App::uses('CakeEmail', 'Network/Email');

class WelcomeController extends AppController {

	public $names = "WelcomeController";
	public $uses = array('Profile');
	public $layout = "public";

	public function index(){
		
		$this->setTitle('ยินดีต้อนรับ');
		
		$this->log('Test Logger krafffffff!!!!ครับ');
		$this->log('Test Logger krafffffff!!!!ค่ะ');
		
		//$this->trace($this->Profile->getProfiles());
		
		//$this->Session->write('objuser', 'TEST SESSION');
		//$this->log('SESSION.DETAIL='.print_r($_SESSION, true));
		
		return;
		
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

	public function testSendEmail(){
	
		//TODO: Send email code here.
		/*// The message
		$message = "Line 1\r\nLine 2\r\nLine 3";
	
		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70, "\r\n");
	
		// Send
		$result = mail('jnattapop@gmail.com', 'My Subject', $message);
	
		print_r($result);
	
		*/
	
		
		$names = array('Leoma Bulkley','Jermaine Meredith','Raguel Dalpiaz','Alfonzo Vasconcellos','Chanelle Bono','Hillary Veach','Lovella Scull','Janelle July','Shay Hilchey','Latrisha Fite','Evonne Moss','Lynnette Fails','Lucretia Vanduyne','Jennell Schug','Ashly Castonguay','Herbert Castagna','Michel Borchers','Leila Behrendt','Nila Marinaro','Margery Peets','Sondra Scaglione','Kelsie Hoy','Gillian Jarvis','Casimira Coyle','Claudia Forehand','Twyla Mcdowell','Gayle Nesby','Monet Seedorf','Teodora Doll','Kaylene Greenly','Marylynn Jolicoeur','Lissette Lunday','Candi Rentfro','Irvin Hattaway','Glennie Zupan','Yi Manzano','Ardith Beggs','Golda Ouk','Vernetta Treece','Pamala Wohl','Ramona Trousdale','Jayne Gilmer','Yuriko Gracey','Pa Fine','Flor Alleman','Ocie Johnosn','Julian Gooslin','Martha Haugh','Ila Gammage','Renita Kress');
	
		$name = $names[array_rand($names)];

// 		$recipient = 'bombermancpe11@hotmail.com';
		$recipient = 'j_nattapop@hotmail.com';
		$subject = 'MyJSTP : Registering '.$name;
		$content = '<b>Dear '.$name.'</b><br /></p>MyJSTP Test mail sending & Registering</p><p>MyJSTP Register, Please click this link
http://myjstp.org/Register?id=597&key='.$name.'</p>';
	
		$email = new CakeEmail('jstpEmail');
		$email->template('jstphub_email', 'jstphub_email');
		$email->emailFormat('html');
		$email->from(array('admin@myjstp.org' => 'MyJSTP Administrator'));
		$email->to($recipient);
		$email->subject($subject);
		$email->send($content);
		$result = true;
	
		$this->layout = 'ajax_public';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
}
