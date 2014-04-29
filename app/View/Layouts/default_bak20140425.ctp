<?php

//######### Check $_SESSION for user loged-in #############
if(isset($objuser) && !empty($objuser)){
	//TODO: it have objuser.
}else{
	//TODO: not found objuser, not loged-in., Redirect to LoginController
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

$cakeDescription = __d('cake_dev', 'My JSPT');
?><!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?> :
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//echo $this->Html->meta('icon');

		echo $this->Html->css('jquery/ui/south-street/jquery-ui-1.10.3.custom.min');
		echo $this->Html->css('loading');
		echo $this->Html->css('default');

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

<script type="text/javascript">
	jQuery.noConflict();
	G_WEB_ROOT = '<?php echo $this->webroot; ?>';
	
	jQuery(document).ready(function(){
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoProfile").click(function() {changePage("Profile");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoChangePic").click(function() {changePage("Changepic");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoChangePwd").click(function() {changePage("Changepwd");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoPsearch").click(function() {changePage("Psearch");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoExport").click(function() {changePage("Export");});
		//---------------------------------------------------------------------------------------------
		jQuery('#gotoApprove').click(function() {changePage("Approve");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoActivityList").click(function() {changePage("ActivityList");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoAsearch").click(function() {changePage("Asearch");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoLogout").click(function() {changePage("Logout");});
		//---------------------------------------------------------------------------------------------
		jQuery("#gotoWebboard").click(function() {changePage("Webboard");});
		//---------------------------------------------------------------------------------------------

		jQuery('input:button, input:submit').button();
	});

	//-------------------------------------------------------------------------------------------------
	function changePage(path){
		var link = "";

		switch(path)
		{
		case "Profile":
	      window.location = "<?php echo $this->Html->url('/Profile/index').'?id='.$objuser['id'];?>";
		  break;
		case "Changepic":
		  window.location = "<?php echo $this->Html->url('/Changepic/index');?>";
		  break;
		case "Changepwd":
		  window.location = "<?php echo $this->Html->url('/Changepwd/index');?>";
		  break;
		case "Psearch":
		  window.location = "<?php echo $this->Html->url('/Psearch/index');?>";	
		  break;
		case "Export":
		  window.location = "<?php echo $this->Html->url('/Export/index');?>";	
		  break;
		case "Approve":
		  window.location = "<?php echo $this->Html->url('/Approve/index');?>";	
		  break;
		case "ActivityList":
		  window.location = "<?php echo $this->Html->url('/Activitylist/index');?>";	
		  break;
		case "Asearch":
		  window.location = "<?php echo $this->Html->url('/Asearch/index');?>";	
		  break;
	    case "Webboard":
		  window.location = "<?php echo $this->Html->url('/Webboard/index');?>";	
		  break;	
	    case "Logout":
			  window.location = "<?php echo $this->Html->url('/Logout/index');?>";	
			  break;  		  			    
		default:
		  window.location = "<?php echo $this->Html->url('/');?>";	
		}
		
		/*jQuery.ajax({
	           dataType: "html",
	           type: "POST",
	           evalScripts: true,
	           url: link,
	           data: ({type:'original'}),
	           success: function (data, textStatus){
	        	   jQuery("#layout").html();
	        	   jQuery("#layout").html(data);

	           }
	       });*/
	}       
	//-------------------------------------------------------------------------------------------------
</script>

</head>
<div id="layout">
<body>
	<div id="layout-container">
		<div id="layout-header">
<!-- 			<h1>Header</h1> -->
		</div>
<div id="layout-body">
		    <table border="0" width="100%" ﻿cellpadding="0" cellspacing="0" >
		       <tr valign="top">
		          <!--profile-menu -->
		          <td width="20%" class="layout-sub-container1">
		          
		                 <center>
		                    <h4>
		                     	<?php if(isset($position) && !empty($position)){
		                     	        echo $position;
		                     	      }else{
  										echo $titleth;
  									  }
								?>
		                        <?php echo $nameth; ?>&nbsp;&nbsp;<?php echo $lastnameth; ?>
		                    </h4>
		                 </center>
		                 <div id="profile-container">
		                    </br>
		                    <div id="profile-picture">
		                        <img width="150px" height="150px"  src="<?php echo $this->webroot.$image_file; ?>">
		                    </div>
		                     <center><p><?php echo $image_desc; ?></p></center>
		                 </div>
		                 </br>
		                 
		                 <div id="profile-desc">
		                     <p>Username : <?php echo $login; ?></p>
		                     <p>เข้าระบบล่าสุด :  <?php echo $last_login_at; ?></p>
		                     <p>ปรับปรุงข้อมูลล่าสุด :  <?php echo $last_updated_at; ?></p>
		                 </div>
		                 <!--layout-menu -->
		                 <div id="link-menu">
		                     <h3 style="margin-top:20px; margin-left:0;">เมนู</h3>
			                     <a style="cursor: pointer;" class="menu" id="gotoProfile">ข้อมูลส่วนตัว </a>
			                     <a style="cursor: pointer;" class="menu" id="gotoChangePic" >เปลี่ยนรูปประจำตัว</a>
			                     <a style="cursor: pointer;" class="menu" id="gotoChangePwd">แก้ไขรหัสผ่าน</a>
			                     <a style="cursor: pointer;" class="menu" id="gotoPsearch">ค้นหาบุคคล</a>
			                     <a style="cursor: pointer;" class="menu" id="gotoExport" >ส่งออกข้อมูล</a>
			                     <a style="cursor: pointer;" class="menu" id="gotoWebboard" >Webboard</a>
			                   	 <?php if( $objuser['role']==='1' ){
			                   	 	echo "<a style=\"cursor: pointer;\" class=\"menu\" id=\"gotoApprove\">Approve</a>";
			                   	 }?>
		                     <h3 style="margin-top:20px; margin-left:0;">กิจกรรม</h3>
		                     	 <a style="cursor: pointer;" class="menu" id="gotoActivityList">ข้อมูลกิจกรรม </a>
		                     	 <a style="cursor: pointer;" class="menu" id="gotoAsearch">ค้นหากิจกรรม </a>  
		                     <h3 style="margin-top:20px; margin-left:0;">
		                     	<a style="cursor: pointer;" id="gotoLogout" >ออกจากระบบ</a>  
		                     </h3>                         
		                 </div>
		                 </br>
		          </td>
		          <td width="5"><div style="width:1px;height:1px;"></div></td>
		          <!--layout-content -->
		          <td class="layout-sub-container1" style="padding:0 10px 10px 10px;">   
			          <h2><?php echo $page_title ?></h2>
						<div id="layout-content">
							<?php echo $this->fetch('content'); ?>
						</div>
		          </td>
		       </tr>
		    </table>
		</div>
	</div>
		<div id="layout-footer">
			footer
		</div>
	</div>
	</br>
	<?php
		if(isset($footer_trace) && !empty($footer_trace)){
			?><div>####### FOOTER TRACE #######<br /><pre><?php print_r($footer_trace); ?></pre></div><?php
		}
	?>
	<div id="block-page" class="loading-unblock"><div id="block-page_hdn"></div></div>
	<div id="div_loading" class="loading-invisible">
	    &nbsp;
	    <table border="0" align="center">
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
	
</body>
</div>
</html>
