<?php error_reporting(0);

class Camps extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mcamps');
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
            $ucs =  $this->encrypt->decode($_SESSION['login']['district']);
        }
        $MCustom = new Custom();

        $trackarray = array("action" => "View Camps", "activityName" => "Camps - camp/area registration",
            "result" => "View Camps page. URL: " . current_url() . " .  Fucntion: Camp_area/index()");
        $MCustom->trackLogs($trackarray, "user_logs");


        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;

        $partner = (isset($_GET['p']) && $_GET['p'] != '' && $_GET['p'] != '0' ? $_GET['p'] : '0');
        $slug_filter = (isset($_GET['f']) && $_GET['f'] != '' && $_GET['f'] != '0' ? $_GET['f'] : '0');
        if (isset($_GET['f']) && $_GET['f'] != '') {
            $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
            $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');

            $MCamp = new MCamps();
            $data['myData'] = $MCamp->getAllCamps($district, $ucs,$partner);
        } else {
            $district = '';
            $data['myData'] = '';
        }

        $data['slug_filter'] = $slug_filter;
        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_partner'] = $partner;
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('camps', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function addCampArea()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['dist_id']) || $_POST['dist_id'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['ucCode']) || $_POST['ucCode'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();

        }
        if (!isset($_POST['area_name']) || $_POST['area_name'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();

        }
        if (!isset($_POST['area_no']) || $_POST['area_no'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }

        if (!isset($_POST['partner_code']) || $_POST['partner_code'] == '') {
            $flag = 1;
            $result = 10;
            echo $result;
            exit();
        }

        $MCamp = new MCamps();
        $ucs = (isset($_REQUEST['ucCode']) && $_REQUEST['ucCode'] != '' && $_REQUEST['ucCode'] != 0 ? $_REQUEST['ucCode'] : 0);
        $result = $MCamp->getMaxCampAreaCode($ucs);
        if (isset($result[0]->maxArea) && $result[0]->maxArea != '') {
            $exp = explode('-', $result[0]->maxArea);
            if (isset($exp[1]) && $exp[1]) {
                $max = $exp[1] + 1;
            } else {
                $max = 1;
            }
        } else {
            $max = 1;
        }
        $area_no = $ucs . '-' . sprintf("%04d", $max);

        if (!isset($area_no) || $area_no == '') {
            $flag = 1;
            $result = 6;
            echo $result;
            exit();
        }

        if ($flag == 0) {
            $Custom = new Custom();
            $formArray = array();
            $formArray['dist_id'] = $_POST['dist_id'];
            $formArray['ucCode'] = $_POST['ucCode'];
            $formArray['area_no'] = $area_no;
            $formArray['area_name'] = $_POST['area_name'];
            $formArray['partner_code'] = $_POST['partner_code'];
            $formArray['remarks'] = (isset($_POST['remarks']) && $_POST['remarks'] != '' ? $_POST['remarks'] : '');
            $formArray['colflag'] = 0;
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['username']);
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($formArray, 'id', 'camp_area', 'N');
            if ($InsertData) {
                $result = 1;
            } else {
                $result = 9;
            }
        } else {
            $result = 8;
        }
        $trackarray = array("action" => "Camp Area Add -> Function: addCampArea() camp area insert ",
            "activityName" => "Add Camp Area",
            "result" => $result . "--- resultID: " . $InsertData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }

    public function getMaxArea()
    {
        $MCamp = new MCamps();
        $ucs = (isset($_REQUEST['ucCode']) && $_REQUEST['ucCode'] != '' && $_REQUEST['ucCode'] != 0 ? $_REQUEST['ucCode'] : 0);
        $result = $MCamp->getMaxCampAreaCode($ucs);
        if (isset($result[0]->maxArea) && $result[0]->maxArea != '') {
            $exp = explode('-', $result[0]->maxArea);
            if (isset($exp[1]) && $exp[1]) {
                $max = $exp[1] + 1;
            } else {
                $max = 1;
            }
        } else {
            $max = 1;
        }
        echo $ucs . '-' . sprintf("%04d", $max);
    }

    public function getAreaEdit()
    {
        $MCamp = new MCamps();
        $result = $MCamp->getEditCampArea($this->input->post('id'));
        echo json_encode($result, true);
    }

    function editData()
    {
        $Custom = new Custom();
        $editArr = array();

        $flag = 0;
        if (!isset($_POST['idCampArea']) || $_POST['idCampArea'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();
        }

        if (!isset($_POST['dist_id']) || $_POST['dist_id'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();
        }

        if (!isset($_POST['ucCode']) || $_POST['ucCode'] == '') {
            $flag = 1;
            $result = 4;
            echo $result;
            exit();
        }

        if (!isset($_POST['area_name']) || $_POST['area_name'] == '') {
            $flag = 1;
            $result = 5;
            echo $result;
            exit();
        }

        if (!isset($_POST['partner_code']) || $_POST['partner_code'] == '') {
            $flag = 1;
            $result = 10;
            echo $result;
            exit();
        }
        if (isset($_POST['idCampArea']) && $_POST['idCampArea'] != '' && $flag == 0) {
            $idCampArea = $_POST['idCampArea'];
            $editArr['area_name'] = $_POST['area_name'];
            $editArr['remarks'] = $_POST['remarks'];
            $editArr['partner_code'] = $_POST['partner_code'];

            $editArr['updateBy'] =$this->encrypt->decode($_SESSION['login']['username']);;
            $editArr['updatedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idCampArea', $idCampArea, 'camp_area');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Edit Camp Area setting -> Function: Camp_area/editData() ",
            "activityName" => "Edit Camp Area",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idCampArea']) && $_POST['idCampArea'] != '') {
            $idCampArea = $_POST['idCampArea'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['username']);;
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'idCampArea', $idCampArea, 'camp_area');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Delete Camp Area -> Function: Camp_area/deleteData() ",
            "activityName" => "Delete Camp Area",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }


}


?>