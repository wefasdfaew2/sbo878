<?php

class Global_setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('backend_login_status') != 1) {
            redirect(base_url('backend/login'));
        }
        $this->load->model('backend/global_setting_model');
    }

    public function index() {
        $data = Array(
            'page_name' => 'global_setting'
        );
        $this->renderViewBackend('global_setting_view', $data);
    }

    public function set_status(){
      $form_data = $this->input->post();
      $site_status = $this->input->post("site_status");
      $deposit_auto_status = $this->input->post("deposit_auto_status");
      $withdraw_status = $this->input->post("withdraw_status");
      $regis_status = $this->input->post("regis_status");
      $inform_status = $this->input->post("inform_status");
      $inform_text = $this->input->post("inform_text");

      $data = array(
        'site_underconstruction' => $site_status,
        'sbobet_deposit_enable_by_cc' => $deposit_auto_status,
        'sbobet_withdraw_enable_by_cc' => $withdraw_status,
        'new_register_enable' => $regis_status,
        'announce_enable' => $inform_status,
        'announce_text' => $inform_text
      );
      
      $this->global_setting_model->set_global_setting($data);
      $this->session->set_flashdata('flash_message', '<h5 class="text-success"><i class="fa fa-check-circle fa-fw"></i>&nbsp;บันทึกรายเสร็จสมบูรณ์</h5>');
      redirect(base_url('backend/global_setting'));
    }


}
