<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{

		$this->data['body_class'] = '';
		$this->data['body_id'] = 'login';
		$this->data['mn_home_class'] = 'active';
		$this->data['nav_class'] = 'navbar-transparent';

		$this->data['title'] = '';
				
		// extra css
		$this->data['extra_css'] = array();	

		$this->data['head'] = $this->load->view('head', $this->data, TRUE);

		$this->data['content'] = $this->load->view('content/login', $this->data, TRUE);

		$this->data['extra_scripts'] = array();
		$this->data['scripts'] = $this->load->view('js/scripts', $this->data, TRUE);
				
		$this->load->view('page-blank', $this->data);

	}

	public function auth() {


        $email = $this->input->post('frmEmail');
        $senha = $this->input->post('frmPass');
        
        $this->load->model('login_model','lm');

        $usr = $this->lm->auth($email,md5($senha));
        
        if($usr){ 
            $this->session->set_userdata("userName", $usr["userName"]); 
            $this->session->set_userdata("userType", $usr["userType"]); 
            $this->session->set_userdata("userId", $usr["userId"]);
            $this->session->set_userdata("loggedin", true);
            //$this->permissoes();
            redirect(base_url()."home");
        } else {
            $this->session->set_userdata("loggedin", false);
            redirect(base_url().'login');
        }
    }
    
    public function logout(){

        $this->session->unset_userdata("userName");
        $this->session->unset_userdata("userType");
        $this->session->unset_userdata("userId");
        $this->session->set_userdata("loggedin", false);

        redirect(base_url());  
    }
    
    public function permissoes(){
        $this->load->model('model');
        $m = $this->model;
        $acessos = $m->selectAcessosCargoId($this->session->userdata("IdCargo"));
        foreach($acessos as $ac){
            $this->permissoesSession($ac->cd_modulo, $ac->cd_insert ,$ac->cd_read ,$ac->cd_update ,$ac->cd_delete);
        }
    }

    public function permissoesSession($modulo,$create,$read,$update,$delete){
        $this->load->model('model');
        $moduloArray = array($modulo,$create,$read,$update,$delete);
        $this->session->set_userdata("modulo".$modulo."", $moduloArray);
    }
}
