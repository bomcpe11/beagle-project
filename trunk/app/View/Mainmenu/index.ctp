<?php
	//print_r($objuser);
?>

<ul class="main-menu">
	<a href="<?php echo $this->Html->url('/PersonalInfo/index?id='.$objuser['id']);?>"><li id="menu-personal-info" class="active"><div class="caption">Personal Info</div></li></a>
	<li id="menu-project" class="active"><div class="caption">Project/Research</div></li>
	<li></li>
	<li id="menu-resources" class="active"><div class="caption">Resources</div></li>
	<li></li>
	<li></li>
	<li></li>
	<a href="<?php echo $this->Html->url('/Customize');?>"><li id="menu-customize" class="active"><div class="caption">Customize</div></li></a>
	<li></li>
	<li id="menu-export" class="active"><div class="caption">Export</div></li>
	<li id="menu-mentor" class="active"><div class="caption">Mentor & Expert</div></li>
	<li id="menu-otherjstp" class="active"><div class="caption">Other JSTP</div></li>
	<li id="menu-achieve" class="active"><div class="caption">Achieve</div></li>
</ul>

<script type="text/javascript">
// 	jQuery(function(){
		
// 	});


	jQuery('ul.main-menu li.active').hover(function(){jQuery(this).addClass('hover');}, function(){jQuery(this).removeClass('hover');});
</script>