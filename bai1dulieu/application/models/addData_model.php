<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class addData_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
    }
    public function insert($s, $g){
        $dulieu = array('so' => $s,'gia' => $g );
        $this->db->insert('so_sim', $dulieu);

        return $this->db->insert_id(); //trả về giá trị id của phần tử.
    }
   

}

/* End of file  */
/* Location: ./application/models/ */