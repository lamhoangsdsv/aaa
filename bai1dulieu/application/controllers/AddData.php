<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddData extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('AddData_view');
	}
    public function insertData_controller(){
        //lấy dữ liệu về
       $sodienthoai = $this->input->post('so');
     
       $giatien =  $this->input->post('gia');

       //truyền dữ liệu vào model
       $this->load->model('addData_model');

       if($this->addData_model->insert($sodienthoai, $giatien)){
          // echo "insert thành công";
          $this->load->view('thanhcong');
       }
      else {
          echo "xem lại code";
      }
    }
}

/* End of file AddData.php */
/* Location: ./application/controllers/AddData.php */