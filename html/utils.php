<?php

function _GET($name,$defvalue){
	if (isset($_GET[$name]))return $_GET[$name];
	return $defvalue;
}

function _POST($name,$defvalue){
	if (isset($_POST[$name]))return $_POST[$name];
	return $defvalue;
}


function secureText($data)
{
	$data = trim($data);
	$data = addslashes($data);
	$data = htmlspecialchars($data);
	if (strlen($data) == 0){
		return null;
	}
	return $data;
}

function isDevMode() {
	if (isset($_SESSION['dev_mode']))return $_SESSION['dev_mode'];
	return false;
}

function setDevMode($val){
	$_SESSION['dev_mode'] = $val;
}

if( !function_exists('date_parse_from_format') ){
    function date_parse_from_format($format, $date) {
		$months = array(
			"January" => 1,
			"February" => 2,
			"March" => 3,
			"April" => 4,
			"May" => 5,
			"June" => 6,
			"July" => 7,
			"August" => 8,
			"September" => 9,
			"October" => 10,
			"November" => 11,
			"December" => 12
			);
        // reverse engineer date formats
        $keys = array(
            'Y' => array('year', '\d{4}'),              //Année sur 4 chiffres
            'y' => array('year', '\d{2}'),              //Année sur 2 chiffres
            'm' => array('month', '\d{2}'),             //Mois au format numérique, avec zéros initiaux
            'n' => array('month', '\d{1,2}'),           //Mois sans les zéros initiaux
            'M' => array('month', '[A-Z][a-z]{3}'),     //Mois, en trois lettres, en anglais
            'F' => array('month', '[A-Z][a-z]{2,8}'),   //Mois, textuel, version longue; en anglais, comme January ou December
            'd' => array('day', '\d{2}'),               //Jour du mois, sur deux chiffres (avec un zéro initial)
            'j' => array('day', '\d{1,2}'),             //Jour du mois sans les zéros initiaux
            'D' => array('day', '[A-Z][a-z]{2}'),       //Jour de la semaine, en trois lettres (et en anglais)
            'l' => array('day', '[A-Z][a-z]{6,9}'),     //Jour de la semaine, textuel, version longue, en anglais
            'u' => array('hour', '\d{1,6}'),            //Microsecondes
            'h' => array('hour', '\d{2}'),              //Heure, au format 12h, avec les zéros initiaux
            'H' => array('hour', '\d{2}'),              //Heure, au format 24h, avec les zéros initiaux
            'g' => array('hour', '\d{1,2}'),            //Heure, au format 12h, sans les zéros initiaux
            'G' => array('hour', '\d{1,2}'),            //Heure, au format 24h, sans les zéros initiaux
            'i' => array('minute', '\d{2}'),            //Minutes avec les zéros initiaux
            's' => array('second', '\d{2}')             //Secondes, avec zéros initiaux
        );

        // convert format string to regex
        $regex = '';
        $chars = str_split($format);
        foreach ( $chars AS $n => $char ) {
            $lastChar = isset($chars[$n-1]) ? $chars[$n-1] : '';
            $skipCurrent = '\\' == $lastChar;
            if ( !$skipCurrent && isset($keys[$char]) ) {
                $regex .= '(?P<'.$keys[$char][0].'>'.$keys[$char][1].')';
            }
            else if ( '\\' == $char ) {
                $regex .= $char;
            }
            else {
                $regex .= preg_quote($char);
            }
        }

        $dt = array();
        $dt['error_count'] = 0;
        // now try to match it
        if( preg_match('#^'.$regex.'$#', $date, $dt) ){
            foreach ( $dt AS $k => $v ){
                if ( is_int($k) ){
                    unset($dt[$k]);
                }
            }
            if( !checkdate($months[$dt['month']], $dt['day'], $dt['year']) ){
                $dt['error_count'] = 1;
            }
        }
        else {
            $dt['error_count'] = 1;
        }
        $dt['errors'] = array();
        $dt['fraction'] = '';
        $dt['warning_count'] = 0;
        $dt['warnings'] = array();
        $dt['is_localtime'] = 0;
        $dt['zone_type'] = 0;
        $dt['zone'] = 0;
        $dt['is_dst'] = '';
        return $dt;
    }
}

if (isset($_GET['dev_mode'])){
	setDevMode($_GET['dev_mode']);
}

?>