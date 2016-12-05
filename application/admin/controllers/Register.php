<?php
/**
 * Register
 *
 * @author        Chaegumi
 * @copyright    Copyright (c) 2016~2099 cxpcms.com
 * @email        chaegumi@qq.com
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function index()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
            $this->load->helper(array('server'));

            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('re_password', 'Password Confirmation', 'trim|required|matches[password]');

            if ($this->form_validation->run() === FALSE) {
                json_response(array('success' => FALSE, 'msg' => validation_errors()));
            } else {
                $this->db->trans_begin();
                $data = array(
                    'username' => trim($this->input->post('username')),
                    'email' => trim($this->input->post('email')),
                    'password' => password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT)
                );
                $this->db->insert('users', $data);
                $new_user_id = $this->db->insert_id();

                // set user roles
                $sql = 'INSERT INTO user_roles(userID, roleID) VALUES (' . $new_user_id . ', 4)';
                $this->db->query($sql);
            }
            $this->db->trans_complete();
            json_response(array('success' => TRUE, 'msg' => 'Register Success'));
        } else {
            $this->load->view('register');
        }
    }

    function save()
    {
        $id = intval($this->input->post('id'));
        $name = $this->input->post('username');
        $email = $this->input->post('email');
        if (!preg_match("/^[a-zA-Z ]*$/",$name)||!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
            json_response(array('success' => FALSE, 'msg' => validation_errors()));
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            json_response(array('success' => FALSE, 'msg' => validation_errors()));
        } else {
            if ($id == 0) {
                check_permission('admin-add-user');
                $this->db->trans_begin();
                $data = array(
                    'username' => trim($this->input->post('username')),
                    'email' => trim($this->input->post('email')),
                    'status' => intval($this->input->post('status')),
                    'password' => password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT)
                );
                $this->db->insert('users', $data);
                $new_user_id = $this->db->insert_id();

                // set user roles
                $rolesarr = $this->input->post('roles');
                if ($rolesarr) {
                    $sql = 'INSERT INTO user_roles(userID, roleID) VALUES';
                    $tstr = '';
                    foreach ($rolesarr as $v) {
                        $tstr .= '(' . $new_user_id . ', ' . $v . '),';
                    }
                    if ($tstr != '') {
                        $sql .= rtrim($tstr, ',');
                        $this->db->query($sql);
                    }
                }
                $this->db->trans_complete();
                json_response(array('success' => TRUE, 'msg' => 'Add User Success'));
            } else {
                check_permission('admin-edit-user');
                $this->db->trans_begin();
                $data = array(
                    'username' => trim($this->input->post('username')),
                    'email' => trim($this->input->post('email')),
                    'status' => intval($this->input->post('status'))
                );
                $this->db->where('id', $id);
                $this->db->update('users', $data);
                // User Roles
                $rolesarr = $this->input->post('roles');
                if ($rolesarr) {
                    // Delete Old User Roles
                    $this->db->where('userID', $id);
                    $this->db->delete('user_roles');
                    $sql = 'INSERT INTO user_roles(userID, roleID) VALUES';
                    $tstr = '';
                    foreach ($rolesarr as $v) {
                        $tstr .= '(' . $id . ', ' . $v . '),';
                    }
                    if ($tstr != '') {
                        $sql .= rtrim($tstr, ',');
                        $this->db->query($sql);
                    }
                }
                $this->db->trans_complete();
                json_response(array('success' => TRUE, 'msg' => 'Edit User Success'));
            }

        }
    }
}
// end this file