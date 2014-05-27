<?php
	echo $this->Html->css('personal_info.css');
?>
<style>
	.resource-lst{
		margin: 20px 0 0 20px;
		list-style-type: none;
	}
	.resource-lst>li{
		padding: 10px 0;
	}
	.link-img{
		width: 85%;
		height: 85px;
	}
	.link-desc{
	}
</style>
<!-- ##################################################################################################### -->
<div class="container">
	<h2>Resources</h2>
	<ul class="resource-lst">
		<li>
			<a href="http://www.nstda.or.th/jstp" target="_blank">
				<img class="link-img" alt="header www.nstda.or.th"
					src="<?php echo $this->webroot;?>img/resources/header_nstda_or_th_mini.jpg"></img>
			</a>
			<p class="link-desc">
				<a href="http://www.nstda.or.th/jstp" target="_blank">เวปไซท์ ของ JSTP สวทช.(http://www.nstda.or.th/jstp)</a>
			</p>
		</li>
		<li>
			<a href="http://www.jstp.org" target="_blank">
				<img class="link-img" alt="header www.jstp.org"
					src="<?php echo $this->webroot;?>img/resources/header_jstp_org_mini.jpg"></img>
			</a>
			<p class="link-desc">
				<a href="http://www.jstp.org" target="_blank">เวบไซท์ของ JSTP ม.ต้น (http://www.jstp.org)</a>
			</p>
		</li>
		<li>
			<a href="http://jstp.wu.ac.th" target="_blank">
				<img class="link-img" alt="header jstp.wu.ac.th"
					src="<?php echo $this->webroot;?>img/resources/header_jstp_wu_ac_th_mini.jpg"></img>
			</a>
			<p class="link-desc">
				<a href="http://jstp.wu.ac.th" target="_blank">เวบไซท์ของ JSTP ม.ต้น ม.วลัยลักษณ์  (http://jstp.wu.ac.th)</a>
			</p>
		</li>
		<li>
			<a href="http://www.jstpmedia.org" target="_blank">
				<img class="link-img" alt="header www.jstpmedia.org"
					src="<?php echo $this->webroot;?>img/resources/header_jstpmedia_org_mini.jpg"></img>
			</a>
			<p class="link-desc">
				<a href="http://www.jstpmedia.org" target="_blank">เวบไซท์ของ JSTP Media (http://www.jstpmedia.org)</a>
			</p>
		</li>
	</ul>
</div>