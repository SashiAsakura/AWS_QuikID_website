<?php

	function Article($id,$header,$author,$lead,$body,$date,$imgname){
	   $img = '';
	   if ($imgname!='')$img = "<img src=\"getblogfile.php?id=$id\" >";
	   $template ="
						<div class=\"blog-list\">
							<a href=\"?page=blogdtls&prid=$id\">
							$img
							<div class=\"blog-text\">
								<p class=\"blog-date\">".$date."</p>
								<h1 class=\"blog-title\">".$header."</h1>
								<h1 class=\"blog-author\">".$author."</h1>
								<div class=\"blog-lead\">".$lead."</div>
								<div id=\"article".$id."\">".$body."</div>
								<div class=\"blog-more icon-text\">Continue Reading</div>
							</div>
							</a>
						</div>
				  ";			  
			return $template;
	}

?>