<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/2
 * Time: 12:06
 */
class followAjaxHelper extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('followModel');
        $this->load->model('userModel');
    }

    public function index()
    {
        echo 'haha';
    }

    public function toggleFollowing()
    {
        $followerId = $this->user->id;
        $followingId = $this->input->post('userId');
        echo $this->followModel->toggleFollowing($followerId, $followingId);
    }

    public function checkIfFollowing()
    {
        $userId = $this->input->post('userId');
        $myId = $this->user->id;
        $followerArray = $this->followModel->findFollowerByUserId($userId);
        $result = false;
        foreach ($followerArray as $follower) {
            if ($myId == $follower['followerId']) {
                $result = true;
            }
        }
        echo $result;
    }

    public function getCurrentUserFollowInfo()
    {
        $userId = $this->user->id;
        $resultArray = $this->getCountOfFollow($userId);
        echo json_encode($resultArray);
    }

    public function getUserFollowInfo()
    {
        $userId = $this->input->post('userId');
        $resultArray = $this->getCountOfFollow($userId);
        $user = $this->userModel->findUserById($userId);
        echo json_encode(array_merge($user,$resultArray));
    }

    private function getCountOfFollow($userId)
    {
        $followerArray = $this->followModel->findFollowerByUserId($userId);
        $followingArray = $this->followModel->findFollowingByUserId($userId);

        $result = array(
            'followerCnt' => count($followerArray),
            'followingCnt' => count($followingArray),
        );

        return $result;
    }
}