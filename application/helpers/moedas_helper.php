<?
function BRLToMySQL($data){
	$data = str_replace('.','',$data);
	$data = str_replace(',','.',$data);
	$data = str_replace(' ','',$data);
	$data = str_replace('R$','',$data);
	return $data;
}
?>