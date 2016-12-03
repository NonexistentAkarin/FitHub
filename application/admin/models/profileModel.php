<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/1
 * Time: 23:13
 */
class profileModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function findProfileInfoById($userId)
    {
        $this->db->select('*');
        $query = $this->db->get_where('users', array('id' => $userId));
        return $query->row_array();
    }

    public function updateProfileInfoById($profile)
    {
        return $this->db->replace('users', $profile);
    }

}