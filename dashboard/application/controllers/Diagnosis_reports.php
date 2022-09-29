<?php

class Diagnosis_reports extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdiagnosis');
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

        $trackarray = array("action" => "View Diagnosis Reports", "activityName" => "Diagnosis - diagnosis_reports/index",
            "result" => "View Diagnosis Reports page. URL: " . current_url() . " .  Fucntion: diagnosis_reports/index()");
        $MCustom->trackLogs($trackarray, "user_logs");

        $districts = $MCustom->getDistricts($ucs);
        $data['district'] = $districts;

        $slug_filter = (isset($_GET['f']) && $_GET['f'] != '' && $_GET['f'] != '0' ? $_GET['f'] : '0');
        $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
        $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        $area = (isset($_GET['a']) && $_GET['a'] != '' && $_GET['a'] != '0' ? $_GET['a'] : '');
        $day = (isset($_GET['day']) && $_GET['day'] != '' && $_GET['day'] != '0' ? $_GET['day'] : '');
        $partner = (isset($_GET['p']) && $_GET['p'] != '' && $_GET['p'] != '0' ? $_GET['p'] : '');

        $MDiagnosis = new MDiagnosis();
        $data['getAllDiagnosis'] = $MDiagnosis->getAllDiagnosis();
        $data['myData'] = $MDiagnosis->getAllDiagnosisReports($district, $ucs, $area, $day,$partner);

        $data['slug_filter'] = $slug_filter;
        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_area'] = $area;
        $data['slug_day'] = $day;
        $data['slug_partner'] = $partner;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('diagnosis_reports', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }


}


?>