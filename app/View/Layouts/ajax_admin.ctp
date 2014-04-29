<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php 
//######### Check $_SESSION for user loged-in #############
	if(isset($objuser) && !empty($objuser) && $objuser['role_admin']=="1"){
		//TODO: it have objuser.
	}else{
		//TODO: not found objuser, not loged-in., Redirect t LginController
		// 	$this->redirect(array('controller' => 'orders'));
// 		header( "location: ".$this->webroot."login" );
		echo "Error : Your authentication failed!!!";
		exit(0);
		return;
	}
?>
<?php echo $this->fetch('content'); ?>
