<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/1
 * Time: 23:16
 */
class profileAjaxHelper extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profileModel');
    }

    public function getCurrentProfileInfo(){
        $userId = $this->user->id;
        $userName = $this->user->username;
        $profileInfo = $this->profileModel->findProfileInfoById($userId);

        $profileInfo['userName'] = $userName;
        echo json_encode($profileInfo);
    }

    public function getUserProfileInfo(){
        $userId = $this->input->post('userId');
        $profileInfo = $this->profileModel->findProfileInfoById($userId);
        echo json_encode($profileInfo);
    }

}