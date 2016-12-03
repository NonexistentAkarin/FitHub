<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/11/29
 * Time: 10:28
 */
class UserModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function findUserById($id){
        $this->db->select('rowid, *');
        $query = $this->db->get_where('user',array('rowId'=>$id));
        return $query->row_array();
    }

    public function findUsersByIdArray($userIdArray){
        $this->db->select('id, userName');
        $this->db->where_in('id', $userIdArray);
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function findUserByAccount($account){
        $this->db->select('rowid, *');
        $query = $this->db->get_where('users',array('account'=>$account));
        return $query->row_array();
    }

    public function findUserByUserName($userName){
        $this->db->select('rowid, *');
        $query = $this->db->get_where('user',array('userName'=>$userName));
        return $query->row_array();
    }

    public function findALL(){
        $this->db->select('rowid, *');
        $query = $this->db->get('user');
        return $query->result_array();
    }

    public function insertUser($userAttrArray){
        $result = $this->db->insert('user', $userAttrArray);
        return $result;
    }

    public function updateUser($user){
        $this->db->where('rowid', $user['rowid']);
        return $this->db->update('user', $user);
    }
}