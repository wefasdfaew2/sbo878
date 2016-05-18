<?php

class Withdraw extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('backend_login_status') != 1) {
            redirect(base_url('backend/login'));
        }
        $this->load->model('backend/withdraw_model');
        $this->load->model('backend/sendsms_model');
    }

    public function index() {
        $data = Array(
            'page_name' => 'withdraw'
        );
        $this->renderViewBackend('withdraw_view', $data);
    }

    public function confirm($withdraw_id = NULL) {
        if ($withdraw_id != NULL) {
            $get_withdraw = $this->withdraw_model->get_withdraw($withdraw_id)->row();
            if ($this->input->post('submit') == 2) {
                $this->systemlog_model->addlog('<i class="icon-ok"></i>&nbsp;อนุมัติรายการแจ้งถอน >> บัญชี ' . $get_withdraw->withdraw_account .  ' ผ่านการอนุมัติแจ้งฝากเงินจำนวน ' . $get_withdraw->withdraw_amount . ' บาท');
            } else {
                $this->systemlog_model->addlog('<i class="icon-remove"></i>&nbsp;ไม่อนุมัติรายการแจ้งถอน >> บัญชี ' . $get_withdraw->withdraw_account .  ' ไม่ผ่านการอนุมัติแจ้งฝากเงินจำนวน ' . $get_withdraw->withdraw_amount . ' บาท');
            }
            $data = array(
                'withdraw_status_id' => $this->input->post('submit')
            );
            $this->withdraw_model->edit_withdraw($data, $withdraw_id);
            $sms_text = 'ระบบได้ทำการโอนเงินรายการถอนที่ '.$withdraw_id.' เรียบร้อยแล้ว';
            $this->session->set_flashdata('flash_message', '<h5 class="text-success"><i class="fa fa-check-circle fa-fw"></i>&nbsp;การทำรายเสร็จสมบูรณ์</h5>');

            $this->sendsms_model->sendsms($get_withdraw->withdraw_telephone,$sms_text,2);
            redirect(base_url('backend/withdraw'));
        } else {
            $this->session->set_flashdata('flash_message', '<h5 class="text-danger"><i class="fa fa-exclamation-circle fa-fw"></i>&nbsp;เกิดข้อผิดพลาด! การทำรายการไม่สำเร็จ</h5>');
            redirect(base_url('backend/withdraw'));
        }
    }

}
