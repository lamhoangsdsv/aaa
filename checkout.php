<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        // Initialize data arrays
        $this->data = array();
        $this->navigation_data = array();

        $this->auth->redirectIfNotLoggedIn();
		$this->load->model('list_inventory_model');
		$this->load->model('checkout_model');
		$this->load->model('consignment_model');
		
		$this->load->model('user/user_model');
		// Get authenticated user data
        $userId = $this->session->userdata('userId');
        $auth_user = $this->user_model->get_users($userId);
        // dd($auth_user);
        $this->data['auth_user'] = $auth_user;
        
    }
    public function index()
    {
		$loadout_id = $this->input->get('loadout_id', TRUE);
		$sess_loadout = $this->session->userdata('loadout_id');
		$sess_type = $this->session->userdata('consignment_type');
		$daf_id = $this->input->get('daf_id', TRUE);
		$consignment = null;
		$this->data['loadout_flag'] = 0;
		if(isset($loadout_id)) //|| (isset($sess_loadout) && $sess_type == 1))
		{
			$loadout_id = isset($loadout_id)?$loadout_id:$sess_loadout;
			$this->data['loadout_flag'] = 1;
			$this->data['project_list'] = $this->list_inventory_model->FetchCartItems($loadout_id);
	        $head_data['page_title'] = "LO:" . str_pad($loadout_id, 8, "0", STR_PAD_LEFT);
	        $head_data['page_name'] = "LO:" . str_pad($loadout_id, 8, "0", STR_PAD_LEFT);
	        $this->session->set_userdata(array('loadout_id' => $loadout_id,'consignment_type' => 1));
			$consignment = $this->consignment_model->get_consinments($loadout_id);
		} else if(isset($daf_id)){ //|| (isset($sess_loadout) && $sess_type == 2)) {
			$daf_id = isset($daf_id)?$daf_id:$sess_loadout;
			$this->data['loadout_flag'] = 1;
			$this->data['project_list'] = $this->list_inventory_model->FetchCartItems($daf_id);
	        $head_data['page_title'] = "DAF:" . str_pad($daf_id, 8, "0", STR_PAD_LEFT);
	        $head_data['page_name'] = "DAF:" . str_pad($daf_id, 8, "0", STR_PAD_LEFT);
	        $this->session->set_userdata(array('loadout_id' => $daf_id,'consignment_type' => 2));
			$consignment = $this->consignment_model->get_consinments($loadout_id);
		} else {
	        $head_data['page_title'] = "Cart";
	        $head_data['page_name'] = "Cart";
			if($this->session->userdata('loadout_id'))
			{
				$loadout_id = $this->session->userdata('loadout_id');
			}
			else
			{
				$loadout_id = 0;
			}
			$this->data['project_list'] = $this->list_inventory_model->FetchCartItems($loadout_id);
		}
		
		
		$base_url = base_url();
        $head_data['library_styles'] = <<<STYLE
<link rel="stylesheet" type="text/css" href="{$base_url}assets/css/jquery-ui.css" />
STYLE;
        $this->data['navigation'] = $this->load->view('include/navigation', $this->navigation_data, true);

        $top_header_data = array();
        $this->data['top_header'] = $this->load->view('include/top-header', $top_header_data, true);
        
		// Prepare loadout popup
        $projects = $this->common_model->getProjectList();

        $loadout_popup_data = array(
            'auth_user' => $this->data['auth_user'],
            'projects' => $projects,
            'consignment' => $consignment
        );
		
        $this->data['consignment_type'] = $sess_type;
		$this->data['loadout_popup'] = $this->load->view('inventory/cart/loadout_popup', $loadout_popup_data, true);
		
		$this->load->view('include/head', $head_data);
                $this->load->model('upload_model');
                $this->data['map_column'] = $this->upload_model->fetch_map_heading_for_bulk_edit();
        $this->load->view('inventory/checkout',$this->data);
    }
	
	public function getInventoryList()
    {
	
		$itemCategoryID = $this->uri->segment(3);
		$searchText = $this->uri->segment(4);
		
		$data['inventory'] = $this->list_inventory_model->getInventoryList($itemCategoryID,$searchText);
        
		 //print_r($data['inventory']->RESULT);
         //$this->load->view('inventory/list_inventory', $data);
		  //$this->load->view('inventory/list_inventory',$data);
		  //$this->load->view('include/head');
		  
		 echo $data['inventory']->RESULT;
		 
    }
	
	
	public function FetchCartItems()
	{
		$data['cartList'] = $this->list_inventory_model->FetchCartItems();
        echo $data['cartList']->RESULT;
	}
	
	public function DeleteCartItems()
	{
		$ItemId = $this->input->post("arrayItemID");
		$data['cartList'] = $this->list_inventory_model->DeleteCartItems($ItemId);
        echo $data['cartList']->RESULT;
		
	}
	
	public function SaveAsDraft()
	{
		$ItemId = $this->input->post("arrayItemID");
		//$this->list_inventory_model->SaveAsDraft($ItemId);
		
		
		 $data['cartList'] = $this->list_inventory_model->SaveAsDraft($ItemId);
         echo $data['cartList'];
		////echo "##".$data['cartList'];
		
	}
	
	public function ClearConsigAssocAndCartItems()
	{
		$this->list_inventory_model->ClearConsigAssocAndCartItems();
	}
	
	
}