<?php

class Deposit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('backend_login_status') != 1) {
            redirect(base_url('backend/login'));
        }
        $this->load->model('backend/deposit_model');
        $this->load->model('backend/sendsms_model');
        $this->load->model('backend/addcredit_model');
    }

    public function index() {
        $data = Array(
            'page_name' => 'deposit'
        );
        $this->renderViewBackend('deposit_view', $data);
    }

    public function set_5() {

      $deposit_amount = $this->input->post('deposit_amount');
      $db_d_firstpayment = $this->input->post('deposit_firstpayment_promotion_mark');
      $db_d_nextpayment = $this->input->post('deposit_nextpayment_promotion_mark');
      $deposit_id = $this->input->post('deposit_id');

      $db_d_amount = floor($deposit_amount);
      $ac_name = $this->input->post('deposit_account');
      $dest_account = $this->input->post('deposit_bank_account');
      $tel = $this->input->post('deposit_telephone');

      $deposit_amount_bonus = 0;
      $deposit_turnover = 0;


      if($db_d_amount >= 5000){
        if($db_d_firstpayment == 'Yes'){
          $check_turnover = 'Yes';
          $deposit_amount_bonus = $db_d_amount;
          $deposit_turnover = ($deposit_amount_bonus + $db_d_amount) * 8;
          if($deposit_amount_bonus > 1500){
            $deposit_amount_bonus = 1500;
          }
          if($deposit_turnover > 24000){
            $deposit_turnover = 24000;
          }
        }elseif($db_d_nextpayment == 'Yes'){
          $check_turnover = 'Yes';
          if($db_d_amount < 10000){
            $deposit_amount_bonus = 0.05 * $db_d_amount;
            $deposit_turnover =  ($deposit_amount_bonus + $db_d_amount) * 5;
          }elseif($db_d_amount >= 10000){
            $deposit_amount_bonus = 0.1 * $db_d_amount;
            $deposit_turnover =  ($deposit_amount_bonus + $db_d_amount)  * 5;
          }
        }else {
          $check_turnover = 'No';
          $db_d_firstpayment = 'No';
          $db_d_nextpayment = 'No';
        }
        $deposit_amount_bonus = round($deposit_amount_bonus, 2);
        $deposit_turnover = round($deposit_turnover, 2);
      }else {
        if($db_d_firstpayment == 'Yes'){
          $check_turnover = 'Yes';
          $deposit_amount_bonus = $db_d_amount;
          $deposit_turnover = ($deposit_amount_bonus + $db_d_amount) * 8;
          if($deposit_amount_bonus > 1500){
            $deposit_amount_bonus = 1500;
          }
          if($deposit_turnover > 24000){
            $deposit_turnover = 24000;
          }
        }else {
          $check_turnover = 'No';
          $db_d_firstpayment = 'No';
          $db_d_nextpayment = 'No';
        }
      }

        $money = $deposit_amount + $deposit_amount_bonus;
        $result = $this->addcredit_model->add_credit($deposit_id,$ac_name,$dest_account,$money,$tel);
        //$result = '200';//$add_result["status"];
        //error_log('result = '.$result);
        if($result == '200'){

          $this->deposit_model->update_depodit_status($deposit_id, 5);
          $this->deposit_model->update_bonus_flag($deposit_id, $db_d_firstpayment, $db_d_nextpayment, $deposit_amount_bonus, $deposit_turnover, $check_turnover);

          //if ($this->db->affected_rows() > 0)
          //{
            $data = array('update_status' => 'OK');
            echo json_encode($data);
        //  }else {
          //  $data = array('update_status' => $result);
            //echo json_encode($data);
        //  }
        }

    }

    public function set_6() {
      $deposit_id = $this->input->post('deposit_id');
      $this->deposit_model->update_depodit_status($deposit_id, 6);
      if ($this->db->affected_rows() > 0)
      {
        $data = array('update_status' => 'OK');
        echo json_encode($data);
      }else {
        $data = array('update_status' => 'fail');
        echo json_encode($data);
      }
    }

    public function set_3() {
      $deposit_id = $this->input->post('deposit_id');
      $this->deposit_model->update_depodit_status($deposit_id, 3);
      if ($this->db->affected_rows() > 0)
      {
        $data = array('update_status' => 'OK');
        echo json_encode($data);
      }else {
        $data = array('update_status' => 'fail');
        echo json_encode($data);
      }
    }

    public function confirm($deposit_id = NULL) {
        if ($deposit_id != NULL) {
            $get_deposit = $this->deposit_model->get_deposit($deposit_id)->row();
            if ($this->input->post('submit') == 5) {
                $this->systemlog_model->addlog('<i class="icon-ok"></i>&nbsp;อนุมัติรายการแจ้งฝาก >> บัญชี ' . $get_deposit->deposit_account .  ' ผ่านการอนุมัติแจ้งฝากเงินจำนวน ' . $get_deposit->deposit_amount . ' บาท');
            } else {
                $this->systemlog_model->addlog('<i class="icon-remove"></i>&nbsp;ไม่อนุมัติรายการแจ้งฝาก >> บัญชี ' . $get_deposit->deposit_account .  ' ไม่ผ่านการอนุมัติแจ้งฝากเงินจำนวน ' . $get_deposit->deposit_amount . ' บาท');
            }
            $data = array(
                'deposit_status_id' => $this->input->post('submit')
            );
            $this->deposit_model->edit_deposit($data, $deposit_id);
            $this->session->set_flashdata('flash_message', '<h5 class="text-success"><i class="fa fa-check-circle fa-fw"></i>&nbsp;การทำรายเสร็จสมบูรณ์</h5>');
            redirect(base_url('backend/deposit'));
        } else {
            $this->session->set_flashdata('flash_message', '<h5 class="text-danger"><i class="fa fa-exclamation-circle fa-fw"></i>&nbsp;เกิดข้อผิดพลาด! การทำรายการไม่สำเร็จ</h5>');
            redirect(base_url('backend/deposit'));
        }
    }

}
