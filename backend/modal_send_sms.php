<?php
$sms = $this->sms_model->get_resend_sms($param1)->row();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title text-center"><i class="icon-envelope-alt"></i> ส่งข้อความ</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" method="post" action="<?php echo base_url() . 'backend/sms/resend/' . $param1 ?>" >
        <input type="hidden" name="type" value="<?php echo $sms->sms_log_type; ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">การแจ้งเตือน : </label>
            <div class="col-sm-5">
                <p class="form-control-static">
                    <?php
                        if ($sms->sms_log_type == 1) {
                            echo 'สมัครสมาชิก';
                        } else if ($sms->sms_log_type == 2) {
                            echo 'แจ้งฝาก';
                        } else if ($sms->sms_log_type == 3) {
                            echo 'แจ้งถอน';
                        } else {
                            echo 'ข้อมูลสมาชิก';
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">หมายเลข : </label>
            <div class="col-sm-5">
                <input type="text" name="sendto" value="<?php echo $sms->sms_log_to; ?>" class="form-control" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">ข้อความ : </label>
            <div class="col-sm-5">
                <textarea name="message" class="form-control" rows="4" disabled><?php echo $sms->sms_log_msg; ?></textarea>
            </div>
        </div>     
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <button class="btn btn-primary" value="send" name="submit" type="submit" ><i class="icon-envelope-alt"></i> ส่งข้อความ</button>
            </div>
        </div>
    </form>  
</div>