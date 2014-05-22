<?php
	//print_r($objuser);
?>

<ul class="main-menu">
	<a href="<?php echo $this->Html->url('/PersonalInfo/index?id='.$objuser['id']);?>"><li id="menu-personal-info" class="active"><div class="caption">Personal Info</div></li></a>
	<a href="<?php echo $this->Html->url('/Project/index?id='.$objuser['id']);?>"><li id="menu-project" class="active"><div class="caption">Project/Research</div></li></a>
	<li></li>
	<li id="menu-resources" class="active"><div class="caption">Resources</div></li>
	<li></li>
	<li id="menu-utility" class="active"></li> <!-- Utilitiy -->
	<li></li>
	<li></li>
	<li></li>
	<a href="<?php echo $this->Html->url('/Customize');?>"><li id="menu-customize" class="active"><div class="caption">Customize</div></li></a>
	<li></li>
	<li id="menu-export" class="active"><div class="caption">Export</div></li>
	<li></li>
	<li></li>
	<li id="menu-mentor" class="active"><div class="caption">Mentor & Expert</div></li>
	<a href="<?php echo $this->Html->url('/Otherjstp');?>"><li id="menu-otherjstp" class="active"><div class="caption">Other JSTP</div></li></a>
	<a href="<?php echo $this->Html->url('/Achieve/index?id='.$objuser['id']);?>"><li id="menu-achieve" class="active"><div class="caption">Achieve</div></li></a>
	<li></li>
	<a href="<?php echo (empty($currentActivity[0]['activities']['name'])?'#':$this->Html->url('/Activity?id='.$currentActivity[0]['activities']['id'])); ?>"><li id="menu-activity" class="active">
		<div class="current-activity">
		<?php if(count($currentActivity)>0){ ?>
			<h2 style="white-space:nowrap;" ><?php echo $currentActivity[0]['activities']['name']; ?></h2>
			<div><?php echo $currentActivity[0]['activities']['startdtm']; ?> - <?php echo $currentActivity[0]['activities']['enddtm']; ?></div>
			<div style="text-indent: 25px;word-wrap: break-word;margin: 5px 0 0 0;"><?php echo $currentActivity[0]['activities']['shortdesc']; ?></div>
		<?php } ?>
		</div>
		<div class="showall-activity">
			<a href="<?php echo $this->Html->url('/Activitylist');?>"><img src="<?php echo $this->Html->url('/img/menu_activity.png');?>" style="margin: 45px 0 0 0;cursor:pointer;" /></a>
		</div>
	</li></a> <!-- Activity -->
</ul>

<script type="text/javascript">
// 	jQuery(function(){
		
// 	});


	jQuery('ul.main-menu li.active').hover(function(){jQuery(this).addClass('hover');}, function(){jQuery(this).removeClass('hover');});
</script>