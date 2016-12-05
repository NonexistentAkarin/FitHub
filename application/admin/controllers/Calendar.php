<?php
/**
 * Calendar
 *
 * @author        Chaegumi
 * @copyright    Copyright (c) 2016~2099 chaegumi
 * @email        chaegumi@qq.com
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Calendar extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->view('calendar', $this->template_data);
    }

    function my()
    {
        $this->load->view('my_calendar', $this->template_data);
    }

    function data()
    {
        $results = $this->db->get('events')->result();
        foreach ($results as $row) {
            $allDay = $row->allDay;
            $is_allDay = $allDay == 1 ? true : false;

            $hasEnd = $row->hasEnd;
            $hasEnd = $hasEnd == 1 ? true : false;

            $user_id = $row->user_id;
            $is_createdByUser = $user_id == $this->user->id ? true : false;

            $data[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'start' => date('Y-m-d H:i', strtotime($row->start)),
                'end' => date('Y-m-d H:i', strtotime($row->end)),
                'description' => $row->description,
                'allDay' => $is_allDay,
                'hasEnd' => $hasEnd,
                'backgroundColor' => $row->backgroundColor,
                'borderColor' => $row->borderColor,
                'editable' => $is_createdByUser
            );
        }

        json_response($data);
    }

    function data2()
    {
        $this->db->where('user_id', $this->user->id);
        $results = $this->db->get('events')->result();
        foreach ($results as $row) {
            $allDay = $row->allDay;
            $is_allDay = $allDay == 1 ? true : false;

            $hasEnd = $row->hasEnd;
            $hasEnd = $hasEnd == 1 ? true : false;

            $user_id = $row->user_id;
            $is_createdByUser = $user_id == $this->user->id ? true : false;

            $data[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'start' => date('Y-m-d H:i', strtotime($row->start)),
                'end' => date('Y-m-d H:i', strtotime($row->end)),
                'description' => $row->description,
                'allDay' => $is_allDay,
                'hasEnd' => $hasEnd,
                'backgroundColor' => $row->backgroundColor,
                'borderColor' => $row->borderColor,
                'editable' => $is_createdByUser
            );
        }

        json_response($data);
    }

    function add()
    {
        $start = $this->input->get('start');
        $this->template_data['start'] = $start;

        $end = $this->input->get('end');
        $this->template_data['end'] = $end;

        $this->template_data['main'] = 'events_edit';
        $this->load->view('dialog_layout', $this->template_data);
    }

    function get()
    {
        $id = intval($this->input->get('id'));

        $this->db->where('id', $id);
        $info = $this->db->get('events')->row();

        $this->template_data['info'] = $info;

        $this->template_data['main'] = 'events_edit';
        $this->load->view('dialog_layout', $this->template_data);
    }

    function edit()
    {
        $id = intval($this->input->get('id'));

        $this->db->where('id', $id);
        $info = $this->db->get('events')->row();

        $this->template_data['info'] = $info;
        $this->template_data['user_id'] = $this->user->id;
        $this->template_data['main'] = 'events_info';
        $this->load->view('dialog_layout', $this->template_data);
    }

    function save()
    {
        $this->form_validation->set_rules('title', '事件标题', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            json_response(array('success' => FALSE, 'msg' => validation_errors()));
        } else {
            $id = intval($this->input->post('id'));
            if ($id === 0) {
                $end = $this->input->post('end') . ' ' . $this->input->post('e_hour') . ':' . $this->input->post('e_minute');
                $start = $this->input->post('start') . ' ' . $this->input->post('s_hour') . ':' . $this->input->post('s_minute');
                $data = array(
                    'user_id' => $this->user->id,
                    'title' => trim($this->input->post('title')),
                    'start' => $start,
                    'end' => $end,
                    'description' => trim($this->input->post('description')),
                    'backgroundColor' => trim($this->input->post('backgroundColor')),
                    'borderColor' => trim($this->input->post('backgroundColor')),
                    'allDay' => $this->input->post('isallday'),
                    'hasEnd' => $this->input->post('isend'),
                    'addtime' => $_SERVER['REQUEST_TIME']
                );
                $this->db->insert('events', $data);
//				operation_log(array('user_id' => $this->user->id, 'content' => '添加事件：' . $data['title']));
                json_response(array('success' => TRUE, 'msg' => '添加事件成功'));
            } else {
                $end = $this->input->post('end') . ' ' . $this->input->post('e_hour') . ':' . $this->input->post('e_minute');
                $start = $this->input->post('start') . ' ' . $this->input->post('s_hour') . ':' . $this->input->post('s_minute');
                $data = array(
                    'title' => trim($this->input->post('title')),
                    'description' => trim($this->input->post('description')),
                    'start' => $start,
                    'end' => $end,
                    'backgroundColor' => trim($this->input->post('backgroundColor')),
                    'borderColor' => trim($this->input->post('backgroundColor')),
                    'allDay' => $this->input->post('isallday'),
                    'hasEnd' => $this->input->post('isend'),
                );
                $this->db->where('id', $id);
                $this->db->where('user_id', $this->user->id);
                $this->db->update('events', $data);
//				operation_log(array('user_id' => $this->user->id, 'content' => '修改事件：' . $data['title']));
                json_response(array('success' => TRUE, 'msg' => '修改事件成功'));

            }
        }
    }

    function participate()
    {
        $id = intval($this->input->post('id'));
        $query = $this->db->get_where('parts', array('event_id' => $id,
            'user_id' => $this->user->id));
        $result = $query->row_array();
        if (count($result) > 0) {
            $this->db->delete('parts', array('event_id' => $id,
                'user_id' => $this->user->id));
        } else {
            $data = array(
                'event_id' => $id,
                'user_id' => $this->user->id
            );
            $this->db->insert('parts', $data);
        }
        json_response(array('success' => TRUE, 'msg' => '参与事件成功'));
    }

    function ifParticipate()
    {
        $id = intval($this->input->post('id'));
        $query = $this->db->get_where('parts', array('event_id' => $id));
        $result = false;
        foreach ($query->result_array() as $follower) {
            if ($this->user->id == $follower['user_id']) {
                $result = true;
            }
        }
        echo $result;
    }

    function drag(){
//        $id = $_POST['id'];
//        $daydiff = (int)$_POST['daydiff']*24*60*60;
//        $minudiff = (int)$_POST['minudiff']*60;
//        $allday = $_POST['allday'];
//
//        echo("<script>console.log('".json_encode($allday)."');</script>");

//        $query  = mysql_query("select * from `calendar` where id='$id'");
//        $row = mysql_fetch_array($query);
//        //echo $allday;exit;
//        if($allday=="true"){
//            if($row['endtime']==0){
//                $sql = "update `calendar` set starttime=starttime+'$daydiff' where id='$id'";
//            }else{
//                $sql = "update `calendar` set starttime=starttime+'$daydiff',endtime=endtime+'$daydiff' where id='$id'";
//            }
//
//        }else{
//            $difftime = $daydiff + $minudiff;
//            if($row['endtime']==0){
//                $sql = "update `calendar` set starttime=starttime+'$difftime' where id='$id'";
//            }else{
//                $sql = "update `calendar` set starttime=starttime+'$difftime',endtime=endtime+'$difftime' where id='$id'";
//            }
//        }
//        $result = mysql_query($sql);
//        if(mysql_affected_rows()==1){
//            echo '1';
//        }else{
//            echo '出错了！';
//        }

    }

    function delete()
    {
        $id = intval($this->input->get('id'));
        $this->db->where('id', $id);
        $this->db->where('user_id', $this->user->id);
        $this->db->delete('events');
//		operation_log(array('user_id' => $this->user->id, 'content' => '删除事件：' . $id));
        json_response(array('success' => TRUE, 'msg' => '删除事件成功'));
    }
}
// end this file