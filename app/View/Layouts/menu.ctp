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

$cakeDescription = __d('cake_dev', 'My JSTP');
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		echo $this->Html->charset(); 
	?>
	<title>
		<?php echo $cakeDescription ?> :
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		/* CSS */
		echo $this->Html->css('reset-stylesheet');
		echo $this->Html->css('jstphub-menu');
		echo $this->Html->css('jquery/ui/south-street/jquery-ui-1.10.3.custom.min');
		echo $this->Html->css('loading');
	
		/* JavaScript */
		echo $this->Html->script('jquery/core/jquery-1.10.2.min');
		echo $this->Html->script('jquery/ui/jquery-ui-1.10.3.custom.min');
		echo $this->Html->script('jquery/ui/jquery.ui.1.10.3.datepicker.th');
		echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('loading');
		echo $this->Html->script('jstphub-common');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<!-- Header -->
	<div id="header">
		<div id="header_logo_wrapper">
			<img src="<?php echo $this->Html->url('/img/logo-jstp_v2.png');?>"></img>
		</div>
		<div id="header_search_wrapper">
			<form>
				<table style="width: 100%;">
					<tr>
						<td style="width: 28%;">
							<button type="button" id="btn-logout">Log off</button>
						</td>
						<td style="width: 62%;">
							<input class="txt-search" type="text" placeholder="Search...">
						</td>
						<td style="width: 10%;">
							<input type="image" src="<?php echo $this->Html->url('/img/search-icon.png');?>" 
								style="width: 20px;height: 20px;margin-left: 5px;" title="Search Project">
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<div id="header-bottom-border">
		
	</div>
	<!-- Body -->
	<div id="page">
		<div id="column_left">
			<div id="profile">
				<div id="profile_picture">
					<img src="<?php echo $this->webroot.$image_file;?>"
						alt="Profile Picture" >
				</div>
				<div id="profile_title">
					<div id="profile_nickname">
						<?php echo $nickname; ?>
					</div>
					<div id="profile_title_generation">
						<p style="font-size: 1em;">JSTP</p>
						<p style="font-size: 1.75em;">
							<?php echo $generation; ?>
						</p>
					</div>
				</div>
				<div id="profile_detial">
					<p><?php if(isset($position) && !empty($position)){
		                     	        echo $position;
		                     	      }else{
  										echo $titleth;
  									  }
								?>
		                     <?php echo $nameth; ?>&nbsp;&nbsp;<?php echo $lastnameth; ?></p>
					<p><?php echo isset($address) && !empty($address)? $address: '-';?></p>
					<p style="position: absolute;bottom: 10px;right: 10px;">สถานะโปรไฟล์</p>
				</div>
			</div>
			<div id="content">
				<div id="content_page">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<div id="footer">
		<div id="footer_icon_wrapper">
			<img src="<?php echo $this->Html->url('/img/logo-nstd-01.png');?>"
				alt="Logo NSTD" title="Logo NSTD"></img>
			<img src="<?php echo $this->Html->url('/img/logo-kmutt-01.png');?>" 
				alt="Logo KMUTT" title="Logo KMUTT"></img>
			<img src="<?php echo $this->Html->url('/img/logo-cheangmai-01.png');?>" 
				alt="Logo CMU" title="Logo CMU"></img>
			<img src="<?php echo $this->Html->url('/img/logo-kasetsart-01.png');?>" 
				alt="Logo KU" title="Logo KU"></img>
			<img src="<?php echo $this->Html->url('/img/logo_sut-01.png');?>" 
				alt="Logo SUT" title="Logo SUT"></img>
		</div>
	</div>
	<?php
		if(isset($footer_trace) && !empty($footer_trace)){
			?><div>####### FOOTER TRACE #######<br /><pre><?php print_r($footer_trace); ?></pre></div><?php
		}
	?>
	<div id="block-page" class="loading-unblock"><div id="block-page_hdn"></div></div>
	<div id="div_loading" class="loading-invisible">
	    &nbsp;
	    <table border="0" style="margin-left: auto;margin-right: auto;">
	        <tr>
	            <td align="center" valign="middle">
	            		<?php echo $this->Html->image('loading.gif', array('style'=>'border: 0;')); ?>
	            </td>
	        </tr>
	        <tr>
	            <td align="center" valign="middle">
	                <font size="2" color="#FFFFFF"><b><span class="message">Loading</span></b></font>
	            </td>
	        </tr>
	    </table>
	    &nbsp;
	</div>
	
	<script type="text/javascript">
		jQuery.noConflict();
		G_WEB_ROOT = '<?php echo $this->webroot; ?>';
	
		jQuery(document).ready(function(){
			jQuery('input:button, input:submit').button();
			jQuery('.tooltip').tooltip();
		});

		jQuery('#btn-logout').button({
		      icons: {
		          primary: "ui-icon-locked"
		        }
		      }).click(function(){
		    	  window.location.replace('<?php echo $this->Html->url('/Logout'); ?>');
		      });
	</script>
</body>
</html>
