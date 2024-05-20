<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model
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
        $this->db->from('categories');
        $this->db->where('categories.deleted_at', NULL); 
        $query = $this->db->get();
        return $query->row();
    }

	/**
	 * Lista todos as categorias
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

		/* Categorias */
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('categories.deleted_at', NULL); 
        $this->db->order_by('categories.id','asc');
				
		$query = $this->db->get();
		$this->total = $query->num_rows();

		$items = $query->result();

        return $items;

    }

	/**
	 * Get item
	 */
    function getById($id,$fields = '*'){

		/* Categorias */
        $this->db->select($fields);
        $this->db->from('categories');
        $this->db->where('categories.deleted_at', NULL); 
        $this->db->where('categories.id', $id); 
        
        $query = $this->db->get();
        $item = $query->row();

        return $item;
    }
	
	public function insert($data){
        return $this->db->insert('categories' , $data);
    }

	public function update($data,$id){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->where('categories.deleted_at', NULL); 
        return $this->db->update('categories');
    }
    
	public function delete($id){
        $this->db->set('deleted_at',$this->timestamp);
        $this->db->where('categories.id',$id);
        $this->db->where('categories.deleted_at', NULL); 
        return $this->db->update('categories');
	}

}
?>