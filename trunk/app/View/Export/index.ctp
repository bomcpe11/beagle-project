<style type="text/css">
#frm-menu .btn{
	margin: 3px 0;
}
</style>
<h2 style="padding:5px;">Export</h2>

<div id="frm-menu" class="framecontainer" style="text-align:center;display:block;">
	<a class="btn" href="javascript:export_profile('<?php echo $objuser['id']; ?>')"/>ดาวน์โหลด Portfolio</a><br/>
	<?php if($isAdmin){ ?>
	<a class="btn" href="<?php echo $this->Html->url('/Export/allPersonalInfoes'); ?>">Export All Personal Infoes</a><br />
	<a class="btn" href="<?php echo $this->Html->url('/Export/allActivities'); ?>">Export All Activities</a><br />
	<?php } ?>
	<a class="btn" frmid="" onclick="window.location.replace('<?php echo $this->Html->url('/Mainmenu'); ?>');">Back to Main Menu</a><br />
	
</div>

<script type="text/javascript">
	jQuery('a.btn').button();

	function export_profile(profile_id){
		window.open('<?php echo $this->Html->url('/Portfolio/'); ?>?id='+profile_id);
	}
</script>


<div>
</div>

