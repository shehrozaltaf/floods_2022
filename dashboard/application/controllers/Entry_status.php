<?php

class Entry_status extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mentry_status');
        $this->load->model('muser_app');
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

        $trackarray = array("action" => "View Entry_status", "activityName" => "Entry_status - Entry_status/index",
            "result" => "View Entry_status page. URL: " . current_url() . " .  Fucntion: Entry_status/index()");
        $MCustom->trackLogs($trackarray, "user_logs");

        $districts = $MCustom->getDistricts($ucs);
        $data['district'] = $districts;

        
        $MUser = new MUser_app();
        $data['users'] = $MUser->getAllUserApp();


        $slug_filter = (isset($_GET['f']) && $_GET['f'] != '' && $_GET['f'] != '0' ? $_GET['f'] : '0');
        $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
        $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        $username = (isset($_GET['us']) && $_GET['us'] != '' && $_GET['us'] != '0' ? $_GET['us'] : '');
        $day = (isset($_GET['day']) && $_GET['day'] != '' && $_GET['day'] != '0' ? $_GET['day'] : '');
       

        $MEntry_status = new MEntry_status();
        $data['myData'] = $MEntry_status->getAllEntry_status($district,$ucs,$username,$day);

//         echo '<pre>';
//         print_r($data['myData']);
//         echo '</pre>';
// exit();

        $data['slug_filter'] = $slug_filter;
        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs; 
        $data['slug_user'] = $username;
        $data['slug_day'] = $day;
        

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('entry_status', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }


}


?>