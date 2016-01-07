<?php

	$company = 'class="on"';
	$title = "About Us";
	$template = file_get_contents('pages/company.tpl');
	
	function presentCarrierRow($id,$title){
		return "<li>
		  		<div class=\"row\">
			  		<a href=\"?page=careersdtls&car=$id\">
				  		<div class=\"col-xs-12 col-sm-12 col-md-8\">$title</div>
				  		<div class=\"location col-xs-12 col-sm-12 col-md-4\">Vancouver</div>
				  	</a>
		  		</div>
			</li>";
			
	//return '<h1>'.$title.'</h1>';
	}
	
		
	
	$careerlist = GetCareersList(0,1000);
	
	
	$finallist = '<ul class="careers-list">';
	
	foreach($careerlist as $key => $row)
	{
		if ($row['Flag']=='1'){
			$finallist.=presentCarrierRow($row['ID'],$row['Title']);
		}
	}
	$finallist.= '</ul>';

	$content = str_replace('@careers-details@', $finallist, $template);

?>

<?php
 