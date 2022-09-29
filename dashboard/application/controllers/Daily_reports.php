<?php

class Daily_reports extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdaily_reports');
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
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $ucs = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();

        $trackarray = array("action" => "View Health Camps Report", "activityName" => "Camp Area - Health Camps Report",
            "result" => "View Health Camps Report page. URL: " . current_url() . " .  Fucntion: daily_reports/index()");
        $MCustom->trackLogs($trackarray, "user_logs");
        $districts = $MCustom->getDistricts($ucs);
        $data['district'] = $districts;

        $slug_filter = (isset($_GET['f']) && $_GET['f'] != '' && $_GET['f'] != '0' ? $_GET['f'] : '0');
        $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
        $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        $area = (isset($_GET['a']) && $_GET['a'] != '' && $_GET['a'] != '0' ? $_GET['a'] : '');
        $day = (isset($_GET['day']) && $_GET['day'] != '' && $_GET['day'] != '0' ? $_GET['day'] : '');
        $partner = (isset($_GET['p']) && $_GET['p'] != '' && $_GET['p'] != '0' ? $_GET['p'] : '');
        $Mdaily_reports = new Mdaily_reports();
        $data['getData'] = $Mdaily_reports->getReport($district, $ucs, $area, $day,$partner);

        $data['slug_filter'] = $slug_filter;
        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_area'] = $area;
        $data['slug_day'] = $day;
        $data['slug_partner'] = $partner;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('daily_reports', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function add_daily_reports()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', 'daily_reports/add_daily_reports');

        $ucs = '';
        if (isset($data['permission'][0]->CanViewAllDetail) && $data['permission'][0]->CanViewAllDetail != 1
            && isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $ucs = $_SESSION['login']['district'];
        }

        $MCustom = new Custom();

        $trackarray = array("action" => "Add Daily_reports", "activityName" => "Add Daily Reports - Daily_reports",
            "result" => "View Add page Daily_reports page. URL: " . current_url() . " .  Fucntion: daily_reports/add_daily_reports()");
        $MCustom->trackLogs($trackarray, "user_logs");
        $district = $MCustom->getDistricts($ucs);
        $data['district'] = $district;

        $getDiagnosis = $MCustom->getDiagnosis();
        $data['diagnosis'] = $getDiagnosis;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('daily_reports_add', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function getUCsByDistrict()
    {
        $Model = new Custom();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $round = (isset($_REQUEST['round']) && $_REQUEST['round'] != '' && $_REQUEST['round'] != 0 ? $_REQUEST['round'] : 0);
        $uc = '';
        if (isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
            $uc = $this->encrypt->decode($_SESSION['login']['district']);
        }
        $data = $Model->getUcs_District($district, $uc, $round);
        echo json_encode($data, true);
    }

    function getStaffByDistrict()
    {
        $Model = new Custom();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $data = $Model->getStaff_District($district);
        echo json_encode($data, true);
    }

    function getAreaByUCs()
    {
        $Model = new Mdaily_reports();
        $ucs = (isset($_REQUEST['uc']) && $_REQUEST['uc'] != '' && $_REQUEST['uc'] != 0 ? $_REQUEST['uc'] : 0);
        $round = (isset($_REQUEST['round']) && $_REQUEST['round'] != '' && $_REQUEST['round'] != 0 ? $_REQUEST['round'] : 0);
        $data = $Model->getAreasByUc($ucs, $round);
        echo json_encode($data, true);
    }

    function getDayByArea()
    {
        $Model = new Mdaily_reports();
        $area = (isset($_REQUEST['area']) && $_REQUEST['area'] != '' && $_REQUEST['area'] != 0 ? $_REQUEST['area'] : 0);
        $round = (isset($_REQUEST['round']) && $_REQUEST['round'] != '' && $_REQUEST['round'] != 0 ? $_REQUEST['round'] : 0);
        $data = $Model->getDaysByArea($area, $round);
        echo json_encode($data, true);
    }

    function addData()
    {
        ob_end_clean();

        $Custom = new Custom();
        if (!isset($_POST['dist_id_add']) || $_POST['dist_id_add'] == '') {
            $result = array('0' => 'Error', '1' => 'Invalid District', '2' => '0');
            echo json_encode($result);
            exit();
        }
        if (!isset($_POST['uc_add']) || $_POST['uc_add'] == '') {
            $result = array('0' => 'Error', '1' => 'Invalid UC', '2' => '0');
            echo json_encode($result);
            exit();
        }
        if (!isset($_POST['area_add']) || $_POST['area_add'] == '') {
            $result = array('0' => 'Error', '1' => 'Invalid Area', '2' => '0');
        } else {
            $formArray = array();
            $formArray['dist_id'] = (isset($_POST['dist_id_add']) && $_POST['dist_id_add'] != '' ? $_POST['dist_id_add'] : '');
            $formArray['ucCode'] = (isset($_POST['uc_add']) && $_POST['uc_add'] != '' ? $_POST['uc_add'] : '');
            $formArray['area_no'] = (isset($_POST['area_add']) && $_POST['area_add'] != '' ? $_POST['area_add'] : '');
            $formArray['exact_location'] = (isset($_POST['exact_location']) && $_POST['exact_location'] != '' ? $_POST['exact_location'] : '');
            $formArray['camp_day'] = (isset($_POST['camp_day']) && $_POST['camp_day'] != '' ? date('Y-m-d', strtotime($_POST['camp_day'])) : '');
            $formArray['total_opd'] = (isset($_POST['opd']) && $_POST['opd'] != '' ? $_POST['opd'] : '');
            $formArray['total_under5'] = (isset($_POST['under_five_child']) && $_POST['under_five_child'] != '' ? $_POST['under_five_child'] : '');
            $formArray['total_wra'] = (isset($_POST['wra']) && $_POST['wra'] != '' ? $_POST['wra'] : '');
            $formArray['total_pw'] = (isset($_POST['pw']) && $_POST['pw'] != '' ? $_POST['pw'] : '');
            $formArray['total_children_vaccinated'] = (isset($_POST['children_vaccinated']) && $_POST['children_vaccinated'] != '' ? $_POST['children_vaccinated'] : '');
            $formArray['total_wra_vaccinated'] = (isset($_POST['wra_vaccinated']) && $_POST['wra_vaccinated'] != '' ? $_POST['wra_vaccinated'] : '');
            $formArray['total_children_received_opv'] = (isset($_POST['children_received_opv']) && $_POST['children_received_opv'] != '' ? $_POST['children_received_opv'] : '');
            $formArray['colflag'] = 0;
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');

            if (isset($_POST['resources']) && $_POST['resources'] != '') {
                foreach ($_POST['resources'] as $k => $vac) {
                    if ($k == 0) {
                        $formArray['vaccinator1'] = $vac;
                    } elseif ($k == 1) {
                        $formArray['vaccinator2'] = $vac;
                    } elseif ($k == 2) {
                        $formArray['vaccinator3'] = $vac;
                    } elseif ($k == 3) {
                        $formArray['vaccinator4'] = $vac;
                    }
                }
            }

            if (isset($_POST['diagnosis']) && $_POST['diagnosis'] != '') {
                foreach ($_POST['diagnosis'] as $k_diag => $diag) {
                    if ($k_diag != '' && $k_diag != 'undefined') {
                        $formArray[$k_diag] = (isset($diag) && $diag != '' ? $diag : '');
                    }
                }
            }
            $InsertData = $Custom->Insert($formArray, 'id', 'camp_daily_progress', 'Y');
            if ($InsertData) {
                $result = array('0' => 'Success', '1' => 'Successfully Inserted', '2' => $InsertData);
            } else {
                $result = array('0' => 'Error', '1' => 'Error in Inserting Data', '2' => '0');
            }

            /*==========Log=============*/
            $trackarray = array(
                "activityName" => "Daily_reports",
                "action" => "Add Daily_reports -> Function: Daily_reports/addData()",
                "result" => $result[1],
                "PostData" => $formArray,
                "affectedKey" => 'id=' . $InsertData,
                "idUser" => $this->encrypt->decode($_SESSION['login']['idUser']),
                "username" => $this->encrypt->decode($_SESSION['login']['username']),
            );
            $Custom->trackLogs($trackarray, "all_logs");
            /*==========Log=============*/
        }
        echo json_encode($result);
    }

    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $id = $_POST['id'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['idUser']);
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $id, 'camp_daily_progress');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        echo $result;
    }
}

?>