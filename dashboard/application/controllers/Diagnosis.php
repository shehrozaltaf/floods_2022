<?php

class Diagnosis extends CI_controller
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

        $MCustom = new Custom();

        $trackarray = array("action" => "View Diagnosis", "activityName" => "Diagnosis - Diagnosis/area registration",
            "result" => "View Diagnosis page. URL: " . current_url() . " .  Fucntion: Diagnosis/index()");
        $MCustom->trackLogs($trackarray, "user_logs");


        $MDiagnosis = new MDiagnosis();
        $data['myData'] = $MDiagnosis->getAllDiagnosis();
        $this->load->view('include/header');
        $this->load->view('include/top_header');
        $this->load->view('include/sidebar');
        $this->load->view('Diagnosis', $data);
        $this->load->view('include/customizer');
        $this->load->view('include/footer');
    }

    function addDiagnosis()
    {
        ob_end_clean();
        $flag = 0;
        if (!isset($_POST['variable_d']) || $_POST['variable_d'] == '') {
            $flag = 1;
            $result = 2;
            echo $result;
            exit();

        }
        if (!isset($_POST['label_d']) || $_POST['label_d'] == '') {
            $flag = 1;
            $result = 3;
            echo $result;
            exit();

        }

        if ($flag == 0) {
            $Custom = new Custom();
            $formArray = array();
            $formArray['variable'] = $_POST['variable_d'];
            $formArray['label'] = $_POST['label_d'];
            $formArray['colflag'] = 0;
            $formArray['createdBy'] = $this->encrypt->decode($_SESSION['login']['username']);;
            $formArray['createdDateTime'] = date('Y-m-d H:i:s');
            $InsertData = $Custom->Insert($formArray, 'id', 'diagnosis', 'N');
            if ($InsertData) {
                $result = 1;
            } else {
                $result = 9;
            }
        } else {
            $result = 8;
        }
        $trackarray = array("action" => "Diagnosis Add -> Function: addDiagnosis() Diagnosis insert ",
            "activityName" => "Add Diagnosis",
            "result" => $result . "--- resultID: " . $InsertData, "PostData" => $formArray);
        $Custom->trackLogs($trackarray, "user_logs");

        echo $result;
    }


    function deleteData()
    {
        $Custom = new Custom();
        $editArr = array();
        if (isset($_POST['idDiagnosis']) && $_POST['idDiagnosis'] != '') {
            $idDiagnosis = $_POST['idDiagnosis'];
            $editArr['colflag'] = 1;
            $editArr['deleteBy'] = $this->encrypt->decode($_SESSION['login']['username']);;
            $editArr['deletedDateTime'] = date('Y-m-d H:i:s');
            $editData = $Custom->Edit($editArr, 'id', $idDiagnosis, 'diagnosis');
            if ($editData) {
                $result = 1;
            } else {
                $result = 2;
            }
        } else {
            $result = 3;
        }
        $trackarray = array("action" => "Delete Diagnosis -> Function: Diagnosis/deleteData() ",
            "activityName" => "Delete Diagnosis",
            "result" => $result . "--- resultID: " . $editData, "PostData" => $editArr);
        $Custom->trackLogs($trackarray, "user_logs");
        echo $result;
    }


}


?>