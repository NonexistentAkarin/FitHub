<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/2
 * Time: 11:56
 */
class FollowModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function toggleFollowing($followerId, $followingId)
    {
        $query = $this->db->get_where('follow', array('followerId' => $followerId,
            'followingId' => $followingId));
        $result = $query->row_array();
        if (count($result) > 0) {
            return $this->db->delete('follow', array('followerId' => $followerId,
                'followingId' => $followingId));
        } else {
            $data = array(
                'followerId' => $followerId,
                'followingId' => $followingId,
                'createdAt' => time(),
            );
            return $this->db->insert('follow', $data);
        }
    }

    public function findFollowerByUserId($userId)
    {
        $query = $this->db->get_where('follow', array('followingId' => $userId));
        return $query->result_array();
    }

    public function findFollowerAndUserNameByUserId($userId)
    {
        $this->db->select('follow.*,users.username,users.motto');
        $this->db->from('follow');
        $this->db->join('users', 'users.id = follow.followerId');
        $this->db->where('followingId', $userId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function findFollowingAndUserNameByUserId($userId)
    {
        $this->db->select('follow.*,users.username,users.motto');
        $this->db->from('follow');
        $this->db->join('users', 'users.id = follow.followingId');
        $this->db->where('followerId', $userId);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function findFollowingByUserId($userId)
    {
        $query = $this->db->get_where('follow', array('followerId' => $userId));
        return $query->result_array();
    }
}