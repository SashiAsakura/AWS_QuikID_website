<?php
	//include('presslist.php');
	$title = "Careers";
	
	$template = file_get_contents('pages/careersdtls.tpl');

	function presentCarrierRow($id,$title){
		return '<h1>'.$title.'</h1>';
	}
	
		
	
	$careerlist = GetCareersList(0,1000);
	
	
	$finallist = '';
	
	foreach($careerlist as $key => $row)
	{
		if ($row['Flag']=='1'){
			$finallist.=presentCarrierRow($row['ID'],$row['Title']);
		}
	}

	$content = str_replace('@careers-details@', $finallist, $template);
	
?>