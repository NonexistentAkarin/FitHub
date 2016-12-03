<?php
/**
 * Profile
 *
 * @author        Chaegumi
 * @copyright    Copyright (c) 2016~2099 cxpcms.com
 * @email        chaegumi@qq.com
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if(is_array($_GET)&&count($_GET)>1){
            $this->template_data['pid']=($_GET)['id'];
            $this->load->view('ruser', $this->template_data);
        }else{
            $this->load->view('profile', $this->template_data);
        }
    }

    function edit_settings()
    {
        $this->form_validation->set_rules('motto', 'New Motto', 'trim|required');
        $this->form_validation->set_rules('location', 'New Location', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            json_response(array('success' => FALSE, 'msg' => validation_errors()));
        } else {
            $this->db->where('id', $this->user->id);
            $data = array(
                'motto' => trim($this->input->post('motto')),
                'location' =>trim($this->input->post('location'))
            );
            $this->db->update('users', $data);
            json_response(array('success' => TRUE, 'msg' => 'Change Settings Success'));
        }
    }

    function edit_password()
    {
        $this->form_validation->set_rules('password', 'New Password', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            json_response(array('success' => FALSE, 'msg' => validation_errors()));
        } else {
            $this->db->where('id', $this->user->id);
            $data = array(
                'password' => password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT)
            );
            $this->db->update('users', $data);
            json_response(array('success' => TRUE, 'msg' => 'Change Password Success'));
        }
    }
}
// end this file