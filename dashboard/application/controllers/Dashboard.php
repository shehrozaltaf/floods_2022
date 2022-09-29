<?php error_reporting(0);
ini_set('memory_limit', '256M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');

class Dashboard extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('custom');
        $this->load->model('msettings');
        $this->load->model('mdiagnosis');
        $this->load->model('mdaily_reports');
        if (!isset($_SESSION['login']['idUser'])) {
            redirect(base_url());
        }
    }

    function index()
    {
        $data = array();
        $MSettings = new MSettings();
        $data['permission'] = $MSettings->getUserRights($this->encrypt->decode($_SESSION['login']['idGroup']), '', '');
        $Mdaily_reports = new Mdaily_reports();
        $getTotalOPD=$Mdaily_reports->getTotalOPD(array());


        $data['total_opd'] =(isset($getTotalOPD[0]->opd) && $getTotalOPD[0]->opd!=''?$getTotalOPD[0]->opd:0);
        $data['total_u5'] =(isset($getTotalOPD[0]->u5) && $getTotalOPD[0]->u5!=''?$getTotalOPD[0]->u5:0);
        $data['total_wra'] =(isset($getTotalOPD[0]->wra) && $getTotalOPD[0]->wra!=''?$getTotalOPD[0]->wra:0);
        $data['total_pw'] =(isset($getTotalOPD[0]->pw) && $getTotalOPD[0]->pw!=''?$getTotalOPD[0]->pw:0);
        $data['total_children_vaccinated'] =(isset($getTotalOPD[0]->children_vaccinated) && $getTotalOPD[0]->children_vaccinated!=''?$getTotalOPD[0]->children_vaccinated:0);
        $data['total_wra_vaccinated'] =(isset($getTotalOPD[0]->wra_vaccinated) && $getTotalOPD[0]->wra_vaccinated!=''?$getTotalOPD[0]->wra_vaccinated:0);
        $data['total_daily_reports'] =(isset($getTotalOPD[0]->total_daily_reports) && $getTotalOPD[0]->total_daily_reports!=''?$getTotalOPD[0]->total_daily_reports:0);

        $getDashboardReport=$Mdaily_reports->getDashboardReport();
        $data['getDistrict_DT'] =$getDashboardReport;

        $MDiagnosis = new MDiagnosis();
        $data['getAllDiagnosis'] = $MDiagnosis->getAllDiagnosis();
        $getAllDiagnosisReports = $MDiagnosis->getAllDiagnosisReports('', '', '', '','',1);

        $getSumDiagnosis = $MDiagnosis->getSumDiagnosis();
        $data['total_u5_d']=(isset($getSumDiagnosis[0]->total_u5) &&$getSumDiagnosis[0]->total_u5!=''?$getSumDiagnosis[0]->total_u5:0);
        $data['total_a5_d']=(isset($getSumDiagnosis[0]->total_a5) &&$getSumDiagnosis[0]->total_a5!=''?$getSumDiagnosis[0]->total_a5:0);

        $result=array();
        if (isset($getAllDiagnosisReports) && $getAllDiagnosisReports != '') {
            foreach ($getAllDiagnosisReports as $dkk => $dvv) {
                $result=array();
                if (isset($data['getAllDiagnosis']) && $data['getAllDiagnosis'] != '') {
                    foreach ($data['getAllDiagnosis'] as $dk => $dv) {
                        $data_var = trim($dv->label);
                        $data_var_u5 = $dv->variable . '_u5';
                        $data_var_a5 = $dv->variable . '_a5';

                        $data_value_u5 = (isset($dvv->$data_var_u5) && $dvv->$data_var_u5!=''?$dvv->$data_var_u5:0);
                        $data_value_a5 = (isset($dvv->$data_var_a5) && $dvv->$data_var_a5!=''?$dvv->$data_var_a5:0);

                       /* $result['diagnosis'][$dk]['variable']=$data_var;
                        $result['diagnosis'][$dk]['label']=$dv->label;*/
                        $result['u5'][$data_var]['numbers']=$data_value_u5;
                        $result['u5'][$data_var]['percentage']=($data_value_u5 / $data['total_u5_d']) * 100;

                        $result['a5'][$data_var]['numbers']=$data_value_a5;
                        $result['a5'][$data_var]['percentage']=($data_value_a5 / $data['total_a5_d']) * 100;
                    }
                }
            }
        }
        $data['diagnosis'] =$result;
   /*    echo '<pre>';
        arsort($result['a5']);
        print_r($result['a5']);
        echo '<pre>';
        exit();*/


        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('welcome', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function dailyGraph(){
        $data=array();
        $Mdaily_reports = new Mdaily_reports();
        $getTotalGraph=$Mdaily_reports->getTotalGraph(array());
        foreach ($getTotalGraph as $d=>$v){
            $data[$d]['camp_day']=date('d-m-Y', strtotime($v->camp_day))  ;
            $data[$d]['opd']=trim($v->opd);
        }
        echo json_encode($data);
    }

    /*Setting Page, User Rights*/
    function getMenuData()
    {
        $this->load->model('msettings');
        $idGroup = $this->encrypt->decode($_SESSION['login']['idGroup']);
        $Menu = '';
        $Msetting = new MSettings();
        $getDataRights = $Msetting->getUserRights($idGroup, '1', '');

        if (isset($getDataRights) && count($getDataRights) >= 1) {

            $myresult = array();
            foreach ($getDataRights as $key => $value) {
                if (isset($value->idParent) && $value->idParent != '' && array_key_exists(strtolower($value->idParent), $myresult)) {
                    $mykey = strtolower($value->idParent);
                    $myresult[strtolower($mykey)]->myrow_options[] = $value;
                } else {
                    $mykey = strtolower($value->idPages);
                    $myresult[strtolower($mykey)] = $value;
                }
            }
            foreach ($myresult as $pages) {
                if ($pages->isParent == 1) {
                    $Menu .= '<li class=" nav-item   ' . $pages->menuClass . ' has-sub">
                                      <a href="javascript:void(0)"> 
                                         <i class="feather ' . $pages->menuIcon . '"></i>
                                          <span class="menu-title" data-i18n="' . $pages->pageName . '">' . $pages->pageName . '</span>
                                       </a>
                                       <ul class="menu-content"> ';
                    if (isset($pages->myrow_options) && $pages->myrow_options != '') {
                        foreach ($pages->myrow_options as $options) {
                            $Menu .= ' <li class="' . $options->menuClass . '">
                                        <a href="' . base_url('index.php/' . $options->pageUrl) . '">
                                            <i class="feather ' . $options->menuIcon . '"></i>
                                            <span class="menu-item" data-i18n="' . $options->pageName . '">' . $options->pageName . '</span> 
                                        </a>
                                      </li>';
                        }
                    }
                    $Menu .= ' </ul></li>';
                } else {
                    $Menu .= '<li class=" nav-item ' . $pages->menuClass . '">
                                    <a href="' . base_url('index.php/' . $pages->pageUrl) . '" class="">
                                        <i class="feather ' . $pages->menuIcon . '"></i>
                                        <span class="menu-title" data-i18n="' . $pages->pageName . '">' . $pages->pageName . '</span>
                                    </a>
                              </li>';
                }
            }
        } else {
            $Menu = '';
        }
        $Menu .= ' <li class=" nav-item">
                <a href="javascript:void(0)" onclick="logout()">
                    <i class="feather icon-power"></i>
                    <span class="menu-title" data-i18n="Logout">Logout</span>
                </a>
            </li>';
        echo $Menu;
    }

    function getDistrictByProvince()
    {
        $Custom = new Custom();
        $province = (isset($_REQUEST['province']) && $_REQUEST['province'] != '' && $_REQUEST['province'] != 0 ? $_REQUEST['province'] : 0);
        $sub_district = '';
        if (isset($_SESSION['login']['district']) && $_SESSION['login']['district'] != 0) {
            $sub_district = $_SESSION['login']['district'];
        }
        $data = $Custom->getProvince_District($province, $sub_district);
        echo json_encode($data, true);
    }

    function getUCsByDistrict()
    {
        $Custom = new Custom();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        $uc = '';
        if (isset($_SESSION['login']['district']) && $this->encrypt->decode($_SESSION['login']['district']) != 0) {
            $uc = $this->encrypt->decode($_SESSION['login']['district']);
        }
        $data = $Custom->getUcs_District($district, $uc);
        echo json_encode($data, true);
    }

    function getClustersByDistrict()
    {
        $Custom = new Custom();
        $district = (isset($_REQUEST['district']) && $_REQUEST['district'] != '' && $_REQUEST['district'] != 0 ? $_REQUEST['district'] : 0);
        if (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '1') {
            $randomized = '1';
        } elseif (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '0') {
            $randomized = '0';
        } else {
            $randomized = '';
        }
        $data = $Custom->getClusters_District($district, $randomized);
        echo json_encode($data, true);
    }

    function getClustersByUCs()
    {
        $Custom = new Custom();
        $ucs = (isset($_REQUEST['ucs']) && $_REQUEST['ucs'] != '' && $_REQUEST['ucs'] != 0 ? $_REQUEST['ucs'] : 0);
        if (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '1') {
            $randomized = '1';
        } elseif (isset($_REQUEST['randomized']) && $_REQUEST['randomized'] == '0') {
            $randomized = '0';
        } else {
            $randomized = '';
        }
        $data = $Custom->getClusters_UC($ucs, $randomized);
        echo json_encode($data, true);
    }

    function getClustersData()
    {
        $Custom = new Custom();
        $cluster = (isset($_REQUEST['cluster']) && $_REQUEST['cluster'] != '' && $_REQUEST['cluster'] != 0 ? $_REQUEST['cluster'] : 0);
        $data = $Custom->getClustersData($cluster);
        echo json_encode($data, true);
    }
}

?>