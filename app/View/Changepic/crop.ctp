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
	        instance: true
	    });
	});

	function submitImageCrop(){
		console.log(g_imgCropper.getSelection());
		//getSelection
	}
</script>

<img id="photo" src="<?php echo $this->Html->url('/'.$imgPath); ?>" />