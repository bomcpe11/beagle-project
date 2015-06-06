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

// initialize profile_id
$profile_id = isset($_GET['id']) && $this->params['controller']!=='Activity'? $_GET['id']: $objuser['id'];

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
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico');?>" type="image/x-icon">
	<link rel="icon" href="<?php echo $this->Html->url('/img/favicon.ico');?>" type="image/x-icon">
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
		echo $this->Html->css('jstphub-default');
		echo $this->Html->css('jquery/ui/south-street/jquery-ui-1.10.3.custom.min');
		echo $this->Html->css('loading');
		echo $this->Html->css('smartpaginator');
		echo $this->Html->css('select2/select2.min.css');
	
		/* JavaScript */
		echo $this->Html->script('jquery/core/jquery-1.10.2.min');
		echo $this->Html->script('jquery/ui/jquery-ui-1.10.3.custom.min');
		echo $this->Html->script('jquery/ui/jquery.ui.1.10.3.datepicker.th');
		echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('loading');
		echo $this->Html->script('jstphub-common');
		echo $this->Html->script('smartpaginator'); // library pagination ref. http://www.jqueryrain.com/?HVoQvgb3
		echo $this->Html->script('select2/dist/js/select2.full'); // REF : https://select2.github.io/
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script type="text/javascript">
		jQuery.noConflict();
		G_WEB_ROOT = '<?php echo $this->webroot; ?>';
	</script>
</head>
<body>
	<!-- Header -->
	<div id="header">
		<div id="header_logo_wrapper">
			<img src="<?php echo $this->Html->url('/img/logo-jstp_v2.png');?>"></img>
		</div>
		<div id="header_search_wrapper">
			<table style="width: 100%;">
				<tr>
					<td style="width: 45%;">
						<button type="button" id="btn-mainmenu">Main menu</button>
						<button type="button" id="btn-logout">Log off</button>
					</td>
					<td style="width: 45%;">
						<form id="form-search" action="<?php echo $this->Html->url('/Searchresult');?>" method="get">
							<input class="txt-search" type="text" name="keyword" value="<?php echo (empty($keyword)?'':$keyword); ?>" placeholder="Search...">
						</form>
					</td>
					<td style="width: 10%;">
						<input type="image" src="<?php echo $this->Html->url('/img/search-icon.png');?>" 
							style="width: 20px;height: 20px;margin-left: 5px;" title="Search Project" onclick="submitFormSearch();">
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="header-bottom-border">
		
	</div>
	<!-- Body -->
	<div id="page">
		<div id="column_right">
			<div id="menu">
				<div id="menu_group_wrapper">
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot;?>PersonalInfo/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-personalinfo-01.png');?>" class="tooltip"
								alt="Personal Info" title="Personal Info"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Resources/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-resources-01.png');?>" class="tooltip"
								alt="Resources" title="Resources"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Project/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-project-01.png');?>" class="tooltip"
								alt="Project" title="Project"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Export/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-export-01.png');?>" class="tooltip"
								alt="Export" title="Export"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Customize/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-customize-01.png');?>" class="tooltip"
								alt="Customize" title="Customize"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Achieve/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-archieve-01.png');?>" class="tooltip"
								alt="Achievement" title="Achievement"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Mentorexpert/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-mentorexpert-01.png');?>" class="tooltip"
								alt="Mentor Expert" title="Mentor Expert"></img>
						</a>
					</div>
					<div class="menu-item-wrapper">
						<a href="<?php echo $this->webroot; ?>Otherjstp/index?id=<?php echo $profile_id; ?>">
							<img src="<?php echo $this->Html->url('/img/icon-otherjstp-01.png');?>" class="tooltip"
								alt="Other JSTP" title="Other JSTP"></img>
						</a>
					</div>
				</div>
			</div>
		</div>
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
			<a href="http://www.nstda.or.th/" target="_blank"><img src="<?php echo $this->Html->url('/img/logo-nstd-01.png');?>"
				alt="สำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยีแห่งชาติ" title="สำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยีแห่งชาติ"></img></a>
			<a href="http://www2.kmutt.ac.th/" target="_blank"><img src="<?php echo $this->Html->url('/img/logo-kmutt-01.png');?>" 
				alt="มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าธนบุรี" title="มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าธนบุรี"></img></a>
			<a href="http://www.cmu.ac.th/" target="_blank"><img src="<?php echo $this->Html->url('/img/logo-cheangmai-01.png');?>" 
				alt="มหาวิทยาลัยเชียงใหม่" title="มหาวิทยาลัยเชียงใหม่"></img></a>
			<a href="http://www.ku.ac.th/" target="_blank"><img src="<?php echo $this->Html->url('/img/logo-kasetsart-01.png');?>" 
				alt="มหาวิทยาลัยเกษตรศาสตร์" title="มหาวิทยาลัยเกษตรศาสตร์"></img></a>
			<a href="http://www.sut.ac.th/" target="_blank"><img src="<?php echo $this->Html->url('/img/logo_sut-01.png');?>" 
				alt="มหาวิทยาลัยเทคโนโลยีสุรนารี" title="มหาวิทยาลัยเทคโนโลยีสุรนารี"></img></a>
			<a href="http://www.wu.ac.th/" target="_blank"><img src="<?php echo $this->Html->url('/img/logo-wu-01.png');?>" 
				alt="มหาวิทยาลัยวลัยลักษณ์" title="มหาวิทยาลัยวลัยลักษณ์"></img></a>
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

		jQuery('#btn-mainmenu').button().click(function(){
	    	  window.location.replace('<?php echo $this->Html->url('/Mainmenu'); ?>');
			});

	    function submitFormSearch(){
			jQuery('#form-search').submit();
	    }

	    <?php 
	    	if(!empty($message_alert)){ //$message_alert in AppController.beforeFilter()
		    	$message_alert = str_replace("'", "\\'", $message_alert);
		    	echo "jAlert('{$message_alert}');";
	    	}
	    ?>
	    
	</script>
</body>
</html>
