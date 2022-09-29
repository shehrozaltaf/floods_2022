<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MEntry_status extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getAllDiagnosis()
    {

        $sql_query = "SELECT
	*
FROM
	 diagnosis 
WHERE (colflag is null OR colflag = '0')
ORDER BY
	sortNo ASC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
}