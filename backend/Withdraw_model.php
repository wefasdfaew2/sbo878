<?php

class Withdraw_model extends CI_Model {

    public function get_withdraw($withdraw_id = NULL) {
        if ($withdraw_id == NULL) {
            $this->db->from('withdraw_money');
            $this->db->join('withdraw_status', 'withdraw_status.withdraw_status_id = withdraw_money.withdraw_status_id');
            $this->db->where('withdraw_money.withdraw_status_id = 4 OR withdraw_money.withdraw_status_id = 5 OR withdraw_money.withdraw_status_id = 7');
            
            $this->db->order_by('withdraw_money.withdraw_regis', 'desc');
            return $this->db->get();
        } else {
            $this->db->from('withdraw_money');
            $this->db->join('withdraw_status', 'withdraw_status.withdraw_status_id = withdraw_money.withdraw_status_id');
            $this->db->where('withdraw_money.withdraw_id', $withdraw_id);
            return $this->db->get();
        }
    }

    public function edit_withdraw($data, $withdraw_id) {
        $this->db->where('withdraw_id', $withdraw_id);
        $this->db->update('withdraw_money', $data);
    }

    public function check_withdraw_account($withdraw_account) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $withdraw_account);
        return $this->db->count_all_results();
    }

    public function check_withdraw_name($withdraw_account, $withdraw_name) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $withdraw_account);
        $this->db->where('member_account.member_nickname', $withdraw_name);
        return $this->db->count_all_results();
    }

    public function check_withdraw_telephone($withdraw_account, $withdraw_telephone) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $withdraw_account);
        $this->db->where("member_account.member_telephone_1 = $withdraw_telephone OR member_account.member_telephone_2 = $withdraw_telephone");
        return $this->db->count_all_results();
    }

    public function check_withdraw_bank_account($withdraw_account, $withdraw_bank_account) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $withdraw_account);
        $this->db->where('member_account.member_bank_account', $withdraw_bank_account);
        return $this->db->count_all_results();
    }

    public function check_withdraw_bank_name($withdraw_account, $withdraw_bank_name) {
        $this->db->from('member_account');
        $this->db->join('sbobet_account', 'sbobet_account.sbobet_account_id = member_account.member_sbobet_account_id');
        $this->db->where('sbobet_account.sbobet_username', $withdraw_account);
        $this->db->where('member_account.member_bank_name', $withdraw_bank_name);
        return $this->db->count_all_results();
    }

}
