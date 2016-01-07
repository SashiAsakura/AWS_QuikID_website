<?php
/*error_reporting(E_ALL);
ini_set('display_errors',1);*/
include('db.php');

$fid = -1;
   function hextobinbackup($hexstr) 
    { 
        $n = strlen($hexstr); 
        $sbin="";   
        $i=0; 
        while($i<$n) 
        {       
            $a =substr($hexstr,$i,2);           
            $c = pack("H*",$a); 
            if ($i==0){$sbin=$c;} 
            else {$sbin.=$c;} 
            $i+=2; 
        } 
        return $sbin; 
    }

if (isset($_GET['id']))$fid = (int)$_GET['id'];

if ($fid!=-1){
	$arr = GetPressImage($fid);
	if (is_array($arr)){
		if (isset($arr['image'])){
			$img = hextobinbackup($arr['image']);
			header("Content-Disposition: attachment; filename=".urlencode($arr['imgname']));
			header("Content-Type: application/octet-stream");
			header("Content-Description: File Transfer");             
			header("Content-Length: " . strlen($img));
			echo $img;
			exit(0);
		}
	}
}
?>