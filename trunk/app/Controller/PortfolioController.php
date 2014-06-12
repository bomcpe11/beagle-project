<?php
App::import('Vendor', '/MPDF57/mpdf');
class PortfolioController extends AppController {

	public $names = "PortfolioController";
	public $uses = array('Profile', 'Education', 'Research', 'Award');
	public $layout = 'ajax_public';

	public function index(){
		$profileId = $this->request->query('id');
		//$this->log($profileId);
		
		/* Profile */
		$dataProfile = $this->Profile->getDataById($profileId);
		$arrayBirthday = array();
		$arrayBirthday = explode('-', $dataProfile[0]['profiles']['birthday']);	// <<< Y-m-d
		$birthdayTh = '';
		$birthdayTh .= intval($arrayBirthday[2]);
		switch ($arrayBirthday[1]) {
			case "01":	$birthdayTh .= " มกราคม"; break;
			case "02":	$birthdayTh .= " กุมภาพันธ์"; break;
			case "03":	$birthdayTh .= " มีนาคม"; break;
			case "04":	$birthdayTh .= " เมษายน"; break;
			case "05":	$birthdayTh .= " พฤษภาคม"; break;
			case "06":	$birthdayTh .= " มิถุนายน"; break;
			case "07":	$birthdayTh .= " กรกฏาคม"; break;
			case "08":	$birthdayTh .= " สิงหาคม"; break;
			case "09":	$birthdayTh .= " กันยายน"; break;
			case "10":	$birthdayTh .= " ตุลาคม"; break;
			case "11":	$birthdayTh .= " พฤศจิกายน"; break;
			default:	$birthdayTh .= " ธันวาคม";
		}
		$birthdayTh .= " พ.ศ. " . ( intval($arrayBirthday[0]) + 543 );
		//$this->log($dataProfile);
		
		/* Education */
		$dataEducation = $this->Education->getEducationByProfileId($dataProfile[0]['profiles']['id']);
		//$this->log($dataEducation);
		$countEducation = count($dataEducation);
		$htmlEducation = '<tr><td>ไม่พบข้อมูล</tr></td>';
		$htmlEducationTable = '<table class="table-data-border">
									<tr>
										<th>Qualification</th>
										<th>Year</th>
										<th>GPA.</th>
										<th>Academy</th>
									</tr>';
		if( $countEducation===0 ){
			$htmlEducationTable .= '<tr><td colspan="4" style="text-align: center;">ไม่พบข้อมูล</td></tr>';
		}
		for( $i=0;$i<$countEducation && $i<4;$i++ ){
			$splitEndYear = array();
			$splitEndYear = explode('-', $dataEducation[$i]['educations']['endyear']);	// yyyy-mm-dd
			if( empty($splitEndYear[0]) ){
				$endYearTh = '';
			}else{
				$endYearTh = intval($splitEndYear[0]) + 543;
			}
			
			if( $i==0 ){
				$htmlEducation = '';
			}
			$htmlEducation .= '<tr><td> - '.$dataEducation[$i]['educations']['name'].'</td></tr>';
			
			
			$htmlEducationTable .= '<tr>
										<td>'.$dataEducation[$i]['educations']['edutype'].'</td>
										<td>'.$endYearTh.'</td>
										<td>'.$dataEducation[$i]['educations']['gpa'].'</td>
										<td>'.$dataEducation[$i]['educations']['name'].'</td>
									</tr>';
		}
		$htmlEducationTable .= '</table>';
		
		/* Research */
		$dataResearch = $this->Research->getDataByProfileId($dataProfile[0]['profiles']['id']);
		//$this->log($dataResearch);
		$htmlResearchList = '<tr><td>ไม่พบข้อมูล</tr></td>';
		$htmlResearchTable = '<tr><td>ไม่พบข้อมูล</tr></td>';
		$countResearch = count($dataResearch);
		for( $i=0;$i<$countResearch;$i++ ){
			if( $i==0 ){
				$htmlResearchList = '';
				$htmlResearchTable = '';
			}
			$htmlResearchList .= '<tr><td>Project: '.$dataResearch[$i]['r']['name'].'</td></tr>';
			$htmlResearchList .= '<tr><td>Co-researcher: '.$dataResearch[$i]['r']['advisor'].'</td></tr>';
			$htmlResearchList .= '<tr><td>Sponsor: '.$dataResearch[$i]['r']['organization'].'</td></tr>';
			$htmlResearchList .= '<tr><td></td></tr>';
			$htmlResearchList .= '<tr><td></td></tr>';
			$htmlResearchList .= '<tr><td></td></tr>';
			
			if( $i==0 ){
				$htmlResearchTable .= '<table class="table-data">
										<tr>
											<td style="width: 40%;">
												<img style="width: 250px; height: 250px;" src="'.$dataResearch[$i]['r']['thumbpath'].'" alt="thumbpath"></img>
											</td>
											<td style="width: 60%;">
												Project: '.$dataResearch[$i]['r']['name'].'<br/>
												Co-researcher: '.$dataResearch[$i]['r']['advisor'].'<br/>
												Sponsor: '.$dataResearch[$i]['r']['organization'].'<br/>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												Detial:<br/>
												<p>'.$dataResearch[$i]['r']['detail'].'</p>
											</td>
										</tr>
									</table>';
			}else{
				$htmlResearchTable .= '<table class="table-data" style="margin-top: 60px;">
										<tr>
											<td style="width: 40%;">
												<img style="width: 250px; height: 250px;" src="'.$dataResearch[$i]['r']['thumbpath'].'" alt="thumbpath"></img>
											</td>
											<td style="width: 60%;">
												Project: '.$dataResearch[$i]['r']['name'].'<br/>
												Co-researcher: '.$dataResearch[$i]['r']['advisor'].'<br/>
												Sponsor: '.$dataResearch[$i]['r']['organization'].'<br/>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												Detial:<br/>
												<p>'.$dataResearch[$i]['r']['detail'].'</p>
											</td>
										</tr>
									</table>';
			}
		}
		
		/* Award */
		$dataAward = $this->Award->getDataByProfileId($dataProfile[0]['profiles']['id']);
		//$this->log($dataAward);
		$htmlAwardTable = '<tr><td>ไม่พบข้อมูล</tr></td>';
		$countAward = count($dataAward);
		for( $i=0;$i<$countAward;$i++ ){
			if( $i==0 ){
				$htmlAwardTable = '';
			}
			
			if( $i==0 ){
				$htmlAwardTable .= '<table class="table-data">
										<tr>
											<td style="width: 40%;">
												<img style="width: 250px; height: 250px;" src="'.$dataAward[$i]['d']['thumbpath'].'" alt="thumbpath"></img>
											</td>
											<td style="width: 60%;">
												Name: '.$dataAward[$i]['a']['name'].'<br/>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												Detial:<br/>
												<p>'.$dataAward[$i]['a']['detial'].'</p>
											</td>
										</tr>
									</table>';
			}else{
				$htmlAwardTable .= '<table class="table-data" style="margin-top: 60px;">
										<tr>
											<td style="width: 40%;">
												<img style="width: 250px; height: 250px;" src="'.$dataAward[$i]['d']['thumbpath'].'" alt="thumbpath"></img>
											</td>
											<td style="width: 60%;">
												Name: '.$dataAward[$i]['a']['name'].'<br/>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												Detial:<br/>
												<p>'.$dataAward[$i]['a']['detial'].'</p>
											</td>
										</tr>
									</table>';
			}
		}
		
		/* Page 1 */
		$page1 = '
				<style>
					body{
						background-image: url("'.Router::fullbaseUrl().$this->webroot.'img/pdf-profile-bg1-01.png");
						font-size: 14px;
					}
					h1,h2,h3,h4,h5,h6,hr,table{
						margin: 0;
						padding: 0;
					}
					h1{
						font-size: 44px;
					}
					h2{
						font-size: 40px;
					}
					h3{
						font-size: 36px;
					}
					h4{
						font-size: 32px;
					}
					h5{
						font-size: 28px;
					}
					h6{
						font-size: 24px;
					}
					p{
						text-indent: 10px;
					}
					img{
					}
					.page{	
						width: 21cm;
						height: 29.7cm;		
					}
					.table-data{
						width: 100%;
						color: #3D991F;
						table-layout: fixed;
					}
					.table-data-border{
						width: 100%;
						border-collapse: collapse;
					}
					.table-data-border tr:nth-child(even){
						background-color: #E5EFC6;
					}
					.table-data-border th{
						background-color: #A7C942;
					}
					.table-data-border th, .table-data-border td{
						border: 1px solid #98bf21;
					}
					.underline{
						height: 5px;
						margin-bottom: 10px;
						color: #3D991F;
					}
				</style>
				<body>
					<div name="page1" class="page">
						<div style="margin: 150px 0 0 300px;">
							<h3 style="color: #47B224;">JSPT OFFICIAL</h3>
							<h1 style="color: #333333;">PROFILE &
							PORTFOLIO</h1>
							<h4 style="color: #333333; font-weight: normal">Junior talented <span style="color: #47B224; font-weight: bold;">scientist</span></h4>
							<hr style="height: 5px; color: #14330A;">
				
							<h4 style="margin: 300px 0 0 0; text-align: center;">'.$dataProfile[0]['profiles']['nameth'].' '.$dataProfile[0]['profiles']['lastnameth'].'</h4>
						</div>
					</div>
				</body>';
		$mpdf=new mPDF('UTF-8');
		$mpdf->SetAutoFont();
		$mpdf->WriteHTML($page1);
		$mpdf->AddPage('P');
		
		/* Page 2 */
		$page2 = '
				<style>
					body{
						background-image: url("'.Router::fullbaseUrl().$this->webroot.'img/pdf-profile-bg2-01.png");
						font-size: 14px;
					}
					h1,h2,h3,h4,h5,h6,hr,table{
						margin: 0;
						padding: 0;
					}
					h1{
						font-size: 44px;
					}
					h2{
						font-size: 40px;
					}
					h3{
						font-size: 36px;
					}
					h4{
						font-size: 32px;
					}
					h5{
						font-size: 28px;
					}
					h6{
						font-size: 24px;
					}
					p{
						text-indent: 10px;
					}
					img{
					}
					.page{	
						width: 21cm;
						height: 29.7cm;		
					}
					.table-data{
						width: 100%;
						color: #3D991F;
						table-layout: fixed;
					}
					.table-data-border{
						width: 100%;
						border-collapse: collapse;
					}
					.table-data-border tr:nth-child(even){
						background-color: #E5EFC6;
					}
					.table-data-border th{
						background-color: #A7C942;
					}
					.table-data-border th, .table-data-border td{
						border: 1px solid #98bf21;
					}
					.underline{
						height: 5px;
						margin-bottom: 10px;
						color: #3D991F;
					}
				</style>
				<body>
					<div name="page2" class="page">
						<table class="table-data">
							<tr>
								<td style="width: 65%; vertical-align: top;">
									<table class="table-data">
										<tr>
											<td>
												<h5 style="color: #333333;">'.$dataProfile[0]['profiles']['nameth'].' '.$dataProfile[0]['profiles']['lastnameth'].'<h5>
											</td>
										</tr>
									</table>
									<hr class="underline">
									<table class="table-data">
										<tr><td><h6>Personal background</h6></td></tr>
										<tr><td>Nickname : '.$dataProfile[0]['profiles']['nickname'].'</td></tr>
										<tr><td>Address : '.$dataProfile[0]['profiles']['address'].'</td></tr>
										<tr><td>Nationality : '.$dataProfile[0]['profiles']['nationality'].'</td></tr>
										<tr><td>Birth date : '.$birthdayTh.'</td></tr>
										<tr><td>Religious : '.$dataProfile[0]['profiles']['religious'].'</td></tr>
										<tr><td>Email : '.$dataProfile[0]['profiles']['email'].'</td></tr>
									</table>
									<table class="table-data" style="margin-top: 30px;">
										<tr><td><h6>Educational background</h6></td></tr>
										'.$htmlEducation.'
									</table>
								</td>
								<td style="width: 35%; vertical-align: top;">
									<table class="table-data">
										<tr>
											<td>
												<img style="width: 250px; height: 250px;" src="'.$dataProfile[0]['profiles']['image_file'].'" alt="img profile"></img>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table class="table-data" style="margin-top: 30px;">
										<tr><td><h6>Project & Research background</h6></td></tr>
										'.$htmlResearchList.'
									</table>
								</td>
							</tr>
						</table>
					</div>
				</body>';
		$mpdf->WriteHTML($page2);
		$mpdf->AddPage('P');
		
		/* Page 3 */
		$page3 = '
				<style>
					body{
						background-image: url("'.Router::fullbaseUrl().$this->webroot.'img/pdf-profile-bg3-01.png");
						font-size: 14px;
					}
					h1,h2,h3,h4,h5,h6,hr,table{
						margin: 0;
						padding: 0;
					}
					h1{
						font-size: 44px;
					}
					h2{
						font-size: 40px;
					}
					h3{
						font-size: 36px;
					}
					h4{
						font-size: 32px;
					}
					h5{
						font-size: 28px;
					}
					h6{
						font-size: 24px;
					}
					p{
						text-indent: 10px;
					}
					img{
					}
					.page{	
						width: 21cm;
						height: 29.7cm;		
					}
					.table-data{
						width: 100%;
						color: #3D991F;
						table-layout: fixed;
					}
					.table-data-border{
						width: 100%;
						border-collapse: collapse;
					}
					.table-data-border tr:nth-child(even){
						background-color: #E5EFC6;
					}
					.table-data-border th{
						background-color: #A7C942;
					}
					.table-data-border th, .table-data-border td{
						border: 1px solid #98bf21;
					}
					.underline{
						height: 5px;
						margin-bottom: 10px;
						color: #3D991F;
					}
				</style>
				<body>
					<div name="page3" class="page">
						<table style="width: 100%;">
							<tr>
								<td>
									<h5 style="color: #333333;">Project & Research background<h5>
								</td>
							</tr>
						</table>
						<hr class="underline">
						'.$htmlResearchTable.'
					</div>
				</body>';
		$mpdf->WriteHTML($page3);
		$mpdf->AddPage('P');
		
		/* Page 4 */
		$page4 = '
				<style>
					body{
						background-image: url("'.Router::fullbaseUrl().$this->webroot.'img/pdf-profile-bg5-01.png");
						font-size: 14px;
					}
					h1,h2,h3,h4,h5,h6,hr,table{
						margin: 0;
						padding: 0;
					}
					h1{
						font-size: 44px;
					}
					h2{
						font-size: 40px;
					}
					h3{
						font-size: 36px;
					}
					h4{
						font-size: 32px;
					}
					h5{
						font-size: 28px;
					}
					h6{
						font-size: 24px;
					}
					p{
						text-indent: 10px;
					}
					img{
					}
					.page{	
						width: 21cm;
						height: 29.7cm;		
					}
					.table-data{
						width: 100%;
						color: #3D991F;
						table-layout: fixed;
					}
					.table-data-border{
						width: 100%;
						border-collapse: collapse;
					}
					.table-data-border tr:nth-child(even){
						background-color: #E5EFC6;
					}
					.table-data-border th{
						background-color: #A7C942;
					}
					.table-data-border th, .table-data-border td{
						border: 1px solid #98bf21;
					}
					.underline{
						height: 5px;
						margin-bottom: 10px;
						color: #3D991F;
					}
				</style>
				<body>
					<div name="page4" class="page">
						<table style="width: 100%;">
							<tr>
								<td>
									<h5 style="color: #333333;">Achievement<h5>
								</td>
							</tr>
						</table>
						<hr class="underline">
						'.$htmlAwardTable.'
					</div>
				</body>';
		$mpdf->WriteHTML($page4);
		$mpdf->AddPage('P');
		
		/* Page 5 */
		$page5 = '
				<style>
					body{
						background-image: url("'.Router::fullbaseUrl().$this->webroot.'img/pdf-profile-bg7-01.png");
						font-size: 14px;
					}
					h1,h2,h3,h4,h5,h6,hr,table{
						margin: 0;
						padding: 0;
					}
					h1{
						font-size: 44px;
					}
					h2{
						font-size: 40px;
					}
					h3{
						font-size: 36px;
					}
					h4{
						font-size: 32px;
					}
					h5{
						font-size: 28px;
					}
					h6{
						font-size: 24px;
					}
					p{
						text-indent: 10px;
					}
					img{
					}
					.page{	
						width: 21cm;
						height: 29.7cm;		
					}
					.table-data{
						width: 100%;
						color: #3D991F;
						table-layout: fixed;
					}
					.table-data-border{
						width: 100%;
						border-collapse: collapse;
					}
					.table-data-border tr:nth-child(even){
						background-color: #E5EFC6;
					}
					.table-data-border th{
						background-color: #A7C942;
					}
					.table-data-border th, .table-data-border td{
						border: 1px solid #98bf21;
					}
					.underline{
						height: 5px;
						margin-bottom: 10px;
						color: #3D991F;
					}
				</style>
				<body>
					<table style="width: 100%;">
							<tr>
								<td>
									<h5 style="color: #333333;">Education<h5>
								</td>
							</tr>
						</table>
						<hr class="underline">
						'.$htmlEducationTable.'
				</body>';
		$mpdf->WriteHTML($page5);
		$mpdf->Output();
		
		$this->set('message', '');
		$this->render('response');
		
	}
}
