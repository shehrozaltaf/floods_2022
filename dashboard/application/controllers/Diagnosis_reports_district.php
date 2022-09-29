<?php

class Diagnosis_reports_district extends CI_controller
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

        $trackarray = array("action" => "View Diagnosis Reports District", "activityName" => "Diagnosis - Diagnosis_reports_district/index",
            "result" => "View Diagnosis Reports District page. URL: " . current_url() . " .  Fucntion: Diagnosis_reports_district/index()");
        $MCustom->trackLogs($trackarray, "user_logs");

        $districts = $MCustom->getDistricts($ucs);
        $data['district'] = $districts;

        $slug_filter = (isset($_GET['f']) && $_GET['f'] != '' && $_GET['f'] != '0' ? $_GET['f'] : '0');
        $district = (isset($_GET['d']) && $_GET['d'] != '' && $_GET['d'] != '0' ? $_GET['d'] : '');
        $ucs = (isset($_GET['u']) && $_GET['u'] != '' && $_GET['u'] != '0' ? $_GET['u'] : '');
        $area = (isset($_GET['a']) && $_GET['a'] != '' && $_GET['a'] != '0' ? $_GET['a'] : '');
        $day = (isset($_GET['day']) && $_GET['day'] != '' && $_GET['day'] != '0' ? $_GET['day'] : '');
        $partner = (isset($_GET['p']) && $_GET['p'] != '' && $_GET['p'] != '0' ? $_GET['p'] : '');
        $type = (isset($_GET['t']) && $_GET['t'] != '' && $_GET['t'] != '0' ? $_GET['t'] : 't');

        $MDiagnosis = new MDiagnosis();
        $data['getAllDiagnosis'] = $MDiagnosis->getAllDiagnosis();
        $myData = $MDiagnosis->getAllDiagnosisReports($district, $ucs, $area, $day,$partner,2);
        $result=array();
        if (isset($myData) && $myData != '') {
            foreach ($myData as $dkk => $dvv) {
//                $key=(isset($dvv->dist_id) && $dvv->dist_id!=''?$dvv->dist_id:$dkk);
                $key=$dkk;
                $result[$key]['dist_id']=$dvv->dist_id;
                $result[$key]['district']=$dvv->district;
                $result[$key]['sum_total_opd']=(isset($dvv->sum_total_opd) && $dvv->sum_total_opd!=''?$dvv->sum_total_opd:0);;
                $result[$key]['diagnosis']=array();
                if (isset($data['getAllDiagnosis']) && $data['getAllDiagnosis'] != '') {
                    foreach ($data['getAllDiagnosis'] as $dk => $dv) {
                        $data_var = $dv->variable;
                        $data_var_u5 = $dv->variable . '_u5';
                        $data_var_a5 = $dv->variable . '_a5';

                        $data_value_u5 = (isset($dvv->$data_var_u5) && $dvv->$data_var_u5!=''?$dvv->$data_var_u5:0);
                        $data_value_a5 = (isset($dvv->$data_var_a5) && $dvv->$data_var_a5!=''?$dvv->$data_var_a5:0);

                        $result[$key]['diagnosis'][$dk]['variable']=$data_var;
                        $result[$key]['diagnosis'][$dk]['label']=$dv->label;
                        $result[$key]['diagnosis'][$dk]['u5']=$data_value_u5;
                        $result[$key]['diagnosis'][$dk]['a5']=$data_value_a5;
                        $result[$key]['diagnosis'][$dk]['total']=$data_value_u5+$data_value_a5;
                    }
                }
            }
        }


        $data['myData']=$result;

        $data['slug_filter'] = $slug_filter;
        $data['slug_district'] = $district;
        $data['slug_ucs'] = $ucs;
        $data['slug_area'] = $area;
        $data['slug_day'] = $day;
        $data['slug_partner'] = $partner;
        $data['slug_type'] = $type;

        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('diagnosis_reports_district', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }


}


?>