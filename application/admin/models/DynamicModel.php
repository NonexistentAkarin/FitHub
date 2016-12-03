<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/2
 * Time: 14:58
 */
class DynamicModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function findDynamicByUserId($userId){
        $this->db->select('rowid, *');
        $this->db->where('dynamic.deletedAt<', 0);
        $this->db->order_by('createdAt', 'DESC');
        $query = $this->db->get_where('dynamic',array('userId'=>$userId));
        return $query->result_array();
    }

    public function findDynamicsByUserIdArray($userIdArray){
        $this->db->select('rowid, *');
        $this->db->where('dynamic.deletedAt<', 0);
        $this->db->where_in('dynamic.userId', $userIdArray);
        $this->db->order_by('createdAt', 'DESC');
        $query = $this->db->get('dynamic');
        return $query->result_array();
    }

    public function insertDynamic($dynamicData){
        return $this->db->insert('dynamic', $dynamicData);
    }

    public function findLikeByDynamicId($dynamicId){
        $query = $this->db->get_where('dynamicLike',array('dynamicId'=>$dynamicId));
        return $query->result_array();
    }

    public function findLikesByDynamicIdArray($dynamicIdArray){
        $this->db->where_in('dynamicId', $dynamicIdArray);
        $query = $this->db->get('dynamicLike');
        return $query->result_array();
    }

    public function toggleLike($dynamicId,$userId){
        $query = $this->db->get_where('dynamicLike',array('userId' => $userId,
            'dynamicId'=>$dynamicId));
        $result = $query->row_array();
        if(count($result)>0){
            return $this->db->delete('dynamicLike', array('userId' => $userId,
                'dynamicId'=>$dynamicId));
        }else{
            $data = array(
                'dynamicId' => $dynamicId,
                'userId' => $userId,
                'createdAt' => time(),
            );
            return $this->db->insert('dynamicLike', $data);
        }
    }

    public function findCommentsByDynamicId($dynamicId){
        $query = $this->db->get_where('dynamicComment',array('dynamicId'=>$dynamicId));
        return $query->result_array();
    }

    public function insertComment($comment){
        return $this->db->insert('dynamicComment', $comment);
    }

    public function findDynamicsByLikes($userId){
        $query = $this->db->get_where('dynamicLike',array('userId'=>$userId));
        $likesArray = $query->result_array();
        $dynamicIdArray = array();
        foreach ($likesArray as $like){
            array_push($dynamicIdArray,$like['dynamicId']);
        }

        $this->db->select('rowid, *');
        $this->db->where_in('dynamic.rowid', $dynamicIdArray);
        $this->db->order_by('createdAt', 'DESC');
        $query = $this->db->get('dynamic');
        return $query->result_array();
    }

    public function findDynamicsByComments($userId){
        $query = $this->db->get_where('dynamicComment',array('userId'=>$userId));
        $commentsArray = $query->result_array();
        $dynamicIdArray = array();
        foreach ($commentsArray as $comment){
            array_push($dynamicIdArray,$comment['dynamicId']);
        }

        $this->db->select('rowid, *');
        $this->db->where_in('dynamic.rowid', $dynamicIdArray);
        $this->db->order_by('createdAt', 'DESC');
        $query = $this->db->get('dynamic');
        return $query->result_array();
    }

}