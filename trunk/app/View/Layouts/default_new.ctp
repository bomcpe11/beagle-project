<?php

//######### Check $_SESSION for user loged-in #############
if(isset($objuser) && !empty($objuser)){
	//TODO: it have objuser.
}else{
	//TODO: not found objuser, not loged-in., Redirect t LginController
// 	$this->redirect(array('controller' => 'orders'));
	header( "location: ".$this->webroot."login" );
	exit(0);
	return;
}

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

$cakeDescription = __d('cake_dev', 'Jstp hub ');
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		echo $this->Html->charset(); 

		echo $this->fetch('meta');
	?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css('reset-stylesheet');
		echo $this->Html->css('jstphub-default');
		echo $this->Html->css('jquery/ui/south-street/jquery-ui-1.10.3.custom.min');	

		echo $this->fetch('css');
	?>
</head>
<body>
	<!-- Header -->
	<div id="header">
		<div id="header_logo_wrapper">
			<img src="../img/logo-jstp.png"></img>
		</div>
		<div id="header_search_wrapper">
			<form>
				<table>
					<tr>
						<td><input style="width:245px;" type="text" placeholder="Search Project"></td>
						<td>
							<input type="image" src="../img/search-icon.png" 
								style="width: 20px;height: 20px;margin-left: 5px;" title="Search Project">
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<!-- Body -->
	<div id="body">
		<div id="profile">
			<div id="profile_picture">
			</div>
			<div id="profile_title">
				<div id="profile_title_name">
				</div>
				<div id="profile_title_generation">
				</div>
			</div>
			<div id="profile_detial">
			</div>
		</div>
		<div id="menu">
			<div id="menu_group_wrapper">
				<div class="menu-item">
					<img src="../img/icon-personalinfo-01.png" 
						alt="Personal Info" title="personal Info"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-resources-01.png" 
						alt="Resources" title="Resources"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-project-01.png" 
						alt="Project" title="Project"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-export-01.png" 
						alt="Export" title="Export"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-customize-01.png" 
						alt="Customize" title="Customize"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-archieve-01.png" 
						alt="Archieve" title="Archieve"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-mentorexpert-01.png" 
						alt="Mentor Expert" title="Mentor Expert"></img>
				</div>
				<div class="menu-item">
					<img src="../img/icon-otherjstp-01.png" 
						alt="Other JSTP" title="Other JSTP"></img>
				</div>
			</div>
		</div>
		<div id="content">Content</div>
	</div>
	<!-- Footer -->
	<div id="footer">
		<div id="footer_icon_wrapper">
			<img src="../img/logo-nstd-01.png" 
				alt="Logo NSTD" title="Logo NSTD"></img>
			<img src="../img/logo-kmutt-01.png" 
				alt="Logo KMUTT" title="Logo KMUTT"></img>
			<img src="../img/logo-cheangmai-01.png" 
				alt="Logo CMU" title="Logo CMU"></img>
			<img src="../img/logo-kasetsart-01.png" 
				alt="Logo KU" title="Logo KU"></img>
			<img src="../img/logo_sut-01.png" 
				alt="Logo SUT" title="Logo SUT"></img>
		</div>
	</div>
	
	<?php 
		/* jQuery Core*/
		echo $this->Html->script('jquery/core/jquery-1.10.2.min');
		/* jQuery UI */
		echo $this->Html->script('jquery/ui/jquery-ui-1.10.3.custom.min');
		
		echo $this->fetch('script');
	?>
	<script type="text/javascript">
		
	</script>
</body>
</html>
