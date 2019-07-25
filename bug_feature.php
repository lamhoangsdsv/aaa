<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bug_feature extends CI_Controller {

    function __construct() {
        parent:: __construct();
        $this->auth->redirectIfNotLoggedIn();
        $this->load->model('request_model');
    }

    public function index() {
        $permission = getPermission();
        if( ( $permission == 'R' )  ){
            show_403();
        }
        $this->load->view('include/head', $head_data);
        $this->load->view('requests/index',$data);
    }

    public function insert_bug_request() {
        $url = $this->input->post('source_url');
        $summary = $this->input->post('summary');
        $steps = $this->input->post('steps');
        $expected = $this->input->post('expected');
        $actual = $this->input->post('actual');
        $link1 = $this->input->post('link1');
        $link2 = $this->input->post('link2');
        $link3 = $this->input->post('link3');
        $osName = $this->input->post('osName');
        $browserVerison = $this->input->post('browserVerison');
        $userAgent = $this->input->post('userAgent');
        $viewportSize = $this->input->post('viewportSize');
        $screenSize = $this->input->post('screenSize');
        $userId = $this->session->userdata('userId');
        $createdDate = date("Y-m-d H:i:s");
        $query = $this->db->query("INSERT INTO tblTrnBugItemList (SourceUrl, Summary, StepsToReproduce, ExpectedResults, ActualResults, Link1, Link2, Link3, UserId, CreatedDate, Status, Browser, ScreenSize, ViewportSize, OS, UserAgent) VALUES('".$url."','".$summary."','".$steps."','".$expected."','".$actual."','".$link1."','".$link2."','".$link3."','".$userId."','".$createdDate."','New','".$browserVerison."','".$screenSize."','".$viewportSize."','".$osName."','".$userAgent."')");
        if($query)
            echo 'success to save into tblTrnBugItemList';
        else
            echo 'failed to save into tblTrnBugItemList';
    }

    public function insert_feature_request() {
        $module_id = $this->input->post('module_id');
        $summary = $this->input->post('feature_request_lists');
        $feature_description = $this->input->post('feature_description');
        $link1 = $this->input->post('link1');
        $link2 = $this->input->post('link2');
        $link3 = $this->input->post('link3');
        $userId = $this->session->userdata('userId');
        $createdDate = date("Y-m-d H:i:s");
        $query = $this->db->query("INSERT INTO tblTrnFeatureItemList (ModuleId, Summary, Description, Link1, Link2, Link3, UserId, CreatedDate, Status, Count) VALUES('".$module_id."','".$summary."','".$feature_description."','".$link1."','".$link2."','".$link3."','".$userId."','".$createdDate."','New',0)");
        if($query)
            echo 'success to save into tblTrnFeatureItemList';
        else
            echo 'failed to save into tblTrnFeatureItemList';
    }

    public function show_list() {
        $head_data['page_title'] = 'Settings';
        $base_url = base_url();
        $this->load->view('include/head', $head_data);
        $top_header_data = array();
        $data['top_header'] = $this->load->view('include/top-header', $top_header_data, true);
        $bugs = $this->request_model->getBugList();

        $features = $this->request_model->getFeatureList();

        $data['bugs_list'] = $bugs;
        $data['features_list'] = $features;
        $this->load->view('include/head');
        $this->load->view('request/index',$data);
    }

    public function exportBugList() {
        $heading = $this->request_model->getColumnNames('tblTrnBugItemList');

        $content = $this->request_model->getAllData('tblTrnBugItemList');

        $col = array();
        foreach ($heading as $column) {
            $col[] = $column->COLUMN_NAME;
        }
        $data["fetch_map_heading"] = json_decode(json_encode($col), True);
        $data["result"] = json_decode(json_encode($content), True);

        if(!empty($data)){
            $fetch_map_heading = $data["fetch_map_heading"];
            $result = $data["result"];
            $delimiter = ",";
            $filename = "Buglist_" . date('Y-m-d') . ".csv";
            //create a file pointer
            $f = fopen('php://memory', 'w');
            //set column headers
            foreach ($fetch_map_heading as $key => $value) {
                if($value == "BugItemId")
                    $fields[] = "ID#";
                else if($value == "UserId")
                    $fields[] = "User";
                else
                    $fields[] = $value;
            }
            fputcsv($f, $fields, $delimiter);

            foreach ((array)$result as $key => $value) {
                $lineData = null;
                foreach ($fetch_map_heading as $row) {
                    if($row == "CreatedDate")
                        $lineData[] = date("d/m/Y", strtotime($value[$row]) );
                    else if($row == "UserId")
                        $lineData[] = $value['UserName'];
                    else
                        $lineData[] = $value[$row];
                }
                fputcsv($f, $lineData, $delimiter);
            }
            fseek($f, 0);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            fpassthru($f);
        }else{
            return false;
        }
    }

    public function exportFeatureList() {
        $heading = $this->request_model->getColumnNames('tblTrnFeatureItemList');

        $content = $this->request_model->getAllData('tblTrnFeatureItemList');

        $col = array();
        foreach ($heading as $column) {
            $col[] = $column->COLUMN_NAME;
        }
        $data["fetch_map_heading"] = json_decode(json_encode($col), True);
        $data["result"] = json_decode(json_encode($content), True);

        if(!empty($data)){
            $fetch_map_heading = $data["fetch_map_heading"];
            $result = $data["result"];
            $delimiter = ",";
            $filename = "Featurelist_" . date('Y-m-d') . ".csv";
            //create a file pointer
            $f = fopen('php://memory', 'w');
            //set column headers
            foreach ($fetch_map_heading as $key => $value) {
                if($value == "FeatureItemId")
                    $fields[] = "ID#";
                else if($value == "UserId")
                    $fields[] = "User";
                else if($value == "ModuleId")
                    $fields[] = "Module";
                else
                    $fields[] = $value;
            }
            fputcsv($f, $fields, $delimiter);

            foreach ((array)$result as $key => $value) {
                $lineData = null;
                foreach ($fetch_map_heading as $row) {
                    if($row == "CreatedDate")
                        $lineData[] = date("d/m/Y", strtotime($value[$row]) );
                    else if($row == "UserId")
                        $lineData[] = $value['UserName'];
                    else if($row == "Link1")
                        $lineData[] = base_url('uploads/bug/'.$value['FullLink1']);
                    else if($row == "Link2")
                        $lineData[] = base_url('uploads/bug/'.$value['FullLink2']);
                    else if($row == "Link3")
                        $lineData[] = base_url('uploads/bug/'.$value['FullLink3']);
                    else if($row == "ModuleId")
                        $lineData[] = $value['ModuleName'];
                    else
                        $lineData[] = $value[$row];
                }
                fputcsv($f, $lineData, $delimiter);
            }
            fseek($f, 0);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            fpassthru($f);
        }else{
            return false;
        }
    }

    public function sendEmails() {
        $fl = $this->input->post('fl');
        $email=$this->request_model->getEmailforUser($this->session->userdata('userId'));
        if($email) {
            $subject='Bug Reporting Confirmation';
            $body = "<h1>Thank you for your Submission.</h1> <h4>We've received your Bug Report and will  be addressing the issues shortly. <br> To aid us in addressing the issue efficiently we may get in touch if we require clarification. <br> Thanks for your assistance, </h4> <br> <h2>Balinginy Team</h2>";
            if($fl == '2') {
                $subject='Feature Reporting Confirmation';
                $body = "<h1>Thank you for your Submission.</h1> <h4>We've received your Feature Report and will  be addressing the features shortly. <br> To aid us in addressing the feature efficiently we may get in touch if we require clarification. <br> Thanks for your assistance, </h4> <br> <h2>Balinginy Team</h2>";
            }
            $result = $this->my_email->send_by_email($email, $subject, $body);
            if($result)
                echo 'success';
            else
                echo 'failed';
        } else {
            echo 'Invaild Email';
        }
    }

    function sendMail()
    {
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.googlemail.com',
          'smtp_port' => 465,
          'smtp_user' => '', // change it to yours
          'smtp_pass' => '', // change it to yours
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
        );

        $message = 'hi';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from(''); // change it to yours
        $this->email->to('');// change it to yours
        $this->email->subject('Resume from JobsBuddy for your Job posting');
        $this->email->message($message);
        if($this->email->send()){
          echo 'Email sent.';
        }else{
         show_error($this->email->print_debugger());
        }
    }

    public function changeStatus() {
        $temp_id = $this->input->post('id');
        $temp_flag = $this->input->post('flag');
        $temp_status = $this->input->post('status');
        if($temp_status == '0')
            $temp_status = 'New';
        else if($temp_status == '1')
            $temp_status = 'In Progress';
        else if($temp_status == '2')
            $temp_status = 'Completed';
        $query = "UPDATE tblTrnBugItemList SET Status = '".$temp_status."' WHERE BugItemId = ".$temp_id;
        if($temp_flag == '2')
            $query = "UPDATE tblTrnFeatureItemList SET Status = '".$temp_status."' WHERE FeatureItemId = ".$temp_id;
        $query = $this->db->query($query);
        if($query)
            echo 1;
        else
            echo 0;
    }

    public function deleteItem() {
        $temp_id = $this->input->post('id');
        $temp_flag = $this->input->post('flag');
        $query = "DELETE tblTrnBugItemList WHERE BugItemId = ".$temp_id;
        if($temp_flag == '2')
            $query = "DELETE tblTrnFeatureItemList WHERE FeatureItemId = ".$temp_id;
        $query = $this->db->query($query);
        if($query)
            echo 1;
        else
            echo 0;
    }
	//đã sửa ở đây
}