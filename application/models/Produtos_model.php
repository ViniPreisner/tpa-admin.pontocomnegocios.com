<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model
{

    public $total = 0;
	public $pages = 1;
	public $current = 1;
    public $links = '';

	public function __construct()
	{
		parent::__construct();
        $this->timestamp = date('Y-m-d H:i');
	}

	/**
	 * Retorna total de registros
	 */
    function selectAllItemsCount(){
        $this->db->select('COUNT(id) as total');
        $this->db->from('products');
        //$this->db->where('products.deleted_at', NULL); 
        $query = $this->db->get();
        return $query->row();
    }

	/**
	 * Lista todos os produtos
	 */
    function getAll($limit_per_page = false, $start_index = false, $count = false){

        // paginação
		if ($limit_per_page) {
            if ($start_index > 1) {
                $offset = ($start_index-1)*$limit_per_page;
            } else {
                $offset = 0;
            }
			$this->db->limit($limit_per_page, $offset);
		}

		/* Produtos */
        $this->db->select('*');
        $this->db->from('products');
        //$this->db->where('products.deleted_at', NULL); 
        $this->db->order_by('products.id','asc');
				
		$query = $this->db->get();
		$this->total = $query->num_rows();

		$items = $query->result();

        return $items;

    }

	/**
	 * Get item by id
	 */
    function getById($id,$fields = '*'){

		/* Produtos */
        $this->db->select($fields);
        $this->db->from('products');
        //$this->db->where('products.deleted_at', NULL); 
        $this->db->where('products.id', $id); 
        
        $query = $this->db->get();
        $item = $query->row();

        return $item;
    }

	/**
	 * Get item by code
	 */
    function getByCode($code,$fields = '*'){

		/* Produtos */
        $this->db->select($fields);
        $this->db->from('products');
        //$this->db->where('products.deleted_at', NULL); 
        $this->db->where('products.code', $code); 
        
        $query = $this->db->get();
        $item = $query->row();

        return $item;
    }

	public function insert($data){
        return $this->db->insert('products' , $data);
    }

	public function update($data,$id){
        $this->db->set($data);
        $this->db->where('id',$id);
        //$this->db->where('products.deleted_at', NULL); 
        return $this->db->update('products');
    }
    
	public function delete($id){
        $this->db->set('deleted_at',$this->timestamp);
        $this->db->where('products.id',$id);
        //$this->db->where('products.deleted_at', NULL); 
        return $this->db->update('products');
	}

}
?>