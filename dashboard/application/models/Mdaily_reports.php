<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdaily_reports extends CI_Model
{

    function getTotalOPD($seachData)
    {
        $dist_where = 'where (camp_daily_progress.colflag is null OR camp_daily_progress.colflag = \'0\')  ';
        $sql_query = "SELECT SUM(total_opd) as opd,SUM(total_under5) as u5,SUM(total_wra) as wra, 
       SUM(total_pw) as pw,SUM(total_children_vaccinated) as children_vaccinated,
       SUM(total_wra_vaccinated) as wra_vaccinated,count(id) as total_daily_reports FROM camp_daily_progress $dist_where ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getTotalGraph($seachData)
    {
        $dist_where = 'where (camp_daily_progress.colflag is null OR camp_daily_progress.colflag = \'0\')  ';
        $sql_query = "SELECT SUM(total_opd) as opd,camp_day FROM camp_daily_progress $dist_where group by camp_day order by camp_day desc";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getReport($district, $ucs, $area, $day,$partner)
    {
        $dist_where = 'where (camp_daily_progress.colflag is null OR camp_daily_progress.colflag = \'0\')  ';

        if (isset($district) && $district != 0 && $district != '') {
            $dist_where .= " AND camp_daily_progress.dist_id = '$district' ";
        }
        if (isset($ucs) && $ucs != 0 && $ucs != '') {
            $dist_where .= " AND camp_daily_progress.ucCode = '$ucs' ";
        }

        if (isset($area) && $area != 0 && $area != '') {
            $dist_where .= " AND camp_daily_progress.area_no ='$area' ";
        }
        if (isset($partner) && $partner != 0 && $partner != '') {
            $dist_where .= " AND camp_area.partner_code ='$partner' ";
        }
        if (isset($day) && $day != 0 && $day != '') {
            $day_php=date('Y-m-d',strtotime($day));
            $dist_where .= " AND camp_daily_progress.camp_day ='$day_php' ";
        }

        $sql_query = "SELECT *
FROM
	 camp_daily_progress
	LEFT JOIN dbo.districts ON camp_daily_progress.dist_id = districts.dist_id
	LEFT JOIN dbo.UCs ON camp_daily_progress.ucCode = UCs.ucCode
	LEFT JOIN dbo.camp_area ON camp_daily_progress.area_no = camp_area.area_no  $dist_where 
order by id desc";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getAreasByUc($ucs, $round)
    {
        if (isset($ucs) && $ucs != '') {
            $this->db->where("ucCode", $ucs);
        }
        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("ucCode NOT LIKE '9%' ");
        }

        $this->db->select('area_no,area_name');
        $this->db->from('camp_area');
        $this->db->group_by('area_no');
        $this->db->group_by('area_name');
        $this->db->order_By('area_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getDaysByArea($area, $round)
    {
        if (isset($area) && $area != '') {
            $this->db->where("area_no", $area);
        }
        if (!isset($_SESSION['login']['idGroup']) || $this->encrypt->decode($_SESSION['login']['idGroup']) != 1) {
            $this->db->where("ucCode NOT LIKE '9%' ");
        }

        $this->db->select('execution_date');
        $this->db->from('camps');
        $this->db->group_by('execution_date');
        $this->db->order_By('execution_date', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    function getDashboardReport()
    {
        $sql_query = "SELECT
	d.dist_id,
	d.district,
	COUNT ( c.id ) AS num_of_days,
	SUM ( c.total_opd ) AS sum_total_opd,
	SUM ( c.total_wra ) AS sum_total_wra,
	SUM ( c.total_under5 ) AS sum_total_children 
FROM 
	camp_daily_progress c
	LEFT JOIN districts d ON c.dist_id= d.dist_id 
	AND ( d.colflag IS NULL OR d.colflag= 0 ) 
WHERE
	( c.colflag IS NULL OR c.colflag= 0 )  
GROUP BY
	d.dist_id,
	d.district";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
}