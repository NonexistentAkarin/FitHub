<?php
/**
 * Admin Welcome
 *
 * @author        Chaegumi
 * @copyright    Copyright (c) 2016~2099 cxpcms.com
 * @email        chaegumi@qq.com
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('server');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {

        // var_dump(FCPATH . 'server');
        $this->load->library('Member_acl');
        $member_acl1 = new Member_acl($this->user->id);

        if($member_acl1->userHasRole(4)){
            $this->load->view('welcome_message_user', $this->template_data);
        }else{
            $this->load->view('welcome_message', $this->template_data);
        }
    }

    public function dashboard()
    {
        $this->db->select('COUNT(*) as count, SUM("calories") as calSum, SUM("steps") as stpSum, SUM("distance") as disSum');
        $this->db->where('user_id', $this->user->id);
        $info = $this->db->get('statistics')->row();
        $this->template_data['info']=$info;

        $this->db->select('SUM("minAsleep") as sleepSum, SUM("calories") as calSum, SUM("steps") as stpSum, SUM("distance") as disSum');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-7 day\') and date(\'now\',\'-1 day\')');
        $info = $this->db->get('statistics')->row();
        $this->template_data['week_info']=$info;

        $this->db->select('SUM("minAsleep") as sleepSum, SUM("calories") as calSum, SUM("steps") as stpSum, SUM("distance") as disSum');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-14 day\') and date(\'now\',\'-8 day\')');
        $info = $this->db->get('statistics')->row();
        $this->template_data['last_week_info']=$info;

        $this->db->select('date,minAsleep,minAwake');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-7 day\') and date(\'now\',\'-1 day\')');
        $info = $this->db->get('statistics')->result();

        $date = array();
        $minAsleep = array();
        $minAwake = array();

        foreach ($info as $row) {
            $date[] = $row->date;
            $minAsleep[] = $row->minAsleep;
            $minAwake[] = $row->minAwake;
        }

        $this->template_data['date']=$date;
        $this->template_data['minAsleep']=$minAsleep;
        $this->template_data['minAwake']=$minAwake;

        $this->db->select('COUNT(*) as count');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-14 day\') and date(\'now\',\'-8 day\')');
        $this->db->where('"minAsleep" >= 480');
        $info = $this->db->get('statistics')->row();
        $this->template_data['sleep_count']=$info;

        $this->db->select('COUNT(*) as count');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-14 day\') and date(\'now\',\'-8 day\')');
        $this->db->where('"steps" >= 10000');
        $info = $this->db->get('statistics')->row();
        $this->template_data['stp_count']=$info;

        $this->db->select('COUNT(*) as count');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-14 day\') and date(\'now\',\'-8 day\')');
        $this->db->where('"distance" >= 5');
        $info = $this->db->get('statistics')->row();
        $this->template_data['dis_count']=$info;

        $this->db->select('COUNT(*) as count');
        $this->db->where('user_id', $this->user->id);
        $this->db->where('"date" BETWEEN date(\'now\',\'-14 day\') and date(\'now\',\'-8 day\')');
        $info = $this->db->get('statistics')->row();
        $this->template_data['count_count']=$info;

        $this->load->view('dashboard', $this->template_data);
    }

    public function users()
    {
        $this->load->view('users', $this->template_data);
    }

}
// end this file