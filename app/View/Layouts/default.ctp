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

$cakeDescription = __d('cake_dev', 'Jstp hub ');
?><!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
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
	});

	//-------------------------------------------------------------------------------------------------
	function changePage(path){
		var link = "";
		
		switch(path)
		{
		case "Profile":
		  link = '<?php echo Router::url(array("controller"=>"Profile","action"=>"index"));?>'
		  break;
		case "Changepic":
		  link = '<?php echo Router::url(array("controller"=>"Changepic","action"=>"index"));?>'
		  break;
		case "Changepwd":
			  link = '<?php echo Router::url(array("controller"=>"Changepwd","action"=>"index"));?>'
			  break;
		case "Psearch":
			  link = '<?php echo Router::url(array("controller"=>"Psearch","action"=>"index"));?>'
			  break;
		case "Export":
			  link = '<?php echo Router::url(array("controller"=>"Export","action"=>"index"));?>'
			  break;		  			    
		default:
		  link = '<?php echo Router::url(array("controller"=>"Welcome","action"=>"index"));?>'
		}
		
		jQuery.ajax({
	           dataType: "html",
	           type: "POST",
	           evalScripts: true,
	           url: link,
	           data: ({type:'original'}),
	           success: function (data, textStatus){
	        	   jQuery("#layout").html();
	        	   jQuery("#layout").html(data);

	           }
	       });
	}       
	//-------------------------------------------------------------------------------------------------
</script>

</head>
<div id="layout">
<body>
	<div id="layout-container">
		<div id="layout-header">
			<h1>Header</h1>
		</div>
<div id="layout-body">
		    <table border="1" width="100%" >
		       <tr valign="top">
		          <!--profile-menu -->
		          <td width="20%">
		          
		                 <center>
		                    <a>
		                     	<?php if(isset($position) && !empty($position)){
		                     	        echo $position;
		                     	      }else{
  										echo $titleth;
  									  }
								?>
		                        <?php echo $nameth; ?>&nbsp;&nbsp;<?php echo $lastnameth; ?>
		                    </a>
		                 </center>
		                 
		                 </br>
		                 <div id="profile-container">
		                    </br>
		                    <div id="profile-picture">
		                        <img width="150px" height="150px"  src="<?php echo $image_file; ?>">
		                    </div>
		                     <center><a><?php echo $image_desc; ?></a></center>
		                 </div>
		                 </br>
		                 
		                 <div id="profile-desc">
		                     <a class="label">Username : <?php echo $login; ?></a> </br>
		                     <a class="label"> เข้าระบบล่าสุด :  <?php echo $last_login_at; ?></a>
		                 </div>
		                 </br>
		                 
		                 <!--layout-menu -->
		                 <div id="link-menu">
		                     <a><b>เมนู</b></a><br>
		                     &nbsp;&nbsp;<a style="cursor: pointer;" class="label" id="gotoProfile">ข้อมูลส่วนตัว </a><br>
		                     &nbsp;&nbsp;<a style="cursor: pointer;" class="label" id="gotoChangePic" >เปลี่ยนรูปประจำตัว</a><br>
		                     &nbsp;&nbsp;<a style="cursor: pointer;" class="label" id="gotoChangePwd">แก้ไขรหัสผ่าน</a><br>
		                     &nbsp;&nbsp;<a style="cursor: pointer;" class="label" id="gotoPsearch">ค้นหาบุคคล</a><br>
		                     &nbsp;&nbsp;<a style="cursor: pointer;" class="label" id="gotoExport" >ส่งออกข้อมูล</a><br>
		                                                                        
		                 </div>
		                 </br>
		          </td>
		          
		          <!--layout-content -->
		          <td>   <a><?php echo $page_title ?></a>
		                 <hr>
		          		 <div id="layout-content">
                           <?php //echo $this->Session->flash(); ?>
                           <?php echo $this->fetch('content'); ?>
		                 </div>
		          </td>
		       </tr>
		    </table>
		</div>
	</div>
		<div id="layout-footer">
			<h1>footer</h1>
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
