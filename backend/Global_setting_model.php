<?php

class Global_setting_model extends CI_Model {

    public function get_global_setting() {
      $re = $this->db->query("SELECT * FROM global_setting;");
      return $re;
    }

    public function set_global_setting($data) {

      $site_status = $data['site_underconstruction'];
      $deposit_auto_status = $data['sbobet_deposit_enable_by_cc'];
      $withdraw_status = $data['sbobet_withdraw_enable_by_cc'];
      $regis_status = $data['new_register_enable'];
      $inform_status = $data['announce_enable'];
      $inform_text = $data['announce_text'];

      $this->db->query("UPDATE global_setting
        SET site_underconstruction = '$site_status',
        sbobet_deposit_enable_by_cc = '$deposit_auto_status',
        sbobet_withdraw_enable_by_cc = '$withdraw_status',
        new_register_enable = '$regis_status',
        announce_enable = '$inform_status',
        announce_text = '$inform_text';");

    }

}
