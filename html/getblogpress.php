<?php
	include ('db.php');
	include ('utils.php');
/*	error_reporting(E_ALL);
	ini_set('display_errors',1);*/
	
	
	include('pages/bloglist.php');//here we generate the article preview

	$val  = 0;
	$mask = 0x2;
	$limit = 5;//number of articles on page
	$page_range = 5;//how many pages will be displayed below the articles

	$currentYear = date('Y');
	
	$year = (int)_GET('year',$currentYear);
	
	//file://localhost/.file/id=6571367.6813953/
	//$currentyear = date('Y');
	
	if ($year < '2012'){
		$year = '2012';
	}
	if ($year > $currentYear){
		$year = $currentYear;
	}

	$count = GetNewsCountForYear($year,BLOG,$mask,$val);
	$numberOfPages = (int)(($count+$limit-1)/$limit);
	
	
	$currentPage = (int)_GET('page',1);
	
	if ($currentPage < 1)$currentPage = 1;
	if ($currentPage >$numberOfPages)$currentPage = $numberOfPages;
	
	$start = ($currentPage-1)*$limit;
	
	$art_list = array();
	if ($numberOfPages>0)$art_list = GetPressListForYear($year,$start,$limit,BLOG,$mask,$val);
	
	$press = 'class="on"';
	$title = "Press & Media";
	
	$articles = '';
	foreach($art_list as $key => $row){
		$artDate = date('j, M Y', $row['date']);
		$articles.= Article($row['id'],$row['title'],$row['author'],$row['lead'],'',$artDate,$row['imgname']);
		//function Article($id,$header,$author,$lead,$body,$date,$imgname)
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
	  $articles.='<div class="blog-num"><ul class="pageNumbers text-center">';
	  if ($startPage!=1){
		  $articles.='<li><a href="#" id="selpage-'.$year.'-'.($startPage-1).'" class="blogPageSelBtns">Prev</a></li>';
	  }
	  $class = '';
	  for($i = $startPage; $i <= $maxPage;$i++){
		  if ($i == $currentPage)$class=' currentPage';else $class = '';
		  $articles.='<li><a href="#" id="selpage-'.$year.'-'.$i.'" class="blogPageSelBtns'.$class.'">'.$i.'</a></li>';
	  }
	  if ($maxPage!=$numberOfPages){
		  $articles.='<li><a href="#" id="selpage-'.$year.'-'.($maxPage+1).'" class="blogPageSelBtns">Next</a></li>';
	  }
	  $articles.='</ul></div>';
	}
	echo $articles;
?>