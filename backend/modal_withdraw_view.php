<?php
    $withdraw = $this->withdraw_model->get_withdraw($param1)->row();
?>
<div class="modal-header" style="padding:8px;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title text-center"><i class="icon-upload-alt"></i> ตรวจสอบการแจ้งถอน</h4>
</div>
<div class="modal-body" style="padding:10px;">
    <form class="form-horizontal" method="post" action="<?php echo base_url() . 'backend/withdraw/confirm/' . $withdraw->withdraw_id; ?>" enctype="multipart/form-data" accept-charset="utf-8">
        <input type="hidden" name="withdraw_id" value="<?php echo $withdraw->withdraw_id; ?>" >
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">สถานะรายการ : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                    $lable_status = '';
                    $icon_status = '';
                    if ($withdraw->withdraw_status_id == 1) {
                        $lable_status = 'label label-sm label-warning';
                        $icon_status = 'icon-question-sign';
                    } else if ($withdraw->withdraw_status_id == 2) {
                        $lable_status = 'label label-sm label-success';
                        $icon_status = 'icon-ok';
                    } else {
                        $lable_status = 'label label-sm label-danger';
                        $icon_status = 'icon-remove';
                    }
                    ?>
                    <span class="<?php echo $lable_status; ?>"><i class="<?php echo $icon_status; ?>"></i> <?php echo $withdraw->withdraw_status_name; ?></span>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ชื่อบัญชี : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_account = $this->withdraw_model->check_withdraw_account($withdraw->withdraw_account);
                    ?>
                    <i class="<?php if ($check_account == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $withdraw->withdraw_account; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ชื่อสมาชิก : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_nickname = $this->withdraw_model->check_withdraw_name($withdraw->withdraw_account,$withdraw->withdraw_nickname);
                    ?>
                    <i class="<?php if ($check_nickname == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $withdraw->withdraw_nickname; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เบอร์โทรศัพท์ : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_telephone = $this->withdraw_model->check_withdraw_telephone($withdraw->withdraw_account,$withdraw->withdraw_telephone);
                    ?>
                    <i class="<?php if ($check_telephone == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $withdraw->withdraw_telephone; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">ธนาคาร : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_bank_name = $this->withdraw_model->check_withdraw_bank_name($withdraw->withdraw_account,$withdraw->withdraw_bank_name);
                    ?>
                    <i class="<?php if ($check_bank_name == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $withdraw->withdraw_bank_name; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เลขบัญชี : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php
                        $check_bank_account = $this->withdraw_model->check_withdraw_bank_account($withdraw->withdraw_account,$withdraw->withdraw_bank_account);
                    ?>
                    <i class="<?php if ($check_bank_account == 1) { echo 'icon-ok'; } else { echo 'icon-remove'; } ?>"></i>
                    <?php echo $withdraw->withdraw_bank_account; ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">จำนวนเงิน : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php echo $withdraw->withdraw_amount; ?> บาท
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-bottom:7px !important;">
            <label class="col-md-6 control-label">เวลา : </label>
            <div class="col-md-6">
                <p class="form-control-static">
                    <?php echo $this->mydate->date2thai($withdraw->withdraw_regis, '%d %m %y เวลา %h:%i'); ?>
                </p>
            </div>
        </div>
        <div class="form-group" style="margin-top:20px; margin-bottom:7px !important;">
            <div class="col-lg-12 text-center">
		<!--<button class="btn btn-primary" value="3" name="submit" type="submit" ><i class="icon-ok"></i> เปลี่ยนสถานะเป็นกำลังดำเนินการโดย Call Center</button>-->
                <button class="btn btn-primary" value="4" name="submit" type="submit" ><i class="icon-ok"></i> อนุมัติ</button>
                <button class="btn btn-danger" value="5" name="submit" type="submit" ><i class="icon-remove"></i> ไม่อนุมัติ</button>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>
