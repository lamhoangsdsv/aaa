<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class showData_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
    }
    public function getdatabase(){
        $this->db->select('*');
      $ketqua =  $this->db->get('so_sim');
      $ketqua = $ketqua->result_array();
      return $ketqua;
   
    }
    public function deleteDataById($id){
        $this->db->where('id', $id);
       return $this->db->delete('so_sim');
      
    }

}

/* End of file  */ 
/* Location: ./application/models/ */