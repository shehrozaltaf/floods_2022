<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MDiagnosis extends CI_Model
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

    function getAllDiagnosisReports($district, $ucs, $area, $day, $partner, $page = 1)
    {
        $dist_where = 'where (c.colflag is null OR c.colflag = \'0\')  ';
        if (isset($district) && $district != 0 && $district != '') {
            $dist_where .= " AND c.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != 0 && $ucs != '') {
            $dist_where .= " AND c.ucCode = '$ucs' ";
        }

        if (isset($area) && $area != 0 && $area != '') {
            $dist_where .= " AND c.area_no ='$area' ";
        }

        if (isset($partner) && $partner != 0 && $partner != '') {
            $dist_where .= " AND a.partner_code ='$partner' ";
        }

        if (isset($day) && $day != 0 && $day != '') {
            $day_php = date('Y-m-d', strtotime($day));
            $dist_where .= " AND c.camp_day ='$day_php' ";
        }
        $grp = '';
        $slt = '';
        $join = '';
        if ($page == 2) {
            $slt = 'd.dist_id,
	d.district,  ';
            $grp = 'GROUP BY
	d.dist_id ,
	d.district';
            $join = 'LEFT JOIN  districts AS d ON c.dist_id= d.dist_id 
	AND ( d.colflag IS NULL OR d.colflag = 0 ) ';
        }

        $sql_query = "SELECT  $slt
    COUNT ( c.id ) AS num_of_days,
	SUM ( c.total_opd ) AS sum_total_opd,
	SUM ( c.di021_u5 ) AS di021_u5,
	SUM ( c.di021_a5 ) AS di021_a5,
	SUM ( c.di022_u5 ) AS di022_u5,
	SUM ( c.di022_a5 ) AS di022_a5,
	SUM ( c.di023_u5 ) AS di023_u5,
	SUM ( c.di023_a5 ) AS di023_a5,
	SUM ( c.di024_u5 ) AS di024_u5,
	SUM ( c.di024_a5 ) AS di024_a5,
	SUM ( c.di011_u5 ) AS di011_u5,
	SUM ( c.di011_a5 ) AS di011_a5,
	SUM ( c.di025_u5 ) AS di025_u5,
	SUM ( c.di025_a5 ) AS di025_a5,
	SUM ( c.di026_u5 ) AS di026_u5,
	SUM ( c.di026_a5 ) AS di026_a5,
	SUM ( c.di027_u5 ) AS di027_u5,
	SUM ( c.di027_a5 ) AS di027_a5,
	SUM ( c.di028_u5 ) AS di028_u5,
	SUM ( c.di028_a5 ) AS di028_a5,
	SUM ( c.di029_u5 ) AS di029_u5,
	SUM ( c.di029_a5 ) AS di029_a5,
	SUM ( c.di030_u5 ) AS di030_u5,
	SUM ( c.di030_a5 ) AS di030_a5,
	SUM ( c.di031_u5 ) AS di031_u5,
	SUM ( c.di031_a5 ) AS di031_a5,
	SUM ( c.di032_u5 ) AS di032_u5,
	SUM ( c.di032_a5 ) AS di032_a5,
	SUM ( c.di033_u5 ) AS di033_u5,
	SUM ( c.di033_a5 ) AS di033_a5,
	SUM ( c.di034_u5 ) AS di034_u5,
	SUM ( c.di034_a5 ) AS di034_a5,
	SUM ( c.di035_u5 ) AS di035_u5,
	SUM ( c.di035_a5 ) AS di035_a5,
	SUM ( c.di001_u5 ) AS di001_u5,
	SUM ( c.di001_a5 ) AS di001_a5,
	SUM ( c.di009_u5 ) AS di009_u5,
	SUM ( c.di009_a5 ) AS di009_a5,
	SUM ( c.di003_u5 ) AS di003_u5,
	SUM ( c.di003_a5 ) AS di003_a5,
	SUM ( c.di036_u5 ) AS di036_u5,
	SUM ( c.di036_a5 ) AS di036_a5,
	SUM ( c.di037_u5 ) AS di037_u5,
	SUM ( c.di037_a5 ) AS di037_a5,
	SUM ( c.di038_u5 ) AS di038_u5,
	SUM ( c.di038_a5 ) AS di038_a5,
	SUM ( c.di039_u5 ) AS di039_u5,
	SUM ( c.di039_a5 ) AS di039_a5,
	SUM ( c.di040_u5 ) AS di040_u5,
	SUM ( c.di040_a5 ) AS di040_a5,
	SUM ( c.di041_u5 ) AS di041_u5,
	SUM ( c.di041_a5 ) AS di041_a5,
	SUM ( c.di042_u5 ) AS di042_u5,
	SUM ( c.di042_a5 ) AS di042_a5,
	SUM ( c.di043_u5 ) AS di043_u5,
	SUM ( c.di043_a5 ) AS di043_a5,
	SUM ( c.di044_u5 ) AS di044_u5,
	SUM ( c.di044_a5 ) AS di044_a5,
	SUM ( c.di045_u5 ) AS di045_u5,
	SUM ( c.di045_a5 ) AS di045_a5,
	SUM ( c.di046_u5 ) AS di046_u5,
	SUM ( c.di046_a5 ) AS di046_a5,
	SUM ( c.di047_u5 ) AS di047_u5,
	SUM ( c.di047_a5 ) AS di047_a5,
	SUM ( c.di048_u5 ) AS di048_u5,
	SUM ( c.di048_a5 ) AS di048_a5,
	SUM ( c.di049_u5 ) AS di049_u5,
	SUM ( c.di049_a5 ) AS di049_a5,
	SUM ( c.di050_u5 ) AS di050_u5,
	SUM ( c.di050_a5 ) AS di050_a5,
	SUM ( c.di051_u5 ) AS di051_u5,
	SUM ( c.di051_a5 ) AS di051_a5,
	SUM ( c.di052_u5 ) AS di052_u5,
	SUM ( c.di052_a5 ) AS di052_a5,
	SUM ( c.di005_u5 ) AS di005_u5,
	SUM ( c.di005_a5 ) AS di005_a5,
	SUM ( c.di053_u5 ) AS di053_u5,
	SUM ( c.di053_a5 ) AS di053_a5,
	SUM ( c.di054_u5 ) AS di054_u5,
	SUM ( c.di054_a5 ) AS di054_a5,
	SUM ( c.di055_u5 ) AS di055_u5,
	SUM ( c.di055_a5 ) AS di055_a5,
	SUM ( c.di056_u5 ) AS di056_u5,
	SUM ( c.di056_a5 ) AS di056_a5,
	SUM ( c.di057_u5 ) AS di057_u5,
	SUM ( c.di057_a5 ) AS di057_a5,
	SUM ( c.di058_u5 ) AS di058_u5,
	SUM ( c.di058_a5 ) AS di058_a5,
	SUM ( c.di059_u5 ) AS di059_u5,
	SUM ( c.di059_a5 ) AS di059_a5,
	SUM ( c.di060_u5 ) AS di060_u5,
	SUM ( c.di060_a5 ) AS di060_a5,
	SUM ( c.di061_u5 ) AS di061_u5,
	SUM ( c.di061_a5 ) AS di061_a5,
	SUM ( c.di062_u5 ) AS di062_u5,
	SUM ( c.di062_a5 ) AS di062_a5,
	SUM ( c.di063_u5 ) AS di063_u5,
	SUM ( c.di063_a5 ) AS di063_a5,
	SUM ( c.di064_u5 ) AS di064_u5,
	SUM ( c.di064_a5 ) AS di064_a5,
	SUM ( c.di010_u5 ) AS di010_u5,
	SUM ( c.di010_a5 ) AS di010_a5,
	SUM ( c.di065_u5 ) AS di065_u5,
	SUM ( c.di065_a5 ) AS di065_a5,
	SUM ( c.di066_u5 ) AS di066_u5,
	SUM ( c.di066_a5 ) AS di066_a5,
	SUM ( c.di067_u5 ) AS di067_u5,
	SUM ( c.di067_a5 ) AS di067_a5,
	SUM ( c.di068_u5 ) AS di068_u5,
	SUM ( c.di068_a5 ) AS di068_a5,
	SUM ( c.di069_u5 ) AS di069_u5,
	SUM ( c.di069_a5 ) AS di069_a5,
	SUM ( c.di019_u5 ) AS di019_u5,
	SUM ( c.di019_a5 ) AS di019_a5,
	SUM ( c.di070_u5 ) AS di070_u5,
	SUM ( c.di070_a5 ) AS di070_a5,
	SUM ( c.di071_u5 ) AS di071_u5,
	SUM ( c.di071_a5 ) AS di071_a5,
	SUM ( c.di072_u5 ) AS di072_u5,
	SUM ( c.di072_a5 ) AS di072_a5,
	SUM ( c.di073_u5 ) AS di073_u5,
	SUM ( c.di073_a5 ) AS di073_a5,
	SUM ( c.di074_u5 ) AS di074_u5,
	SUM ( c.di074_a5 ) AS di074_a5,
	SUM ( c.di075_u5 ) AS di075_u5,
	SUM ( c.di075_a5 ) AS di075_a5,
	SUM ( c.di016_u5 ) AS di016_u5,
	SUM ( c.di016_a5 ) AS di016_a5,
	SUM ( c.di076_u5 ) AS di076_u5,
	SUM ( c.di076_a5 ) AS di076_a5,
	SUM ( c.di077_u5 ) AS di077_u5,
	SUM ( c.di077_a5 ) AS di077_a5,
	SUM ( c.di078_u5 ) AS di078_u5,
	SUM ( c.di078_a5 ) AS di078_a5,
	SUM ( c.di079_u5 ) AS di079_u5,
	SUM ( c.di079_a5 ) AS di079_a5,
	SUM ( c.di080_u5 ) AS di080_u5,
	SUM ( c.di080_a5 ) AS di080_a5,
	SUM ( c.di081_u5 ) AS di081_u5,
	SUM ( c.di081_a5 ) AS di081_a5,
	SUM ( c.di096_u5 ) AS di096_u5,
	SUM ( c.di096_a5 ) AS i096_a5 
FROM
	camp_daily_progress AS c 
LEFT JOIN  camp_area AS a ON c.area_no= a.area_no AND ( a.colflag IS NULL OR a.colflag = 0 )
	$join
    $dist_where 
    $grp";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getSumDiagnosis()
    {
        $sql_query = "SELECT  	SUM( c.total_opd ) AS sum_total_opd,
	SUM ( c.total_under5 ) AS total_u5,
	(SUM ( c.total_opd ) - SUM ( c.total_under5 ) ) AS total_a5 
FROM
	camp_daily_progress AS c 
WHERE
	( c.colflag IS NULL OR c.colflag = '0' ) 
	AND c.di001_a5 IS NOT NULL";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
}