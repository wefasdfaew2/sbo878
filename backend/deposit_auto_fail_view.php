<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">
                รายการแจ้งฝากอัตโนมัติที่ขัดข้อง
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo base_url('backend/dashboard'); ?>">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="<?php echo base_url('backend/deposit'); ?>">รายการแจ้งฝากอัตโนมัติที่ขัดข้อง</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-download-alt"></i> รายการแจ้งฝากอัตโนมัติที่ขัดข้อง</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="deposit_auto">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">ชื่อบัญชี</th>
                                <th class="text-center">ชื่อสมาชิก</th>
                                <th class="text-center">จำนวนเงิน</th>
                                <th class="text-center">เวลาฝากเงิน</th>
                                <th class="text-center">ช่องทางฝากเงิน</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ตรวจสอบ</th>
                                <th class="text-center" style="width:150px;">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //$i = 1;
                            foreach ($this->deposit_model->get_deposit_auto_fail()->result() as $row) {

                                ?>
                                <tr class="odd gradeX">
                                    <!--<td class="text-center"><?php echo $i++; ?></td>-->
                                    <td class="text-center"><?php echo $row->deposit_id; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_account; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_nickname; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_amount; ?></td>
                                    <td class="text-center"><?php echo $this->mydate->date2thai($row->deposit_date . ' ' . $row->deposit_time, '%d %m %y เวลา %h:%i'); ?></td>
                                    <td class="text-center"><?php echo $row->deposit_type_name.', '.$row->deposit_type_subtype; ?></td>
                                    <td class="text-center">
                                        <?php
                                        $lable_status = '';
                                        $icon_status = '';
                                        if ($row->deposit_status_id == 1) {
                                            $lable_status = 'label label-sm label-warning';
                                            $icon_status = 'icon-question-sign';
                                        } else if ($row->deposit_status_id == 5) {
                                            $lable_status = 'label label-sm label-success';
                                            $icon_status = 'icon-ok';
                                        } else {
                                            $lable_status = 'label label-sm label-danger';
                                            $icon_status = 'icon-remove';
                                        }
                                        ?>
                                        <span class="<?php echo $lable_status; ?>"><i class="<?php echo $icon_status; ?>"></i> <?php echo $row->deposit_status_name; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-xs dark" onclick="show_modal('deposit_model/modal_deposit_view/<?php echo $row->deposit_id; ?>');"><i class="icon-search"></i> ตรวจสอบ</button>
                                    </td>
                                    <td class="text-center">
                                      <div><?php echo $row->deposit_note; ?></div>
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
