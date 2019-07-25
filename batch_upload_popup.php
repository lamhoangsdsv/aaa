<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class batch_upload_popup extends CI_Controller {

    function __construct()
    {
        parent:: __construct();
       // $this->auth->redirectIfNotLoggedIn();
        $this->load->helper(array('form','url','file'));
        $this->load->library(array('session','email','upload','pagination'));
        $this->load->model('Upload_model','upm');
        ini_set('memory_limit','256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
    }
   
    public function index()
    {
        $this->load->view('include/head');
        $this->load->view('upload/upload_popup');
    }
}
 