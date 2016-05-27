<?php

class Deposit_model extends CI_Model {

    public function get_deposit($deposit_id = NULL) {
        if ($deposit_id == NULL) {

            $this->db->select('deposit_type_id')->from('deposit_type')->where('deposit_type_type','manual');
            $subQuery =  $this->db->get_compiled_select();

            $re = $this->db->select('*')
              ->from('deposit_money')
              ->join('deposit_status', 'deposit_status.deposit_status_id = deposit_money.deposit_status_id')
              ->where("deposit_type IN ($subQuery)", NULL, FALSE)
              ->order_by('deposit_id', 'desc')
              ->get();

            return $re;//$this->db->get();
        } else {
            $this->db->from('deposit_money');
            $this->db->join('deposit_status', 'deposit_status.deposit_status_id = deposit_money.deposit_status_id');
            $this->db->join('deposit_type', 'backend_deposit_type.deposit_type_id = backend_deposit_money.deposit_type');
            $this->db->where('deposit_money.deposit_id', $deposit_id);
            return $this->db->get();
        }
    }

    public function update_bonus_flag($deposit_id, $first, $next, $bonus, $turnover, $turnover_status) {
      $data = array(
        'deposit_amount_bonus' => $bonus,
        'deposit_turnover' => $turnover,
        'deposit_firstpayment_promotion_mark' => $first,
        'deposit_nextpayment_promotion_mark' => $next,
        'deposit_bot_tunover_check_mark' => $turnover_status
      );
      $this->db->where('deposit_id', $deposit_id);
      $this->db->update('deposit_money', $data);

    }

    public function get_deposit_enable(){
      //$this->db->set_dbprefix('');
      //$this->db->dbprefix('global_setting');

      //$re = $this->db->select('sbobet_deposit_enable')
      //->from($this->db->dbprefix('global_setting'))
      //->get();
      $re = $this->db->query("SELECT sbobet_deposit_enable FROM global_setting;");
      return $re;
    }

    public function get_regis_bank_by_username($username) {
      $re = $this->db->select('member_bank_name, member_bank_account')
        ->from('sbobet_account')
        ->join('member_account', 'member_account.member_sbobet_account_id = sbobet_account.sbobet_account_id')
        ->where('sbobet_account.sbobet_username', $username)
        ->get();

        return $re;
    }

    public function get_deposit_auto_fail() {
      $this->db->select('deposit_type_id')->from('deposit_type')->where('deposit_type_type','auto');;
      $subQuery =  $this->db->get_compiled_select();

      $re = $this->db->select('*')
        ->from('deposit_money')
        ->join('deposit_status', 'deposit_status.deposit_status_id = deposit_money.deposit_status_id')
        ->join('deposit_type', 'backend_deposit_type.deposit_type_id = backend_deposit_money.deposit_type')
        ->where("deposit_type IN ($subQuery)", NULL, FALSE)
        ->where('backend_deposit_money.deposit_status_id = 1 OR backend_deposit_money.deposit_status_id = 9')
        //->or_where('deposit_status_id', 9)
        ->order_by('deposit_id', 'desc')
        ->get();

      return $re;
    }

    public function get_member_data_by_bank_number($sbobet_username) {

      $this->db->select('sbobet_account_id')->from('backend_sbobet_account')->where('sbobet_username',"$sbobet_username");;
      $subQuery =  $this->db->get_compiled_select();

        $this->db->select('*')
        ->from('member_account')
        ->where("member_sbobet_account_id IN ($subQuery)", NULL, FALSE);

      return $this->db->get();
    }

    public function edit_deposit($data, $deposit_id) {
        $this->db->where('deposit_id', $deposit_id);
        $this->db->update('deposit_money', $data);
    }

    public function update_depodit_status($deposit_id, $deposit_status) {
      $data = array(
               'deposit_status_id' => $deposit_status
            );
        $this->db->where('deposit_id', $deposit_id);
        $this->db->update('deposit_money', $data);
    }

    public function check_deposit_account($deposit_account) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $deposit_account);
        return $this->db->count_all_results();
    }

    public function check_deposit_name($deposit_account, $deposit_name) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $deposit_account);
        $this->db->where('member_account.member_nickname', $deposit_name);
        return $this->db->count_all_results();
    }

    public function check_deposit_telephone($deposit_account, $deposit_telephone) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $deposit_account);
        $this->db->where("member_account.member_telephone_1 = $deposit_telephone OR member_account.member_telephone_2 = $deposit_telephone");
        return $this->db->count_all_results();
    }

    public function check_deposit_bank_account($deposit_bank_account) {
        $this->db->from('bank_account');
        $this->db->where('bank_account_number', $deposit_bank_account);
        return $this->db->count_all_results();
    }

    public function check_deposit_bank_name($deposit_bank_account, $deposit_bank_name) {
        $this->db->from('bank_account');
        $this->db->where('bank_account_number', $deposit_bank_account);
        $this->db->where('bank_name', $deposit_bank_name);
        return $this->db->count_all_results();
    }

}

/*
SELECT deposit_type
FROM backend_deposit_money
JOIN backend_deposit_type ON backend_deposit_type.deposit_type_id = backend_deposit_money.deposit_type

 WHERE backend_deposit_type.deposit_type_type = 'manual' AND backend_deposit_money.deposit_status_id = 1

 */
 /*
 SELECT phone, (SELECT COUNT(deposit_type)
 FROM backend_deposit_money
 JOIN backend_deposit_type ON backend_deposit_type.deposit_type_id = backend_deposit_money.deposit_type

  WHERE backend_deposit_type.deposit_type_type = 'manual' AND backend_deposit_money.deposit_status_id = 1 ) as deposit_wait_number
         FROM callcenter_number
 */
/*
SELECT *
FROM  `backend_deposit_money`
JOIN  `backend_deposit_status` ON  `backend_deposit_status`.`deposit_status_id` =  `backend_deposit_money`.`deposit_status_id`
JOIN  `backend_deposit_type` ON  `backend_deposit_type`.`deposit_type_id` =  `backend_deposit_money`.`deposit_type`
WHERE deposit_type
IN (

SELECT  `deposit_type_id`
FROM  `backend_deposit_type`
WHERE  `deposit_type_type` =  'auto'
)
AND  `backend_deposit_money`.`deposit_status_id` =1
OR  `backend_deposit_money`.`deposit_status_id` =9
ORDER BY  `deposit_id` DESC
LIMIT 0 , 30
*/
