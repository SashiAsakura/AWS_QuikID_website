<?php
$rowsperpage = 10;

$adminpage = 'on';

$action = _GET('action','');
$pressid= _GET('pressid',-1);
$pg   = _GET('pg',1);
if ($pg < 1)$pg = 1;


switch($action){
	case 'remove': RemoveNews($pressid);
}
$first = ($pg-1)*$rowsperpage;
$no = $first+1;
$articles = GetPressList($first,$rowsperpage,BLOG);

$content.='<section id="adm_container">
	<div class="container">';
$content.= '<p class="pressEdit-list">Total news: '.GetNewsCount(BLOG).'</p>';

$table = "<!--- start list of articles -->";
foreach($articles as $key => $row){
	$rowtpl = '<p class="pressEdit-list">@NO@: <a href="@EDITLINK@">@TITLE@</a> <a href="@DELLINK@">X</a></p>';
	
	if ($row['flags']==1)$nostr='*'.$no;else $nostr = $no;
	if ($row['flags']&2)$nostr='(T)'.$nostr;
	$rowhtml =str_replace("@NO@", $nostr, $rowtpl);
	$rowhtml =str_replace('@EDITLINK@', '?page=_blogaddedt&pressid='.$row['id'], $rowhtml);
	$rowhtml =str_replace('@DELLINK@', '?page=_bloglist&pressid='.$row['id'].'&action=remove', $rowhtml);
	$rowhtml =str_replace('@TITLE@', $row['title'], $rowhtml);
	$table.=$rowhtml;
	$no++;
}

$table.= "<!--- end list of articles -->";

//there are links to pages ;)

$totalpages = (int)((GetNewsCount(BLOG)+$rowsperpage-1)/$rowsperpage);

$pglinks = '<p class="pressEdit-pages">';
for ($i = 0; $i < $totalpages; $i++){
	$pglinks.='|<a href="?page=_bloglist&pg='.($i+1).'">'.($i+1).'</a>';
}
if ($totalpages>0)$pglinks.= '|</p>';
$content.= $table.$pglinks;
?>