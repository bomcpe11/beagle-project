<?php 
	echo $this->Html->css('personal_info.css');
?>
<style>
	#email_historiy{
		margin-left: 15.5%;
		list-style-type: none;
		background-color: #ffffff;
		border: 1px solid #000000;
	}
	#email_historiy > li{
		padding-left: 20px;
		line-height: 1.5em;
	}
	#email_historiy > li:hover{
		background-color: #459e00;
		cursor: pointer;
	}
</style>
<!-- ####################################################################################################### -->
<div class="container">
	<div class="section-content">
		<form id="form_send_email" name="form_send_email"  
				action="<?php echo $this->Html->url('/Emailsender/sendEmail'); ?>" 
				method="post" onsubmit="return sendEmail()">
			<table style="width: 100%;">
				<colgroup>
					<col style="width: 15%;">
					<col style="width: 75%;">
					<col style="width: 10%;">
				</colgroup>
				<tr>
					<td class="right label">* Send to :</td>
					<td>
						<input id="email_send_to" name="email_send_to" class="full-width" type="text"
							maxlength="50">
					</td>
					<td>
						<input class="full-width" type="submit" value="send">
					</td>
				</tr>
				<tr>
					<td class="right label">* Subject :</td>
					<td colspan="2">
						<input id="email_subject" name="email_subject" class="full-width" type="text"
							maxlength="100">
					</td>
				</tr>
				<tr>
					<td class="top right label">* Text :</td>
					<td colspan="2">
						<textarea id="email_text" name="email_text" rows="10" cols="80"></textarea>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="section-content" style="margin-top: 30px;">
		<p style="float: left;width: 15%;" class="right label">History :</p>
		<ul id="email_historiy">
			<?php 
				$countEmailHistory = count($emailHistory); 
				for( $i=0; $i<$countEmailHistory; $i++ ){ ?>
					<li onclick="openPopupEmailHistory('<?php echo $emailHistory[$i]['eh']['created_at']; ?>',
												'<?php echo $emailHistory[$i]['eh']['recipient']; ?>',
												'<?php echo $emailHistory[$i]['eh']['subject']; ?>',
												'<?php echo $emailHistory[$i]['eh']['content']; ?>')">
						<?php echo $emailHistory[$i]['eh']['recipient']
							.' : '
							.$emailHistory[$i]['eh']['subject']; ?>
					</li>
			<?php }?>
		</ul>
	</div>
</div>
<!-- ####################################################################################################### -->
<?php 
	include 'popup_email_history.ctp';
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		CKEDITOR.replace('email_text', {filebrowserImageUploadUrl : getURL('/activity/uploadImages')});

		$flg = '<?php echo $this->request->query('flg'); ?>';
		if( $flg ){
			$msg = '';
			if( $flg==='1' ){
				$msg = 'ดำเนินการส่ง Email เสร็จเรียบร้อย';
			}else{
				$msg = 'เกิดข้อผิดพลาดในการส่ง Email กรุณาติดต่อผู้ดูแลระบบ';
			}
			
			jAlert($msg, 
					function(){ //okFunc
					}, 
					function(){ //openFunc
					}, 
					function(){ //closeFunc
					}
			);
		}
	});
	/* ------------------------------------------------------------------------------------------------- */
	function sendEmail(){
		var sendTo = document.forms['form_send_email']['email_send_to'].value;
		var subject = document.forms['form_send_email']['email_send_to'].value;
		var text = CKEDITOR.instances.email_text.getData();

		if( !sendTo || !subject || !text ){
			jAlert('คุณกรอกข้อมูล ไม่ครบ', 
					function(){ //okFunc
					}, 
					function(){ //openFunc
					}, 
					function(){ //closeFunc
					}
			);
			
			return false;
		}
	}
</script>