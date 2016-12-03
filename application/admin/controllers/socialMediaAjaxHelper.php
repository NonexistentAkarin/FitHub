<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/2
 * Time: 15:02
 */
class socialMediaAjaxHelper extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dynamicModel');
        $this->load->model('followModel');
        $this->load->model('userModel');
    }

    public function getCurrentUserFollower(){
        $userId = $this->user->id;
        $followArray = $this->followModel->findFollowerAndUserNameByUserId($userId);
        echo json_encode($followArray);
    }

    public function getCurrentUserFollowing(){
        $userId = $this->user->id;
        $followArray = $this->followModel->findFollowingAndUserNameByUserId($userId);
        echo json_encode($followArray);
    }

    public function getCurrentUserLikesDynamic(){
        $userId = $this->user->id;
        $result = $this->dynamicModel->findDynamicsByLikes($userId);

        $userIdArray = array();
        foreach ($result as $dynamic){
            array_push($userIdArray,$dynamic['userId']);
        }
        $result = $this->addUserNameToDynamic($result,$userIdArray);
        $result = $this->addLikesCntToDynamic($result);
        echo json_encode($result);
    }

    public function getCurrentUserCommentsDynamic(){
        $userId = $this->user->id;
        $result = $this->dynamicModel->findDynamicsByComments($userId);

        $userIdArray = array();
        foreach ($result as $dynamic){
            array_push($userIdArray,$dynamic['userId']);
        }
        $result = $this->addUserNameToDynamic($result,$userIdArray);
        $result = $this->addLikesCntToDynamic($result);
        echo json_encode($result);
    }

    public function getCurrentUserAndFollowingDynamic(){
        $userId = $this->user->id;
        $followingArray = $this->followModel->findFollowingByUserId($userId);
        $userIdArray=array($userId);
        foreach ($followingArray as $following){
            array_push($userIdArray,$following['followingId']);
        }
        $result = $this->dynamicModel->findDynamicsByUserIdArray($userIdArray);
        $result = $this->addUserNameToDynamic($result,$userIdArray);
        $result = $this->addLikesCntToDynamic($result);
        echo json_encode($result);
    }

    public function getCurrentUserDynamic(){
        $userId = $this->user->id;
        $userIdArray=array($userId);
        $result = $this->dynamicModel->findDynamicsByUserIdArray($userIdArray);
        $result = $this->addUserNameToDynamic($result,$userIdArray);
        $result = $this->addLikesCntToDynamic($result);
        echo json_encode($result);
    }

    private function addUserNameToDynamic($dynamics,$userIdArray){
        $userArray = $this->userModel->findUsersByIdArray($userIdArray);
        $result = array();
        foreach ($dynamics as $dynamic){
            foreach ($userArray as $user){
                if($dynamic['userId']==$user['id']){
                    $dynamic['userName']=$user['username'];
                    break;
                }
            }
            array_push($result,$dynamic);
        }
        return $result;
    }

    private function addLikesCntToDynamic($dynamics){
        $userId = $this->user->id;
        $dynamicIdArray = array();
        foreach ($dynamics as $dynamic){
            array_push($dynamicIdArray,$dynamic['rowid']);
        }
        $likesArray = $this->dynamicModel->findLikesByDynamicIdArray($dynamicIdArray);

        $result = array();
        foreach ($dynamics as $dynamic){
            $dynamic['likesCnt'] = 0;
            $dynamic['isLike'] = false;
            foreach ($likesArray as $like){
                if($dynamic['rowid']==$like['dynamicId']){
                    $dynamic['likesCnt']++;
                    if($like['userId']==$userId){
                        $dynamic['isLike'] = true;
                    }
                }
            }
            array_push($result,$dynamic);
        }

        return $result;

    }

    public function toggleLike(){
        $userId = $this->user->id;
        $dynamicId = $this->input->post('dynamicId');
        echo $this->dynamicModel->toggleLike($dynamicId,$userId);
    }

    public function getCommentsByDynamicId(){
        $dynamicId = $this->input->post('dynamicId');
        $comments = $this->dynamicModel->findCommentsByDynamicId($dynamicId);
        $userIdArray=array();
        foreach ($comments as $comment){
            array_push($userIdArray,$comment['userId']);
        }
        $comments=$this->addUserNameToComments($comments,$userIdArray);

        echo json_encode($comments);
    }

    private function addUserNameToComments($comments,$userIdArray){
        $userArray = $this->userModel->findUsersByIdArray($userIdArray);
        $result = array();
        foreach ($comments as $comment){
            foreach ($userArray as $user){
                if($comment['userId']==$user['id']){
                    $comment['userName']=$user['username'];
                    break;
                }
            }
            array_push($result,$comment);
        }
        return $result;
    }

    public function releaseComment(){
        $dynamicId = $this->input->post('dynamicId');
        $content = $this->input->post('content');
        $userId = $this->user->id;

        $comment = array(
            'dynamicId' => $dynamicId,
            'content' => $content,
            'userId' => $userId,
            'createdAt' => time(),
            'updatedAt' => time(),
        );
        $this->dynamicModel->insertComment($comment);

        $comment['userName'] = $this->user->username;

        echo json_encode($comment);
    }

}