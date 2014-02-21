<?php
class WebboardController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $names = 'WebboardController';
	public $uses = array('Webboard');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- WebboardController -> index ----');
		$this->setTitle('Webboard');
		
		$Per_Page = 2;
		$Page = @$this->request->query['Page'];
		if(!$Page){
			$Page=1;
		}
		//$xxx = 'xxx';
		
		$Prev_Page = $Page-1;
		$Next_Page = $Page+1;
		$Num_Rows=$this->Webboard->countAllRecord();
		
		$Page_Start = (($Per_Page*$Page)-$Per_Page);
		if($Num_Rows<=$Per_Page)
		{
			$Num_Pages =1;
		}
		else if(($Num_Rows % $Per_Page)==0)
		{
			$Num_Pages =($Num_Rows/$Per_Page) ;
		}
		else
		{
			$Num_Pages =($Num_Rows/$Per_Page)+1;
			$Num_Pages = (int)$Num_Pages;
		}
		
		
		$webboard_result = $this->Webboard->getWebboardsLimit($Page_Start , $Per_Page);
		//$this->log($webboard_result);

		$this->set('webboard_result', $webboard_result);
		$this->set('Prev_Page', $Prev_Page);
		$this->set('Next_Page', $Next_Page);
		$this->set('Num_Pages', $Num_Pages);
		$this->set('Num_Rows', $Num_Rows);
		$this->set('Page', $Page);
	}
	
}// WebboardController