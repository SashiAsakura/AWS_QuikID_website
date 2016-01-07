<?php


include('presslist.php');//here we generate the article preview




/*
function GetNewsCountForYear($year);

function GetPressListForYear($year,$first,$count);
*/

	
	$limit = 5;//number of articles on page
	$start = 0;// temporary
	$page_range = 5;
	$currentYear = date('Y');

	$press = 'class="on"';
	$title = "Press & Media";
	
	$mask = 0x2;//test mode
	$val  = 0;  //not set
	$press_tpl = file_get_contents('pages/press.tpl');

	$count = GetNewsCountForYear($currentYear,NEWS,$mask,$val);
	
	$numberOfPages = (int)(($count+$limit-1)/$limit);
	
	$articles = '';
	$article_lst = GetPressListForYear($currentYear,$start,$limit,NEWS,$mask,$val);	
	// store the record of the "example" table into $row
	foreach($article_lst as $key => $row){
		$artDate = date('M j, Y', $row['date']);
		$articles.= Article($row['id'],$row['title'],$row['lead'],'',$artDate);

	}
	
	
	$currentPage = 1;
	//$numberOfPages = 16;
	
	$startPage = $currentPage - (int)($page_range/2);
	if ($startPage<1)$startPage = 1;
	$maxPage   = $startPage+$page_range-1;
	
	if ($maxPage>$numberOfPages){
		$maxPage = $numberOfPages;
		$startPage = $maxPage-$page_range+1;
		if ($startPage < 1)$startPage = 1;
	}
	
	if ($numberOfPages>1){
		$articles.='<ul class="pageNumbers text-center">';
		if ($startPage!=1){
			$articles.='<li class="text-center"><a href="#" id="selpage-'.$currentYear.'-'.($startPage-1).'" class="pageSelBtns">Prev</a></li>';
		}
		$class = '';
		for($i = $startPage; $i <= $maxPage;$i++){
			if ($i == $currentPage)$class=' currentPage';else $class = '';
			$articles.='<li class="text-center"><a href="#" id="selpage-'.$currentYear.'-'.$i.'" class="pageSelBtns'.$class.'">'.$i.'</a></li>';
		}
		if ($maxPage!=$numberOfPages){
			$articles.='<li class="text-center"><a href="#" id="selpage-'.$currentYear.'-'.($maxPage+1).'" class="pageSelBtns">Next</a></li>';
		}
		$articles.='</ul>';
	}
	$content = str_replace('@ARTICLES@',$articles, $press_tpl);  
?>
