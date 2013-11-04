<?php echo $this->Html->css('profile.css');?>
<!-- ################################################################################### -->
<script type="text/javascript">
	function edit_profile() {
		var strHtml = "<div style='width:700px;'>\
							<div class='table'>\
							<ul>\
								<li>\
									<span class='single'>\
										<strong>ชื่อ-นามสกุล : </strong>\
										<input type='text' value='<?php echo $fullNameTh;?>'></input>\
									</span>\
								</li>\
								<li>\
									<span class='single'>\
										<strong>Name : </strong>\
										<input type='text' value='<?php echo $objuser['titleen'].' '.$objuser['nameeng'].' '.$objuser['lastnameeng'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span>\
										<strong>ชื่อเล่น : </strong>\
										<input type='text' value='<?php echo $objuser['nickname'];?>'></input>\
									</span>\
									<span>\
										<strong>รุ่น : </strong>\
										<input type='text' value='<?php echo $objuser['generation'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span>\
										<strong>วันเกิด : </strong>\
										<input type='text' value='<?php echo $birthday;?>'></input>\
									</span>\
									<span>\
										<strong>อายุ : </strong>\
										<input type='text' value='<?php echo $age;?>'></input>\
									</span>\
								</li>\
								<li>\
									<span>\
										<strong>สัญชาติ : </strong>\
										<input type='text' value='<?php echo $objuser['nationality'];?>'></input>\
									</span>\
									<span>\
										<strong>ศาสนา : </strong>\
										<input type='text' value='<?php echo $objuser['religious'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span>\
										<strong>สถานะภาพ : </strong>\
										<input type='text' value='<?php echo $objuser['socialstatus'];?>'></input>\
									</span>\
									<span>\
										<strong>สถานะภาพทางการศึกษา : </strong>\
										<input type='text' value='<?php echo $objuser['studystatus'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span class='single'>\
										<strong>ที่อยู่ : </strong>\
										<input style='width: 80%;' type='text' value='<?php echo $objuser['address'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span>\
										<strong>โทรศัพท์ : </strong>\
										<input type='text' value='<?php echo $objuser['telphone'];?>'></input>\
									</span>\
									<span>\
										<strong>โทรศัพท์มือถือ : </strong>\
										<input type='text' value='<?php echo $objuser['celphone'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span class='single'>\
										<strong>อีเมล์ : </strong>\
										<input type='text' value='<?php echo $objuser['email'];?>'></input>\
									</span>\
								</li>\
								<li>\
									<span class='single'>\
										<strong>Sosial Media : </strong>\
										<input type='text' value='<?php echo $objuser['blogaddress'];?>'></input>\
									</span>\
								</li>\
							</ul>\
						</div>\
					</div>";

		var buttons = [
		               {text: "บันทึก", click: function() {alert("save")}}
			       		];

		openPopupHtml("แก้ไขข้อมูลส่วนตัว", strHtml, buttons, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
		);
	}// edit_profile
</script>
<!-- ################################################################################### -->
<div class="container">
	<div class="section_profile">
		<div class="section_picture">
			<div class="picture">
				<img></img>
				<p>Profile Picture Description</p>
			</div>
		</div>
		<div class="section_content">
			<div class="table">
				<ul>
					<li>
						<span class="single">
							<strong>ชื่อ-นามสกุล : </strong>
							<p><?php echo $fullNameTh;?></p>
						</span>
					</li>
					<li>
						<span class="single">
							<strong>Name : </strong>
							<p><?php echo $objuser['titleen']." ".$objuser['nameeng']." ".$objuser['lastnameeng'];?></p>
						</span>
					</li>
					<li>
						<span>
							<strong>ชื่อเล่น : </strong>
							<p><?php echo $objuser['nickname'];?></p>
						</span>
						
						<span>
							<strong>รุ่น : </strong>
							<p><?php echo $objuser['generation'];?></p>
						</span>
					</li>
					<li>
						<span>
							<strong>วันเกิด : </strong>
							<p><?php echo $birthday;?></p>
						</span>
						
						<span>
							<strong>อายุ : </strong>
							<p><?php echo $age;?></p>
						</span>
					</li>
					<li>
						<span>
							<strong>สัญชาติ : </strong>
							<p><?php echo $objuser['nationality'];?></p>
						</span>
						
						<span>
							<strong>ศาสนา : </strong>
							<p><?php echo $objuser['religious'];?></p>
						</span>
					</li>
					<li>
						<span>
							<strong>สถานะภาพ : </strong>
							<p><?php echo $objuser['socialstatus'];?></p>
						</span>
						
						<span>
							<strong>สถานะภาพทางการศึกษา : </strong>
							<p><?php echo $objuser['studystatus'];?></p>
						</span>
					</li>
					<li>
						<span class="single">
							<strong>ที่อยู่ : </strong>
							<p><?php echo $objuser['address'];?></p>
						</span>
					</li>
					<li>
						<span>
							<strong>โทรศัพท์ : </strong>
							<p><?php echo $objuser['telphone'];?></p>
						</span>
						
						<span>
							<strong>โทรศัพท์มือถือ : </strong>
							<p><?php echo $objuser['celphone'];?></p>
						</span>
					</li>
					<li>
						<span class="single">
							<strong>อีเมล์ : </strong>
							<p><?php echo $objuser['email'];?></p>
						</span>
					</li>
					<li>
						<span class="single">
							<strong>Sosial Media : </strong>
							<p><?php echo $objuser['blogaddress'];?></p>
						</span>
					</li>
				</ul>
				<button onclick="javascript:edit_profile();">แก้ไขข้อมูลส่วนตัว</button>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<h1>ประวัติครอบครัว</h1>
	<div class="section_content">
		555
	</div>
</div>
<div class="container">
	<h1>ประวัติการศึกษา</h1>
</div>
<div class="container">
	<h1>ผลงานวิจัย</h1>
</div>
