<?
	function getTipoById($id)
	{
	    $CI = get_instance();
		$CI->load->model('Classificados_tipo_model','tipoModel');
		$_tipo = $CI->tipoModel->where('id',$id)->get();
		return $_tipo->name;
	}



?>