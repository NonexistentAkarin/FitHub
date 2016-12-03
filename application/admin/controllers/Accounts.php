<?php
/**
 * Users Manage
 *
 * @author        Chaegumi
 * @copyright    Copyright (c) 2016~2099 cxpcms.com
 * @email        chaegumi@qq.com
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->load->view('accounts', $this->template_data);
    }

    function data()
    {
        $response = new stdClass;
        $response->draw = $this->input->post('draw');

        $search = $this->input->post('search');
        $keyword = '';
        if ($search) $keyword = $search['value'];
        // $this->session->set_userdata('search', $search);
        // $perpage = 10;
        $this->db->select('count(A.id) as ccount', FALSE);
        $this->db->from('users A');
        if ($keyword) {
            $this->db->where('(A.username=' . $this->db->escape($keyword) . ' or A.email=' . $this->db->escape($keyword) . ')');
        }
        $q = $this->db->get()->row();
        $response->recordsTotal = $q->ccount;

        // $offset = $response->draw * $perpage;

        $this->db->select('A.*');
        $this->db->from('users A');
        if ($keyword) {
            $this->db->where('(A.username=' . $this->db->escape($keyword) . ' or A.email=' . $this->db->escape($keyword) . ')');
        }
        $this->db->order_by('A.id', 'desc');
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $results = $this->db->get()->result();

        $response->recordsFiltered = $response->recordsTotal;

        $response->data = array();
        $i = 1;
        foreach ($results as $row) {
            $data = array();
            $data['no'] = $i;
            $data['username'] = $row->username;
            $data['email'] = $row->email;
            $data['reg_time'] = $row->reg_time;
            $response->data[] = $data;
            $i++;
        }

        $this->output->set_output(json_encode($response));
    }
}
// end this file