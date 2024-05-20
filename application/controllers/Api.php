<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

	function __construct()
	{
		parent::__construct();

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $this->load->database();
		$this->load->helper(array('url'));
        $this->load->library('pagination');

		setlocale(LC_MONETARY, 'pt_BR.UTF8');
		date_default_timezone_set('America/Sao_Paulo');
		

        $this->load->model('api_model', 'api');

		$this->data['userdata'] = $this->session->userdata();
	}

    /**
     * Constrói os dados da Home
     * @access public
     * @author Vinicius Donasci <>
     */
    public function home()
    {
        $this->api->home();
    }

    /**
     * Constrói os dados da Categoria
     * @access public
     * @author Vinicius Donasci <>
     */
    public function categoria()
    {
        $this->api->categoria();

    }

    /**
     * Constrói os dados do cliente
     * @access public
     * @author Vinicius Donasci <>
     */
    public function empresa()
    {
        $this->api->empresa();

    }

    /**
     * Constrói os dados da Busca
     * @access public
     * @author Vinicius Donasci <>
     */
    public function busca()
    {
        $this->api->busca();
    }

    /**
     * Envio de e-mail
     * @access public
     * @author Vinicius Donasci <>
     */
    public function contato()
    {
        $this->api->contato();
    }


    /**
     * json clientes
     * @access public
     * @author Vinicius Donasci <>
     */
    public function json_clientes($product_name)
    {
        $this->api->json_clientes($product_name);
    }


    /**
     * consulta negativados
     * @access public
     * @author Vinicius Donasci <>
     */
    public function negativados()
    {
        $this->api->negativados();
    }


}