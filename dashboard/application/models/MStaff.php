<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MStaff extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    function getAllStaff($district)
    {
        $dist_where = '';
        if (isset($district) && $district != '') {
            $dist_where .= " and stafflist.dist_id = '$district' ";
        }

        $sql_query = "SELECT
	stafflist.id, 
	stafflist.dept, 
	stafflist.name, 
	stafflist.designation, 
	stafflist.contact, 
	stafflist.dist_id, 
	stafflist.type,
	districts.dist_id,
	districts.district 
FROM
	 stafflist
	LEFT JOIN districts ON stafflist.dist_id = districts.dist_id 
WHERE (stafflist.colflag is null OR stafflist.colflag = '0')
	  $dist_where
ORDER BY
	stafflist.id DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getEditStaff($id)
    {
        $this->db->select('*');
        $this->db->from('stafflist');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


}