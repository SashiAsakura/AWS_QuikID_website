<?php

	function Article($id,$header,$lead,$body,$date){
			 
	   $template ="<div class=\"article-list text-center\">
	   				<a href=\"?page=pressdtls&prid=$id\">		          
			          <h3 class=\"article-title\">".$header."</h3>
					  <p class=\"article-date\">".$date."</p>
					  <div class=\"article-lead\">".$lead."</div>
			          <div id=\"article".$id."\">".$body."</div>
			         </a>
				  </div>
				  ";			  
			return $template;
	}

?>