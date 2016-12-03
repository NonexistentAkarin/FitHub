<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/1
 * Time: 23:37
 */
class profileFormHelper extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profileModel');
        $this->load->model('userModel');
    }

    public function updateCurrentProfileInfo()
    {
        $email = $this->input->post('email');
        $educationExperience = $this->input->post('educationExperience');
        $skills = $this->input->post('skills');
        $motto = $this->input->post('motto');
        $userId = $this->user->id;

        $profile = array(
            'userId' => $userId,
            'email' => $email,
            'educationExperience' => $educationExperience,
            'skills' => $skills,
            'motto' => $motto,
        );

        $result = $this->profileModel->updateProfileInfoById($profile);
        if ($result) {
            echo '修改成功';
        } else {
            echo '修改失败';
        }
    }

    public function modifyPassword()
    {
        $oldPsd = $this->input->post('oldPsd');
        $newPsd = $this->input->post('newPsd');
        $userId = $this->user->id;

        $user = $this->userModel->findUserById($userId);

        if ($user['password'] == $oldPsd) {
            $user['password'] = $newPsd;
        }
        $result = $this->userModel->updateUser($user);
        if ($result) {
            echo '修改成功';
        } else {
            echo '修改失败';
        }
    }
}