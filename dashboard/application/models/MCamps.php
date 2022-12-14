<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MCamps extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getAllCamps($district, $ucs, $partner)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and camp_area.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != '') {
            $dist_where .= " and camp_area.ucCode  = '$ucs' ";
        }
        if (isset($partner) && $partner != '' && $partner != 0) {
            $dist_where .= " and camp_area.partner_code  = '$partner' ";
        }

        $sql_query = "SELECT
	camp_area.idCampArea, 
	camp_area.area_no, 
	camp_area.area_name, 
	camp_area.remarks, 
	camp_area.partner_code, 
	districts.dist_id,
	districts.district,
	UCs.ucCode,
	UCs.ucName 
FROM
	 camp_area
	LEFT JOIN districts ON camp_area.dist_id = districts.dist_id
	LEFT JOIN UCs ON camp_area.ucCode = UCs.ucCode 
WHERE (camp_area.colflag is null OR camp_area.colflag = '0')
	  $dist_where
ORDER BY
	camp_area.idCampArea DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getEditCampArea($idArea)
    {
        $this->db->select('*');
        $this->db->from('camp_area');
        $this->db->where('idCampArea', $idArea);
        $this->db->where("(camp_area.colflag is null OR camp_area.colflag = '0')");
        $query = $this->db->get();
        return $query->result();
    }

    function getMaxCampAreaCode($area_no)
    {
        $dist_where = '';
        if (isset($area_no) && $area_no != '') {
            $dist_where .= " and camp_area.ucCode = '" . $area_no . "' ";
        }
        $sql_query = "SELECT MAX ( area_no ) AS maxArea 
FROM
	camp_area
WHERE
	( camp_area.colflag IS NULL OR camp_area.colflag = '0' ) $dist_where";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

}