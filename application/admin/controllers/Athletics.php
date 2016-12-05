<?php
/**
 * Created by PhpStorm.
 * User: Akari
 * Date: 2016/12/3
 * Time: 上午8:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Athletics extends MY_Controller
{
    public function index()
    {
        $this->load->view('dashboard', $this->template_data);
    }

    function add()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
            $data = array(
                'user_id' => $this->user->id,
                'date' => $this->input->post('date'),
                'calories' => $this->input->post('calories'),
                'floors' => $this->input->post('floors'),
                'distance' => $this->input->post('distance'),
                'minSedentary' => $this->input->post('minSedentary'),
                'minLightlyActive' => $this->input->post('minLightlyActive'),
                'activeCalories' => $this->input->post('activeCalories'),
                'minAsleep' => $this->input->post('minAsleep'),
                'minAwake' => $this->input->post('minAwake'),
                'numAwakenings' => $this->input->post('numAwakenings'),
                'minBed' => $this->input->post('minBed'),
            );
            $this->db->insert('statistics', $data);
            json_response(array('success' => TRUE, 'msg' => 'Insert Success'));
        }else{
            json_response(array('success' => FALSE, 'msg' => 'Insert Fail'));
        }
    }
}