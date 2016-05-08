<?php

class Deposit_model extends CI_Model {

    public function get_deposit($deposit_id = NULL) {
        if ($deposit_id == NULL) {
            $this->db->from('deposit_money');
            $this->db->join('deposit_status', 'deposit_status.deposit_status_id = deposit_money.deposit_status_id');
            $this->db->order_by('deposit_money.deposit_regis', 'desc');
            return $this->db->get();
        } else {
            $this->db->from('deposit_money');
            $this->db->join('deposit_status', 'deposit_status.deposit_status_id = deposit_money.deposit_status_id');
            $this->db->where('deposit_money.deposit_id', $deposit_id);
            return $this->db->get();
        }
    }

    public function edit_deposit($data, $deposit_id) {
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
