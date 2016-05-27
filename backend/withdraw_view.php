<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">
                รายการแจ้งถอน
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo base_url('backend/dashboard'); ?>">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="<?php echo base_url('backend/withdraw'); ?>">รายการแจ้งถอน</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-upload-alt"></i> รายการแจ้งถอน</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="withdraw_view">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">ชื่อบัญชี</th>
                                <th class="text-center">ชื่อสมาชิก</th>
                                <th class="text-center">จำนวนเงิน</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ตรวจสอบ</th>
                                <th class="text-center">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($this->withdraw_model->get_withdraw()->result() as $row) {
                                ?>
                                <tr class="odd gradeX">
                                    <!--<td class="text-center"><?php echo $i++; ?></td>-->
                                    <td class="text-center"><?php echo $row->withdraw_id; ?></td>
                                    <td class="text-center"><?php echo $row->withdraw_account; ?></td>
                                    <td class="text-center"><?php echo $row->withdraw_nickname; ?></td>
                                    <td class="text-center"><?php echo $row->withdraw_amount; ?></td>
                                    <td class="text-center">
                                        <?php
                                        $lable_status = '';
                                        $icon_status = '';
                                        if ($row->withdraw_status_id == 1) {
                                            $lable_status = 'label label-sm label-warning';
                                            $icon_status = 'icon-question-sign';
                                        } else if ($row->withdraw_status_id == 2) {
                                            $lable_status = 'label label-sm label-success';
                                            $icon_status = 'icon-ok';
                                        } else if ($row->withdraw_status_id == 4) {
                                            $lable_status = 'label label-sm label-success';
                                            $icon_status = 'icon-ok';
                                        } else {
                                            $lable_status = 'label label-sm label-danger';
                                            $icon_status = 'icon-remove';
                                        }
                                        ?>
                                        <span class="<?php echo $lable_status; ?>"><i class="<?php echo $icon_status; ?>"></i> <?php echo $row->withdraw_status_name; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($row->withdraw_status_id == 7) {
                                        ?>
                                          <button class="btn btn-xs dark" onclick="show_modal('withdraw_model/modal_withdraw_view/<?php echo $row->withdraw_id; ?>');"><i class="icon-search"></i> ตรวจสอบ</button>
                                        <?php
                                        }else{
                                        ?>
                                          <button class="btn btn-xs label-danger disabled" onclick="show_modal('withdraw_model/modal_withdraw_view/<?php echo $row->withdraw_id; ?>');"><i class="icon-remove"></i> ตรวจสอบ</button>
                                        <?php
                                        }
                                        ?>

                                    </td>
                                    <td class="text-center" >
                                      <div><?php echo $row->withdraw_note; ?></div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<?php
    if ($this->session->flashdata('flash_message') != '') {
?>
<div id="message_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 200px; max-width:300px !important;">
        <div class="modal-content">
            <div class="modal-body text-center" style="padding:10px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <?php echo $this->session->flashdata('flash_message'); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#message_modal').modal('show', {backdrop: 'true'});
        setTimeout(function () {
            $('#message_modal').modal('hide');
        }, 5000);
    });
</script>
<?php
    }
