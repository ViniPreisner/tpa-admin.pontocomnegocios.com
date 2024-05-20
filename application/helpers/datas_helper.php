<?
function dataPTtoMySQL($data)
{
   return implode("-",array_reverse(explode("/",$data)));
}

function dataMySQLtoPT($data)
{
   return implode("/",array_reverse(explode("-",$data)));
}

function dataExtensoShort($data)
{
	return utf8_encode(strftime('%d %B/%Y', strtotime($data)));
}
function dataExtensoShortMonth($data)
{
	return utf8_encode(strftime('%B/%Y', strtotime($data)));
}
?>