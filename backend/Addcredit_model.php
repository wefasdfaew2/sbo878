<?php

class Addcredit_model extends CI_Model {

    public function add_credit($dp_id,$ac_name,$dest_account,$money,$tel){

      $deposit_data = $this->db->select('deposit_status_id')
        ->from('deposit_money')
        ->where('deposit_id', $dp_id)
        ->get();

        foreach ($deposit_data->result() as $row)
        {
            $deposit_status_id =  $row->deposit_status_id;
            break;
        }


      if($deposit_status_id == 1 || $deposit_status_id == 4 || $deposit_status_id == 3){

        if($deposit_status_id == 1){
          $data = array('deposit_status_id' => '2');
          $this->db->where('deposit_id', $dp_id);
          $this->db->update('deposit_money', $data);

        }elseif ($deposit_status_id == 3) {
          $data = array('deposit_status_id' => '4');
          $this->db->where('deposit_id', $dp_id);
          $this->db->update('deposit_money', $data);

        }
        $res = file_get_contents("http://zkc8688_add_value.service/".$dp_id."/".$ac_name."/".$dest_account."/".$money."");
        $add_result = json_decode($res, true);
        $result = $add_result["status"];
        if($result == '200'){
          $message = 'เติมเครดิเข้าบัญชี '.$ac_name.' จำนวน '.$money.' บาท สำเร็จแล้ว';
          $this->sendsms_model->sendsms($tel, $message, 1);
        }else {
          $result = $add_result;
        }
        return $result;
      }
    }
}
