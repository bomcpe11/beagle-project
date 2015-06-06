<?php
	//print_r($objuser);
?>

<ul class="main-menu">
	<a href="<?php echo $this->Html->url('/PersonalInfo/index?id='.$objuser['id']);?>"><li id="menu-personal-info" class="active"><div class="caption">Personal Info</div></li></a>
	<a href="<?php echo $this->Html->url('/Project/index?id='.$objuser['id']);?>"><li id="menu-project" class="active"><div class="caption">Project/Research</div></li></a>
	<li></li>
	<a href="<?php echo $this->Html->url('/Resources/index?id='.$objuser['id']);?>"><li id="menu-resources" class="active"><div class="caption">Resources</div></li></a>
	<li></li>
	<li id="menu-utility" class="active">
		<ul class="util-menu">
			<a href="<?php echo $this->Html->url('/Emailsender');?>"><li id="util-menu-email" class="active tooltip" title="Email"></li></a>
			<a href="<?php echo $this->Html->url('/Calendar');?>"><li id="util-menu-calendar" class="active tooltip" title="Calendar"></li></a>
			<a href="<?php echo $this->Html->url('/Webboard');?>"><li id="util-menu-webboard" class="active tooltip" title="Webboard"></li></a>
			<li id="util-menu-faq" class="active tooltip" title="FAQ"></li>
		</ul>
	</li> <!-- Utilitiy -->
	<li></li>
	<li></li>
	<li></li>
	<a href="<?php echo $this->Html->url('/Customize/index?id='.$objuser['id']);?>"><li id="menu-customize" class="active"><div class="caption">Customize</div></li></a>
	<li></li>
	<a href="<?php echo $this->Html->url('/Export/index?id='.$objuser['id']);?>"><li id="menu-export" class="active"><div class="caption">Export</div></li></a>
	<li></li>
	<li></li>
	<a href="<?php echo $this->Html->url('/Mentorexpert/index?id='.$objuser['id']);?>"><li id="menu-mentor" class="active"><div class="caption">Mentor & Expert</div></li></a>
	<a href="<?php echo $this->Html->url('/Otherjstp/index?id='.$objuser['id']);?>"><li id="menu-otherjstp" class="active"><div class="caption">Other JSTP</div></li></a>
	<a href="<?php echo $this->Html->url('/Achieve/index?id='.$objuser['id']);?>"><li id="menu-achieve" class="active"><div class="caption">Achievement</div></li></a>
	<li></li>
	
		<li id="menu-activity" class="active">
			<table>
			<tr>
			<td>
				<a href="<?php echo (empty($currentActivity[0]['activities']['name'])?'#':$this->Html->url('/Activity?id='.$currentActivity[0]['activities']['id'])); ?>">
				<div class="current-activity">
				<?php if(count($currentActivity)>0){ ?>
					<h2 style="white-space:nowrap;cursor:pointer;" ><?php echo $currentActivity[0]['activities']['name']; ?></h2>
					<div><?php echo $currentActivity[0]['activities']['startdtm']; ?> - <?php echo $currentActivity[0]['activities']['enddtm']; ?></div>
					<div style="text-indent: 25px;word-wrap: break-word;margin: 5px 0 0 0;"><?php echo $currentActivity[0]['activities']['shortdesc']; ?></div>
				<?php } ?>
				</div>
				</a>
			</td>
			<td>
				<?php if($isAdmin){ ?>
				<div class="showall-activity">
					<a href="<?php echo $this->Html->url('/Activitylist');?>"><img src="<?php echo $this->Html->url('/img/menu_activity.png');?>" style="cursor:pointer;" /></a>
				</div>
				<?php } ?>
			 </td></tr>
			 </table>
		</li>
</ul>

<script type="text/javascript">
// 	jQuery(function(){
		
// 	});


	jQuery('ul.main-menu li.active, ul.util-menu li.active').hover(function(){jQuery(this).addClass('hover');}, function(){jQuery(this).removeClass('hover');});
</script>