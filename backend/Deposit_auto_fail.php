<?php

class Deposit_auto_fail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('backend_login_status') != 1) {
            redirect(base_url('backend/login'));
        }
        $this->load->model('backend/deposit_model');
    }

    public function index() {
        $data = Array(
            'page_name' => 'deposit_auto_fail'
        );
        $this->renderViewBackend('deposit_auto_fail_view', $data);
    }

    public function set_5() {

      $deposit_amount = $this->input->post('deposit_amount');
      $firstpayment = $this->input->post('deposit_firstpayment_promotion_mark');
      $nexrpayment = $this->input->post('deposit_nextpayment_promotion_mark');
      $deposit_id = $this->input->post('deposit_id');
        $db_d_amount = floor($deposit_amount);

         if($db_d_amount >= 5000){
          if($firstpayment == 'Yes'){
            $deposit_amount_bonus = $db_d_amount * 2;
            $deposit_turnover = $db_d_amount * 8;
            if($deposit_amount_bonus > 1500){
              $deposit_amount_bonus = 1500;
            }
            $db_d_amount = $db_d_amount + $deposit_amount_bonus;
          }elseif($nexrpayment == 'Yes'){
            if($db_d_amount < 10000){
              $deposit_amount_bonus = 0.05 * $db_d_amount;
            }elseif($db_d_amount >= 10000){
              $deposit_amount_bonus = 0.1 * $db_d_amount;
            }
            $db_d_amount = $db_d_amount + $deposit_amount_bonus;
          }
        }

        /*$add_result = json_decode(add_credit(
          $deposit->deposit_id,
          $deposit->deposit_account,
          $deposit->deposit_bank_account,
          $db_d_amount),
        true);*/
        $result = '200';//$add_result["status"];
        if($result == '200'){
          $this->deposit_model->update_depodit_status($deposit_id, 5);
          if ($this->db->affected_rows() > 0)
          {
            $data = array('update_status' => 'OK');
            echo json_encode($data);
          }else {
            $data = array('update_status' => 'fail');
            echo json_encode($data);
          }
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



}
