<div class="section-layout" style="width:97%">
	<table>
		<tr>
			<td><?php echo var_dump($dataProfile);?></td>
			<td></td>
		</tr>
		<tr style="text-align:center">
			<td>
				<input type="button" value="Approve" onclick="do_approve(<?php echo $dataProfile[0]['profiles']['id'];?>)"/>
				<input type="button" value="Back" onclick="go_back()"/>
			</td>
		</tr>
	</table>
</div>
<!-- ################################################################################################## -->
<script>
	jQuery(document).ready(function(){
		jQuery('input[type="button"]').button();
	});
	function do_approve(){
		alert('go approve');
	}
	function go_back(){
		var path = '<?php echo $this->Html->url('/Approve/index');?>';
		
		loading();
		window.location = path;
	}
</script>