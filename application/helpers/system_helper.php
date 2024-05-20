<?php

function printr($array = array(), $var_dump = false)
{
	if($var_dump){
		var_dump($array);
		print '<br /><br />';
	}

	print '<pre>';
		print_r($array);
	print '</pre>';
	die();
}

function dd($array =array(), $var_dump = false)
{
	printr($array, $var_dump);
}

function only_numbers($string = '')
{
	return preg_replace('/\D/', '', $string);
}

function segment2Id($value = false)
{
	$data = array(
		1 => "Biscoito",
		2 => "Padaria",
		3 => "Outros",
		4 => "Sazonais",
	);

	if($value){
		return array_search($value, $data);
	}

	return $data;
}

function GetPost()
{
	$data = @file_get_contents('php://input');

	/* Processa os POST*/
	if(isset($data)){
		$data = json_decode($data);
		if(!empty($data)){
			foreach($data as $key=>$val){
				if( !isset($_POST[$key])){
					$_POST[$key] = $val;
				}
			}
		}
	}
}

function dispatchError_check($type, $error, $post, $version=false, $promoter_id = false)
{
	header("Content-Type: text/json");
	
	
	$post['area'] = $error;

    savePost($type, 'dispatchError - '.$post['area'], $post['promoter_id'], $post);

    if(is_array($error)){

        /* Verificar se da o erro certo */
        $error = array_merge(array('status' => false), $error);

        die(json_encode($error));
    }

    die(json_encode(array('status' => false, 'app_version'=>$version, 'msg' => $error)));
}

function dispatchError($error, $codigo=200)
{	
	http_response_code($codigo);
	
	header("Content-Type: text/json");
	
	if(is_array($error)){

		/* Verificar se da o erro certo */
		$error = array_merge(array('status' => false), $error);

		die(json_encode($error));
	}

	die(json_encode(array('status' => false, 'msg' => $error)));
}

function dispatchSuccess($arr)
{	
	header("Content-Type: text/json");

	if(is_array($arr)){

		$arr = array_merge(array('status' => true), $arr);

		die(json_encode($arr));
	}

	die(json_encode(array('status'	=> true, 'msg' => $arr)));
}

function checkParameter($id)
{
	if(isset($_POST[$id]) && $_POST[$id] !=null ){
		return true ;
	}
	
	dispatchError("Parametro ".$id." não encontrado ou inválido.");
}


function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function savePost($type, $area, $id, $dados)
{
	$dados['area']          = $area;
    $dados['ip_usuario']    = get_client_ip();

	$dir = getcwd().'/application/logs/';

	if(is_array($dados)){
		$dados = print_r($dados, true);
	}

	if(!is_writable($dir)){
		@chmod($dir, 0777);
	}

	if(!is_writable($dir)){
		return true;
	}

	$verify = strstr($area, "login");

	if($verify == true){
		$type = $type."_cnpj";
	}

	// $file = $dir.$area."_".$id.".txt";
	$file = $dir.$type."_".$id.".txt";

	if(!file_exists($file)){
		$fop = fopen($file,"w");
	}

	file_put_contents($file, PHP_EOL.date("d/m/Y - H:i:s")." : ", FILE_APPEND);
	file_put_contents($file, $dados, FILE_APPEND);
}