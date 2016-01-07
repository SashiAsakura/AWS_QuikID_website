<?php
function CreateNews($lnk,$img,$alt,$title,$date){
	$frm = 
	'<div class="col-md-4 col-sm-12 news-item">
		<a href="'.$lnk.'" class="news-link">
		    <div class="news-hover">
		        <div class="news-hover-content">
		            <i class="fa fa-chevron-right fa-2x"> Read More</i>
		        </div>
		    </div>
		    <img src="'.$img.'" class="img-responsive" alt="'.$alt.'">
		</a>
		<div class="news-caption">
			<p class="news-date">'.$date.'</p>
		    <p>'.$title.'</p>		
		</div>
	</div>';
    return $frm;
}            
 //GetPressListWithFlags($year,$first,$count,$flags)
 //(y is how many items on page)
 //you want to ask let's say for N-th page, so you need to set first = N*Y and of course page is zero based so the first page is 0, the second 1 etc.
 
 
 $pressList1 = GetPressListWithFlags(date('Y'),0,3,1); //first page has Y = 3, but the N = 0
 $pressList2 = GetPressListWithFlags(date('Y'),3,3,1); //N = 1, first = N*3 = 3
 $newslist1 = '';
 foreach($pressList1 as $key => $val){
    $artdate = date('j, M Y', $val['date']);
    $img = 'getfile.php?id='.$val['id'];
	if ($val['source']==NEWS)$lnk = 'index.php?page=pressdtls&prid='.$val['id'];
	if ($val['source']==BLOG)$lnk = 'index.php?page=blogdtls&prid='.$val['id'];
	$newslist1.=CreateNews($lnk,$img,$val['imgalt'],$val['title'],$artdate); 
 }
 $newslist2 = '';
 foreach($pressList2 as $key => $val){
    $artdate = date('j, M Y', $val['date']);
    $img = 'getfile.php?id='.$val['id'];
    $lnk = 'index.php?page=pressdtls&prid='.$val['id'];
	$newslist2.=CreateNews($lnk,$img,$val['imgalt'],$val['title'],$artdate); 
 } 
 

 $title   = 'FusionPipe Software Solutions';
 $content = file_get_contents('pages/default.tpl.tst');
 $content = str_replace('@NEWSP1@',$newslist1,$content);
 $content = str_replace('@NEWSP2@',$newslist2,$content);
 $content = $content;
?>