<?
function asset_url(){
	return base_url().'assets/';
}
function secure_asset_url(){
	return secure_base_url().'assets/';
}
function products_img_url() {
	return base_url().'upload/imagem/crop/';
}
function product_img_url() {
	return base_url().'upload/imagem/';
}

function formatCnpjCpf($value)
{
	$cnpj_cpf = preg_replace("/\D/", '', $value);
	
	if (strlen($cnpj_cpf) === 11) {
		return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
	} 
	
	return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);

}

/*
* Verifica se um valor existe dentro de uma array multidimensional
* uso: echo in_array_r("valor", $b) ? 'found' : 'not found';
*/
function in_array_r($needle, $haystack, $strict = false) {
    if (is_array($haystack))
	{
		foreach ($haystack as $item) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
				return true;
			}
		}
	}
    return false;
}


/*
* Verifica se um valor existe dentro de uma array associativa
* uso: is_in_array($array, 'key', 'value');
*/
function is_in_array($array, $key, $key_value){
      $within_array = 'no';
      foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if( $within_array == 'yes' ){
                break;
            }
        } else {
                if( $v == $key_value && $k == $key ){
                        $within_array = 'yes';
                        break;
                }
        }
      }
      return $within_array;
}

	/**
	* Gera string randomica unica
	* Pesquisa no BD a existencia da chave na tabela short_keys
	* e gera string única e salva no bd
	* @param int $lenght
	*/
	function generateRandomString($length = 24, $caps=true, $numbers=true, $data=false) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		if ($caps)
		  $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		if ($numbers)
		  $characters .= '0123456789';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		
		if ($data) {
			$randomString = date("YmdHis").$randomString;
		}
		
		// verifica se existe a chave no bd
		while (isUniqueRandomString($randomString)) {
		  $randomString = '';
		  for ($i = 0; $i < $length; $i++) {
			  $randomString .= $characters[rand(0, strlen($characters) - 1)];
		  }
		}
		
		// salva a shortKey no bd
		return $randomString;
	}

	function saveRandomString($string)
	{
	    $CI = get_instance();
		$CI->load->model('Shortkeys_model','shortkeysModel');
		$CI->shortkeysModel->insert(array('name'=>$string));
		
	}
	
	
	function isUniqueRandomString($string)
	{
	    $CI = get_instance();
		$CI->load->model('Shortkeys_model','shortkeysModel');
		$_countRandomString = $CI->shortkeysModel->where('name',$string)->count_rows();
		if ($_countRandomString > 0)
		{
		  return true;
		} else {
		  return false;
		}
	}


	function updateShortKey($shortkey,$id_asset,$type_asset) {
	    $CI = get_instance();
		$CI->load->model('Shortkeys_model','shortkeysModel');
		$CI->shortkeysModel->where('name',$shortkey)->update(array('type_asset'=>$type_asset,'id_asset'=>$id_asset));
	}



	function deleteShortKey($shortkey,$id_asset) {
	    $CI = get_instance();
		$CI->load->model('Shortkeys_model','shortkeysModel');
		$CI->shortkeysModel->where(array('name'=>$tring,'id_asset'=>$id_asset))->delete();
	}


    function get_folder_shortkey($shortkey,$thumb=false) {
		$_folderPart = DIR_CDN_MEDIA_CLASSIFICADOS.substr($shortkey, 0, 8).'/'.substr($shortkey, 14, 1).'/'.substr($shortkey, 15, 1).'/'.substr($shortkey, 14, 6).'/';
		if ($thumb)
			$_folderPart .= 'thumbs/';
		return $_folderPart;
	}

    function get_url_shortkey($shortkey,$thumb=false) {
		$_folderPart = URL_CDN_MEDIA_CLASSIFICADOS.substr($shortkey, 0, 8).'/'.substr($shortkey, 14, 1).'/'.substr($shortkey, 15, 1).'/'.substr($shortkey, 14, 6).'/';
		if ($thumb)
			$_folderPart .= 'thumbs/';
		return $_folderPart;
	}

    function get_user_folder_shortkey($shortkey,$thumb=false) {
		$_folderPart = DIR_CDN_MEDIA_PERFIL.substr($shortkey, 0, 1).'/'.substr($shortkey, 1, 1).'/'.substr($shortkey, 0, 12).'/';
		if ($thumb)
			$_folderPart .= 'thumbs/';
		return $_folderPart;
	}

    function get_user_url_shortkey($shortkey,$thumb=false) {
		$_folderPart = URL_CDN_MEDIA_PERFIL.substr($shortkey, 0, 1).'/'.substr($shortkey, 1, 1).'/'.substr($shortkey, 0, 12).'/';
		if ($thumb)
			$_folderPart .= 'thumbs/';
		return $_folderPart;
	}

	function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
	
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);
	
	  // trim
	  $text = trim($text, '-');
	
	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);
	
	  // lowercase
	  $text = strtolower($text);
	
	  if (empty($text)) {
		return 'n-a';
	  }
	
	  return $text;
	}

	// Allows autoversioning of css and js files
	/**
	 *  Given a file, i.e. /css/base.css, replaces it with a string containing the
	 *  file's mtime, i.e. /css/base.1221534296.css.
	 *  
	 *  @param $file  The file to be loaded.  Must be an absolute path (i.e.
	 *                starting with slash).
	 */
	function auto_version($file) {
		
	  if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
		return $file;
	
	  $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
	  return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
	}


	function curl_get_contents($url)
	{
	  $ch = curl_init($url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}

?>