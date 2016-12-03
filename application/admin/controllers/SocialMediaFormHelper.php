<?php

/**
 * Created by PhpStorm.
 * User: dyp
 * Date: 2016/12/2
 * Time: 20:43
 */
class SocialMediaFormHelper extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dynamicModel');
    }

    public function index(){
        echo 'haha';
    }

    public function releaseDynamic(){
        $userId = $this->user->id;
        $content = $this->input->post('dynamic-content');
        $dynamic = array(
            'userId' => $userId,
            'content' => $content,
            'createdAt' => time(),
            'updatedAt' => time(),
        );
        $result = $this->dynamicModel->insertDynamic($dynamic);
        if($result){
            redirect(base_url().'admin.php#/Socialization/');
        }else{
            echo "发布动态失败";
        }
    }
}