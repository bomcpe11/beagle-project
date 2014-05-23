<?php 
	echo $this->Html->css('/js/jquery.imgareaselect/css/imgareaselect-default');

	/* JavaScript */
	echo $this->Html->script('jquery.imgareaselect/scripts/jquery.imgareaselect.pack');

?>

<script type="text/javascript">
	var g_imgCropper = null;
	jQuery(document).ready(function () {
		g_imgCropper = jQuery('img#photo').imgAreaSelect({
	    	aspectRatio: '1:1',
	        handles: true,
	        instance: true,
	        x1: 149, y1: 26, x2: 330, y2: 207,
	        persistent: true
	    });
	});

	function submitImageCrop(){
// 		console.log(g_imgCropper.getSelection());
		//getSelection
	}

	function submit_crop(){
		var raw_imgPath = '<?php echo $raw_imgPath; ?>';
		var dataname = '<?php echo $dataname; ?>';
		var dataid = '<?php echo $dataid; ?>';
		var cropInfo = g_imgCropper.getSelection();

		// validate imgDesc
		loading();
		jQuery.post('<?php echo $this->Html->url('/Achieve/ajax_crop'); ?>'
			,{imgpath: raw_imgPath
					,dataname: dataname
					,dataid: dataid
					,cropInfo: cropInfo
				}
			,function(data){
// 				console.log(data);
				unloading();
				jAlert(data.message
						, function(){ 
							if( data.status ){
								window.location.replace('<?php echo $this->Html->url('/Achieve/index?id='.$objuser['id']); ?>');
							}
						}//okFunc	
						, function(){ 
						}//openFunc
						, function(){ 		
						}//closeFunc
				);
			}
			,'json');
		
	}
</script>
<div style="text-align: center;">
	<img id="photo" src="<?php echo $this->Html->url('/'.$imgPath); ?>" />

</div>

<div class="input" style="color: white;text-align:center;margin:10px 0 0 0;">
<input type="button" value="บันทึก" onclick="submit_crop();" />
</div>