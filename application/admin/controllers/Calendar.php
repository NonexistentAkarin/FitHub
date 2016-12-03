<?php 
/**
 * Calendar
 *
 * @author		Chaegumi
 * @copyright	Copyright (c) 2016~2099 chaegumi
 * @email		chaegumi@qq.com
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Calendar extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		check_permission('admin-events');
	}
	
	function index(){
		$this->load->view('calendar', $this->template_data);
	}
	
	function data(){
		$results = $this->db->get('events')->result();
		foreach($results as $row){
            $allDay = $row->allDay;
            $is_allDay = $allDay==1?true:false;

            $hasEnd = $row->hasEnd;
            $hasEnd = $hasEnd==1?true:false;

            $user_id = $row->user_id;
            $is_createdByUser = $user_id==$this->user->id?true:false;

            $data[] = array(
                'id' => $row->id,
                'title' => $row->title,
                'start' => date('Y-m-d H:i',strtotime($row->start)),
                'end' => date('Y-m-d H:i',strtotime($row->end)),
                'description' => $row->description,
                'allDay' => $is_allDay,
                'hasEnd' =>$hasEnd,
                'backgroundColor' => $row->backgroundColor,
                'borderColor' => $row->borderColor,
                'editable' =>$is_createdByUser
            );
		}

		json_response($data);
	}
	
	function add(){
		check_permission('admin-add-event');
		$start = $this->input->get('start');
		$this->template_data['start'] = $start;
		
		$end = $this->input->get('end');
		$this->template_data['end'] = $end;
		
		$this->template_data['main'] = 'events_edit';
		$this->load->view('dialog_layout', $this->template_data);
	}
	
	function edit(){
		check_permission('admin-edit-event');
		$id = intval($this->input->get('id'));
		
		$this->db->where('id', $id);
		$info = $this->db->get('events')->row();
		
		$this->template_data['info'] = $info;
		
		$this->template_data['main'] = 'events_edit';
		$this->load->view('dialog_layout', $this->template_data);
	}
	
	function save(){
		$this->form_validation->set_rules('title', '事件标题', 'trim|required');
		if($this->form_validation->run() === FALSE){
			json_response(array('success' => FALSE, 'msg' => validation_errors()));
		}else{
			$id = intval($this->input->post('id'));
			if($id === 0){
				check_permission('admin-add-event');
                $end = $this->input->post('end').' '.$this->input->post('e_hour').':'.$this->input->post('e_minute');
                $start = $this->input->post('start').' '.$this->input->post('s_hour').':'.$this->input->post('s_minute');
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
			}else{
				check_permission('admin-edit-event');
                $end = $this->input->post('end').' '.$this->input->post('e_hour').':'.$this->input->post('e_minute');
                $start = $this->input->post('start').' '.$this->input->post('s_hour').':'.$this->input->post('s_minute');
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
	
	function delete(){
		check_permission('admin-del-event');
		$id = intval($this->input->get('id'));
		$this->db->where('id', $id);
		$this->db->where('user_id', $this->user->id);
		$this->db->delete('events');
//		operation_log(array('user_id' => $this->user->id, 'content' => '删除事件：' . $id));
		json_response(array('success' => TRUE, 'msg' => '删除事件成功'));
	}
}
// end this file