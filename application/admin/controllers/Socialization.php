<?php
/**
 * Created by PhpStorm.
 * User: Akari
 * Date: 2016/12/3
 * Time: 上午8:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Socialization extends MY_Controller
{
    public function index()
    {
        $this->load->view('moments', $this->template_data);
    }

    public function myMoments()
    {
        $this->load->view('my_moments', $this->template_data);
    }

    public function myLikes()
    {
        $this->load->view('my_likes', $this->template_data);
    }

    public function myComments()
    {
        $this->load->view('my_comments', $this->template_data);
    }
}