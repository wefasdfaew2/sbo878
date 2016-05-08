<?php
    $deposit = $this->deposit_model->get_deposit($param1)->row();
?>


<div class="modal-header" style="padding:8px;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title text-center"><i class="icon-download-alt"></i> ตรวจสอบการแจ้งฝาก</h4>
</div>
<div class="modal-body" style="padding:10px;">
    <form class="form-horizontal" accept-charset="utf-8">
    <!--<form class="form-horizontal" method="post" action="<?php echo base_url() . 'backend/deposit/confirm/' . $deposit->deposit_id; ?>" enctype="multipart/form-data" accept-charset="utf-8">-->
        <input type="hidden" name="deposit_id" value="<?php echo $deposit->deposit_id; ?>" >
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">สถานะรายการ : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $lable_status = '';
                        $icon_status = '';

                        if ($deposit->deposit_status_id == 1) {
                            $lable_status = 'label label-sm label-warning';
                            $icon_status = 'icon-question-sign';
                        } else if ($deposit->deposit_status_id == 5) {
                            $lable_status = 'label label-sm label-success';
                            $icon_status = 'icon-ok';
                        } else {
                            $lable_status = 'label label-sm label-danger';
                            $icon_status = 'icon-remove';
                        }
                    ?>
                    <span class="<?php echo $lable_status; ?> checkbox-inline"><i class="<?php echo $icon_status; ?>"></i> <?php echo $deposit->deposit_status_name; ?></span>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ชื่อบัญชี : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_account = $this->deposit_model->check_deposit_account($deposit->deposit_account);
                    ?>
                    <i class="<?php if ($check_account == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $deposit->deposit_account; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ชื่อสมาชิก : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_nickname = $this->deposit_model->check_deposit_name($deposit->deposit_account,$deposit->deposit_nickname);
                    ?>
                    <i class="<?php if ($check_nickname == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $deposit->deposit_nickname; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เบอร์โทรศัพท์ : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_telephone = $this->deposit_model->check_deposit_telephone($deposit->deposit_account,$deposit->deposit_telephone);
                    ?>
                    <i class="<?php if ($check_telephone == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $deposit->deposit_telephone; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ธนาคาร : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_bank_name = $this->deposit_model->check_deposit_bank_name($deposit->deposit_bank_account,$deposit->deposit_bank_name);
                    ?>
                    <i class="<?php if ($check_bank_name == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $deposit->deposit_bank_name; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เลขบัญชี : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_bank_account = $this->deposit_model->check_deposit_bank_account($deposit->deposit_bank_account);
                    ?>
                    <i class="<?php if ($check_bank_account == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $deposit->deposit_bank_account; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">จำนวนเงิน : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php echo $deposit->deposit_amount; ?> บาท
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ประเภท : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php echo $deposit->deposit_type; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เวลา : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php echo $this->mydate->date2thai($deposit->deposit_date . ' ' . $deposit->deposit_time, '%d %m %y เวลา %h:%i'); ?>
                </p>
            </div>
        </div>
        <?php
            if ($deposit->deposit_evidence != '-') {
        ?>
        <div class="form-group" style="margin:0px auto;">
            <img src="<?php echo base_url("assets/upload/deposit/$deposit->deposit_evidence"); ?>" id="show_evidence" style="display:none; cursor:pointer; width:100%; border:1px #000000 solid; z-index:5;"/>
        </div>
        <?php
            }
        ?>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">หลักฐานการฝาก : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        if ($deposit->deposit_evidence != '-') {
                    ?>
                    <span id="open_evidence" class="text-primary" style="cursor:pointer;"><i class="icon-ok"></i> เปิดดูหลักฐานการฝาก</span>
                    <?php
                        } else {
                            echo 'ไม่ระบุ';
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เลขบัญชีของลูกค้าที่ใช้โอนเงินเข้ามา : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $meber_data = $this->deposit_model->get_member_data_by_bank_number($deposit->deposit_account)->row();
                        if($meber_data->member_bank_account == $deposit->deposit_cc_notice){
                          $bank_name = $meber_data->member_bank_name;
                        }else if($meber_data->member_bank_account_2 == $deposit->deposit_cc_notice){
                          $bank_name = $meber_data->member_bank_name_2;
                        }else if($meber_data->member_bank_account_3 == $deposit->deposit_cc_notice){
                          $bank_name = $meber_data->member_bank_name_3;
                        }else {
                          $bank_name = 'ไม่พบเลขบัญชีที่ตรงกัน';
                        }
                        echo 'ธนาคาร  '.$bank_name.'<br>';
                        echo 'เลขบัญชี '.$deposit->deposit_cc_notice;
                        //echo $bank_name;
                    ?>

                </p>
            </div>
        </div>
        <div class="form-group" style="margin-top:20px; margin-bottom:7px !important;">
            <div class="col-lg-12 text-center">
		            <div class="btn btn-primary" id="change_status" > เปลี่ยนสถานะเป็นกำลังตรวจสอบโดย Call Center</div>&nbsp;&nbsp;
                <div class="btn btn-primary" id="ok" ><i class="icon-ok"></i> อนุมัติ</div>&nbsp;&nbsp;
                <div class="btn btn-danger" id="not_ok" ><i class="icon-remove"></i> ไม่อนุมัติ</div>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <?php
      $db_d_amount = floor($deposit->deposit_amount);

       if($db_d_amount >= 5000){
        if($deposit->deposit_firstpayment_promotion_mark == 'Yes'){
          $deposit_amount_bonus = $db_d_amount * 2;
          $deposit_turnover = $db_d_amount * 8;
          if($deposit_amount_bonus > 1500){
            $deposit_amount_bonus = 1500;
          }
          $db_d_amount = $db_d_amount + $deposit_amount_bonus;
        }elseif($deposit->deposit_nextpayment_promotion_mark == 'Yes'){
          if($db_d_amount < 10000){
            $deposit_amount_bonus = 0.05 * $db_d_amount;
          }elseif($db_d_amount >= 10000){
            $deposit_amount_bonus = 0.1 * $db_d_amount;
          }
          $db_d_amount = $db_d_amount + $deposit_amount_bonus;
        }
      }


    ?>
    <script>

        $( document ).ready(function() {
          var status_id = <?php echo $deposit->deposit_status_id; ?>;
          if(status_id == 3){
            $( "div#ok" ).removeClass( "disabled" );
            $( "div#not_ok" ).removeClass( "disabled" );
            $( "div#change_status" ).addClass( "disabled" );
          }else if (status_id == 5 || status_id == 6) {
            $( "div#ok" ).addClass( "disabled" );
            $( "div#not_ok" ).addClass( "disabled" );
            $( "div#change_status" ).addClass( "disabled" );
          }else {
            $( "div#ok" ).addClass( "disabled" );
            $( "div#not_ok" ).addClass( "disabled" );
            //$( "div#change_status" ).addClass( "disabled" );
          }

          $("#open_evidence").click(function(){
              $("#show_evidence").show();
          });
          $("#show_evidence").click(function(){
              $("#show_evidence").hide();
          });

          $( "div#ok" ).on( "click", function() {
            console.log('ok_clicked');

            var data = {};
            data.deposit_amount = <?php echo $db_d_amount; ?>;
            data.deposit_firstpayment_promotion_mark = '<?php echo $deposit->deposit_firstpayment_promotion_mark ?>';
            data.deposit_nextpayment_promotion_mark = '<?php echo $deposit->deposit_nextpayment_promotion_mark ?>';
            data.deposit_id = '<?php echo $deposit->deposit_id ?>';
            $.ajax({
                url: 'deposit/set_5',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(result) {
                    //alert(result.update_status);
                    if(result.update_status == 'OK'){
                      $( "div#ok" ).addClass( "disabled" );
                      $( "div#not_ok" ).addClass( "disabled" );
                      $( "div#change_status" ).addClass( "disabled" );
                      location.reload();
                    }
                }
            });
          });


        $( "div#not_ok" ).on( "click", function() {
          console.log('ok_clicked');

          var data = {};
          data.deposit_id = '<?php echo $deposit->deposit_id ?>';
          $.ajax({
              url: 'deposit/set_6',
              type: 'POST',
              dataType: 'json',
              data: data,
              success: function(result) {
                  //alert(result.update_status);
                  if(result.update_status == 'OK'){
                    $( "div#ok" ).addClass( "disabled" );
                    $( "div#not_ok" ).addClass( "disabled" );
                    $( "div#change_status" ).addClass( "disabled" );
                    location.reload();
                  }
              }
          });

        });

        $( "div#change_status" ).on( "click", function() {
          console.log('ok_clicked');

          var data = {};
          data.deposit_id = '<?php echo $deposit->deposit_id ?>';
          $.ajax({
              url: 'deposit/set_3',
              type: 'POST',
              dataType: 'json',
              data: data,
              success: function(result) {
                  //alert(result.update_status);
                  if(result.update_status == 'OK'){
                    $( "div#ok" ).removeClass( "disabled" );
                    $( "div#not_ok" ).removeClass( "disabled" );
                    $( "div#change_status" ).addClass( "disabled" );
                  }

              }
          });

        });

      });

    </script>
</div>
