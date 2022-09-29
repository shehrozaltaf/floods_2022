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
 
    function getAllEntry_status($district, $ucs, $username, $day )
    {
        $dist_where = 'where (a.colflag is null OR a.colflag = \'0\')  ';
        if (isset($district) && $district != 0 && $district != '') {
            $dist_where .= " AND LEFT ( a.ss102, 3 ) = '$district' ";
        }
        if (isset($ucs) && $ucs != 0 && $ucs != '') {
            $dist_where .= " AND LEFT ( a.ss102, 5 ) = '$ucs' ";
        }
 
        if (isset($username) && $username != 0 && $username != '') {
            $dist_where .= " AND a.username = '$username' ";
        }

        if (isset($day) && $day != 0 && $day != '') {
            $day_php = date('Y-m-d', strtotime($day));
            $dist_where .= " AND LEFT ( sysdate, 10 ) ='$day_php' ";
        } 

        $sql_query = "SELECT
        a.ss102 AS camp_no,
        LEFT ( a.ss102, 3 ) AS distcode,
        LEFT ( a.ss102, 5 ) AS uccode,
        d.district,
        b.ucname,
        u.full_name,
        LEFT ( sysdate, 10 ) AS entdt,
        COUNT ( * ) AS nn 
        FROM
        dtl_patient a
        LEFT JOIN Floods_2022.dbo.districts d ON LEFT ( a.ss102, 3 ) = d.dist_id
        LEFT JOIN Floods_2022.dbo.UCs b ON LEFT ( a.ss102, 5 ) = b.ucCode
        LEFT JOIN floods_2022.dbo.users u ON a.username= u.username 
        $dist_where
        GROUP BY
        a.ss102,
        LEFT ( a.ss102, 3 ),
        LEFT ( a.ss102, 5 ),
        d.district,
        b.ucname,
        u.full_name,
        LEFT ( sysdate, 10 ) 
        ORDER BY
        camp_no,
        LEFT ( sysdate, 10 )";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

     
}