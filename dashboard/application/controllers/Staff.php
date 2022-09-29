<?php

class Staff extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mstaff');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', uri_string());

        $ucs = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
            $ucs = $this->encrypt->decode($_SESSION['login']['district']);
        }
        $MCustom = new Custom();

        $trackarray = array("action" => "View Staff", "activityName" => "Staff - Staff/area registration",
            "result" => "View Staff page. URL: " . current_url() . " .  Fucntion: Staff/index()");
        $MCustom->trackLogs($trackarray, "user_logs");


        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;
        $slug_filter = (isset($_GET['f']) && $_GET['f'] != '' && $_GET['f'] != '0' ? $_GET['f'] : '0');
        if (isset($_GET['f']) && $_GET['f'] != '') {
            $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
            $MStaff = new MStaff();
            $data['myData'] = $MStaff->getAllStaff($district);
        } else {
            $district = '';
            $data['myData'] = '';
        }

        $data['slug_filter'] = $slug_filter;
        $data['slug_district'] = $district;
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('staff', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function addStaff()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['dist_id']) || $_POST['dist_id'] == '' || $_POST['dist_id'] == '0' || $_POST['dist_id'] == 0) {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['user_name']) || $_POST['user_name'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();

        }
        if (!isset($_POST['dept']) || $_POST['dept'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();

        }
        if (!isset($_POST['type']) || $_POST['type'] == '' || $_POST['type'] == '0' || $_POST['type'] == 0) {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }
        if ($flag == 0) {
            $Custom = new Custom();
            $formArray = array();
            $formArray['dist_id'] = $_POST['dist_id'];
            $formArray['name'] = $_POST['user_name'];
            $formArray['dept'] = $_POST['dept'];
            $formArray['designation'] = (isset($_POST['designation']) && $_POST['designation'] != '' ? $_POST['designation'] : '');
            $formArray['contact'] = (isset($_POST['contact']) && $_POST['contact'] != '' ? $_POST['contact'] : '');
            $formArray['type'] = $_POST['type'];
            $formArray['colflag'] = 0;
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['username']);;
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($formArray, 'id', 'stafflist', 'N');
            if ($InsertData) {
                $result = 1;
            } else {
                $result = 9;
            }
        } else {
            $result = 8;
        }
        $trackarray = array("action" => "Staff Add -> Function: addStaff() Staff insert ",
            "activityName" => "Add Staff",
            "result" => $result . "--- resultID: " . $InsertData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }

    public function getStaffEdit()
    {
        $MCamp = new MStaff();
        $result = $MCamp->getEditStaff($this->input->post('id'));
        echo json_encode($result, true);
    }

    function editData()
    {
        $Custom = new Custom();
        $formArray = array();

        $flag = 0;
        if (!isset($_POST['idStaff']) || $_POST['idStaff'] == '') {
            $flag = 1;
            $result = 8;
            echo $result;
            exit();
        }

        if (!isset($_POST['dist_id']) || $_POST['dist_id'] == '' || $_POST['dist_id'] == '0' || $_POST['dist_id'] == 0) {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['user_name']) || $_POST['user_name'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();

        }
        if (!isset($_POST['dept']) || $_POST['dept'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();

        }
        if (!isset($_POST['type']) || $_POST['type'] == '' || $_POST['type'] == '0' || $_POST['type'] == 0) {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }
        if (isset($_POST['idStaff']) && $_POST['idStaff'] != '' && $flag == 0) {
            $idStaff = $_POST['idStaff'];

            $formArray['dist_id'] = $_POST['dist_id'];
            $formArray['name'] = $_POST['user_name'];
            $formArray['dept'] = $_POST['dept'];
            $formArray['designation'] = (isset($_POST['designation']) && $_POST['designation'] != '' ? $_POST['designation'] : '');
            $formArray['contact'] = (isset($_POST['contact']) && $_POST['contact'] != '' ? $_POST['contact'] : '');
            $formArray['type'] = $_POST['type'];

            $formArray['updateBy'] = $this->encrypt->decode($_SESSION['login']['username']);;
            $formArray['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($formArray, 'id', $idStaff, 'stafflist');
            if ($editData) {
                $result = 1;
            } else {
                $result = 9;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Edit Staff -> Function: Staff/editData() ",
            "activityName" => "Edit Staff",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idStaff']) && $_POST['idStaff'] != '') {
            $idStaff = $_POST['idStaff'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['username']);;
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idStaff, 'stafflist');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Delete Staff -> Function: Staff/deleteData() ",
            "activityName" => "Delete Staff",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }


}


?>