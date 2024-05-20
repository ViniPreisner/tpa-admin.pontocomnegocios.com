<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$data = date("Y-m-d");
        $hora = date("H:i");
	}

    public function auth($email, $senha){
        $this->db->where("user_email", $email);
        $this->db->where("user_password", $senha);
        $a = $this->db->get('users');
        if ($a->num_rows() > 0) {
            $data["userName"] = $a->row()->user_name;
            $data["userId"] = $a->row()->id;
            $data["userType"] = $a->row()->user_type;
            return $data;
        } else {
            return false;
        }
    }

}
?>