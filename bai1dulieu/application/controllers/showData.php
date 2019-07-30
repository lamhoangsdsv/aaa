<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class showData extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
       // $this->load->view('showData_view');
       // load model
        $this->load->model('showData_model');
        // gọi hàm getdatabase trong model
       $dulieu = $this->showData_model->getdatabase();
       $dulieu = array ('duleutucontroller'=> $dulieu); // biến dl thành mảng

       $this->load->view('showData_view', $dulieu, FALSE);
	}
    public function deletedata($idnhanduoc){
        $this->load->model('showData_model');
       if( $this->showData_model->deleteDataById($idnhanduoc))
       {
           $this->load->view('thongbaoxoathanhcong');
       }
       else
       {
           echo "Chưa xóa được";
       }
    }
}

/* End of file showData.php */
/* Location: ./application/controllers/showData.php */