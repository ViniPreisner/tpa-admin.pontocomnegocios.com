<?
defined('BASEPATH') OR exit('No direct script access allowed');

class Contratos_model extends CI_Model
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
        $this->db->from('contracts');
        $this->db->where('contracts.deleted_at', NULL); 
        $query = $this->db->get();
        return $query->row();
    }

	/**
	 * Lista todos os contratos
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

		/* Contratos */
        $this->db->select('*');
        $this->db->from('contracts');
        $this->db->where('contracts.deleted_at', NULL); 
        $this->db->order_by('contracts.id','asc');
				
		$query = $this->db->get();
		$this->total = $query->num_rows();

		$items = $query->result();

        return $items;

    }

	/**
	 * Lista todos os contratos do cliente
	 */
    function getAllByClientId($id_client){

		/* Contratos */
        $this->db->select('contracts.*, status.name as name_status, collectors.name as name_collector');
        $this->db->from('contracts');
        $this->db->join('status','contracts.id_status = status.id','left');
        $this->db->join('collectors','contracts.id_collector = collectors.id','left');
        $this->db->where('contracts.deleted_at', NULL); 
        $this->db->where('contracts.id_client', $id_client); 
        $this->db->order_by('contracts.id','asc');
				
		$query = $this->db->get();

		$items = $query->result();

        return $items;

    }


	/**
	 * Lista todos os contratos do cliente
	 */
    function getByContractId($id_client,$id_contract){

		/* Contratos */
        $this->db->select('contracts.*, status.name as name_status, collectors.name as name_collector');
        $this->db->from('contracts');
        $this->db->join('status','contracts.id_status = status.id','left');
        $this->db->join('collectors','contracts.id_collector = collectors.id','left');
        $this->db->where('contracts.deleted_at', NULL); 
        $this->db->where('contracts.id', $id_contract); 
        $this->db->where('contracts.id_client', $id_client); 
        $this->db->order_by('contracts.id','asc');
				
		$query = $this->db->get();

		$items = $query->row();

        return $items;

    }

    /**
     * Retorna o id do contrato a partir do cliente
     */
    function getContractIdByClient($id_client,$order) {
        $this->db->select('contracts.id');
        $this->db->from('contracts');
        $this->db->where('contracts.deleted_at', NULL); 
        $this->db->where('contracts.id_client', $id_client); 
        if ($order == 'last') {
            $this->db->order_by('contracts.id','desc');
        } else {
            $this->db->order_by('contracts.id','asc');
        }

        $query = $this->db->get();

        $item = $query->row();

        if ($item) {
            return $item->id;
        }

        return false;
    }

	/**
	 * Get item
	 */
    function getById($id,$fields = 'contracts.*, status.name as name_status, collectors.name as name_collector'){

		/* Contratos */
        $this->db->select($fields);
        $this->db->from('contracts');
        $this->db->join('status','contracts.id_status = status.id','left');
        $this->db->join('collectors','contracts.id_collector = collectors.id','left');
        $this->db->where('contracts.deleted_at', NULL); 
        $this->db->where('contracts.id', $id); 
        
        $query = $this->db->get();
        $item = $query->row();

        return $item;
    }
	
	public function insert($data){
        $this->db->insert('contracts' , $data);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

	public function update($data,$id){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->where('contracts.deleted_at', NULL); 
        return $this->db->update('contracts');
    }
    
	public function delete($id){
        $this->db->set('deleted_at',$this->timestamp);
        $this->db->where('contracts.id',$id);
        $this->db->where('contracts.deleted_at', NULL); 
        return $this->db->update('contracts');
	}

}
?>