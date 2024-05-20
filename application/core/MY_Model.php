<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    /**
    * ID de log para salvar retorno
    * @var int
    **/
    public $log_id = 0;

	
    public function __construct()
    {
        parent::__construct();
	
    }

	
    /* Funcoes para LOG */
    public final function save_log(){
        if (!empty($_POST)) {
            $agent = $this->agent->agent_string();
            
            $insert = [
                'client_id' => $this->input->post('client_id', 0),
                'route'         => $this->router->fetch_class()."/".$this->router->fetch_method() ,
                'agent'         => $this->agent->agent_string(),
                'post'          => print_r($_POST, TRUE),
                'get'           => print_r($_GET, TRUE),
                'headers'       => print_r($this->input->request_headers(), TRUE),
                'versao_app'    =>$this->input->post('app_versao', FALSE),
                'ip'            => get_client_ip(),
                'created_at'    => date("Y-m-d H:i:s")
            ];
            
            $this->db->insert('log_acessos', $insert);

            $this->log_id = $this->db->insert_id();
        }
    }
	
	

    public final function save_log_return($obj, $status = "success"){
        $update = [
            'return_status' => $status,
            'return_object' => print_r($obj, TRUE)
        ];

        $this->db->where(['id' => $this->log_id])->update('log_acessos', $update);
    }

    public final function dispatchSuccess($json){
        //$this->save_log_return($json);
        dispatchSuccess($json);
    }

    public final function dispatchError($json, $code=200){
        //$this->save_log_return($json, "error");
        dispatchError($json, $code);
    }

    public final function checkToken()
    {
        $products = [
            'marketingbr-digital',
            'mundial-info',
            'real-system',
            'telworking',
            'cadastros-online'
        ];

        $product_token = $this->input->post('access_token');

        foreach ($products as $product) {
            if (md5($product) == $product_token) {
                return $product;
            }
        }
        
        $this->dispatchError(['msg' => "Token invalido", 'token_valido' => false], 200);
    }

    /*
    public final function checkURL()
    {
        $products = [
            'marketingbr-digital',
            'mundial-info',
            'real-system',
            'telworking'
        ];

        $sites = [
            'https://marketingbrdigital.com.br',
            'https://mundialinfo.com.br',
            'https://www.realsystem.com.br',
            'https://telworking.com.br'
        ];

        $product_token = $this->input->post('access_token');

        foreach ($products as $key=>$product) {
            if (md5($product) == $product_token) {
                return $sites[$key];
            }
        }
        
        $this->dispatchError(['msg' => "Token invalido", 'token_valido' => false], 200);
    }
    */

}
