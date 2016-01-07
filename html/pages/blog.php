<?php


include('bloglist.php');//here we generate the article preview




/*
function GetNewsCountForYear($year);

function GetPressListForYear($year,$first,$count);
*/

	
	$limit = 5;//number of articles on page
	$start = 0;// temporary
	$page_range = 5;
	$currentYear = date('Y');

	$blog = 'class="on"';
	$title = "Blog";
	
	$val   = 0;
	$mask  = 0x2;

	$press_tpl = file_get_contents('pages/blog.tpl');

	$count = GetNewsCountForYear($currentYear,BLOG,$mask,$val);
	if ($count==0)$currentYear--;
	$numberOfPages = (int)(($count+$limit-1)/$limit);
	
	$articles = '';
	$article_lst = GetPressListForYear($currentYear,$start,$limit,BLOG,$mask,$val);	
	// store the record of the "example" table into $row
	foreach($article_lst as $key => $row){
		$artDate = date('M j, Y', $row['date']);
		$articles.= Article($row['id'],$row['title'],$row['author'],$row['lead'],'',$artDate,$row['imgname']);
		//function Article($id,$header,$author,$lead,$body,$date,$imgname)
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
		$articles.='<div class="blog-num"><ul class="pageNumbers text-center">';
		if ($startPage!=1){
			$articles.='<li><a href="#" id="selpage-'.$currentYear.'-'.($startPage-1).'" class="blogPageSelBtns">Prev</a></li>';
		}
		$class = '';
		for($i = $startPage; $i <= $maxPage;$i++){
			if ($i == $currentPage)$class=' currentPage';else $class = '';
			$articles.='<li><a href="#" id="selpage-'.$currentYear.'-'.$i.'" class="blogPageSelBtns'.$class.'">'.$i.'</a></li>';
		}
		if ($maxPage!=$numberOfPages){
			$articles.='<li><a href="#" id="selpage-'.$currentYear.'-'.($maxPage+1).'" class="blogPageSelBtns">Next</a></li>';
		}
		$articles.='</ul></div>';
	}
	$content = str_replace('@ARTICLES@',$articles, $press_tpl);  
?>
