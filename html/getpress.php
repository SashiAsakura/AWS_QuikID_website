<?php
	include ('db.php');
	include ('utils.php');
/*	error_reporting(E_ALL);
	ini_set('display_errors',1);
*/	
	
	include('pages/presslist.php');//here we generate the article preview

	
	$limit = 5;//number of articles on page
	$page_range = 5;//how many pages will be displayed below the articles

	$currentYear = date('Y');
	
	$year = (int)_GET('year',$currentYear);
	
	//$currentyear = date('Y');
	
	if ($year < '2012'){
		$year = '2012';
	}
	if ($year > $currentYear){
		$year = $currentYear;
	}
	$val = 0;
	$mask= 2;

	$count = GetNewsCountForYear($year,NEWS,$mask,$val);
	$numberOfPages = (int)(($count+$limit-1)/$limit);
	
	
	$currentPage = (int)_GET('page',1);
	
	if ($currentPage < 1)$currentPage = 1;
	if ($currentPage >$numberOfPages)$currentPage = $numberOfPages;
	
	$start = ($currentPage-1)*$limit;
	
	$art_list = array();
	if ($numberOfPages>0)$art_list = GetPressListForYear($year,$start,$limit,NEWS,$mask,$val);
	
	$press = 'class="on"';
	$title = "Press & Media";
	
	$articles = '';
	foreach($art_list as $key => $row){
		$artDate = date('M j, Y', $row['date']);
		$articles.= Article($row['id'],$row['title'],$row['lead'],'',$artDate);

	}
	
	
	//$currentPage = 1;
//	$numberOfPages = 16;
	
	$startPage = $currentPage - (int)($page_range/2);
	if ($startPage<1)$startPage = 1;
	$maxPage   = $startPage+$page_range-1;
	
	if ($maxPage>$numberOfPages){
		$maxPage = $numberOfPages;
		$startPage = $maxPage-$page_range+1;
		if ($startPage < 1)$startPage = 1;
	}
	
	if ($numberOfPages > 1){
		$articles.='<ul class="pageNumbers text-center">';
		if ($startPage!=1){
			$articles.='<li><a href="#" id="selpage-'.$year.'-'.($startPage-1).'" class="pageSelBtns">Prev</a></li>';
		}
		$class = '';
		for($i = $startPage; $i <= $maxPage;$i++){
			if ($i == $currentPage)$class=' currentPage';else $class = '';
			$articles.='<li><a href="#" id="selpage-'.$year.'-'.$i.'" class="pageSelBtns'.$class.'">'.$i.'</a></li>';
		}
		if ($maxPage!=$numberOfPages){
			$articles.='<li><a href="#" id="selpage-'.$year.'-'.($maxPage+1).'" class="pageSelBtns">Next</a></li>';
		}
		$articles.='</ul>';
	}
	echo $articles;
?>