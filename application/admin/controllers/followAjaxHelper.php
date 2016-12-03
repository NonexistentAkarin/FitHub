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

    public function index(){
        echo 'haha';
    }

    public function toggleFollowing(){
        $followerId = $this->user->id;
        $followingId = $this->input->post('userId');
        echo $this->followModel->toggleFollowing($followerId,$followingId);
    }

    public function checkIfFollowing(){
        $userId = $this->input->post('userId');
        $myId = $this->user->id;
        $followerArray = $this->followModel->findFollowerByUserId($userId);
        $result = false;
        foreach ($followerArray as $follower){
            if($myId==$follower['followId']){
                $result = true;
            }
        }
        echo $result;
    }

    public function getCurrentUserFollowInfo(){
        $userId = $this->user->id;
        $resultArray = $this->getCountOfFollower($userId);
        $resultArray['userName'] = $this->user->username;
        echo json_encode($resultArray);
    }

    public function getUserFollowInfo(){
        $userId = $this->input->post('userId');
        $resultArray = $this->getCountOfFollower($userId);
        $user = $this->userModel->findUserById($userId);
        $resultArray['userName'] = $user['userName'];
        echo json_encode($resultArray);
    }

    private function getCountOfFollower($userId){
        $followerArray = $this->followModel->findFollowerByUserId($userId);
        $followingArray = $this->followModel->findFollowingByUserId($userId);
        $friendsCnt = 0;

        foreach ($followerArray as $follower){
            foreach ($followingArray as $following){
                if($follower==$following){
                    $friendsCnt++;
                }
            }
        }

        $result = array(
            'followerCnt'  => count($followerArray),
            'followingCnt'     => count($followingArray),
            'friendsCnt' =>$friendsCnt,
        );
        return $result;
    }
}