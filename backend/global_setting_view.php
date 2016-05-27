<?php
    $global_setting = $this->global_setting_model->get_global_setting()->row();
?>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">
                รายการแจ้งฝาก
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo base_url('backend/dashboard'); ?>">Dashboard</a>
                    <i class="icon-angle-right"></i>
                </li>
                <li><a href="<?php echo base_url('backend/global_setting'); ?>">Global setting</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-download-alt"></i>Global_setting</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                  <form id="global_form" method="post" action="<?php echo base_url() . 'backend/global_setting/set_status'  ?>" enctype="multipart/form-data" accept-charset="utf-8">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                          <td>เปิด-ปิดหน้าปรับปรุงเว็บไซต์</td>
                          <td>
                            <label class="radio-inline"><input type="radio" value="Yes" name="site_status">เปิด</label>
                            <label class="radio-inline"><input type="radio" value="No" name="site_status">ปิด</label>
                          </td>
                        </tr>
                        <tr>
                          <td>เปิด-ปิด ระบบฝากอัตโนมัติของ sbobet</td>
                          <td>
                            <label class="radio-inline"><input type="radio" value="Yes" name="deposit_auto_status">เปิด</label>
                            <label class="radio-inline"><input type="radio" value="No" name="deposit_auto_status">ปิด</label>
                          </td>
                        </tr>
                        <tr>
                          <td>เปิด-ปิด ระบบถอนของ sbobet</td>
                          <td>
                            <label class="radio-inline"><input type="radio" value="Yes" name="withdraw_status">เปิด</label>
                            <label class="radio-inline"><input type="radio" value="No" name="withdraw_status">ปิด</label>
                          </td>
                        </tr>
                        <tr>
                          <td>เปิด-ปิด หน้าสมัครสมาชิก</td>
                          <td>
                            <label class="radio-inline"><input type="radio" value="Yes" name="regis_status">เปิด</label>
                            <label class="radio-inline"><input type="radio" value="No" name="regis_status">ปิด</label>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>แจ้งประกาศ:</label>
                            <br>
                            <textarea name="inform_text" id="inform_text" rows="5" cols="50"></textarea>
                          </td>
                          <td style="vertical-align:middle;">
                            <label class="radio-inline"><input type="radio" value="Yes" name="inform_status">เปิด</label>
                            <label class="radio-inline"><input type="radio" value="No" name="inform_status">ปิด</label>
                          </td>
                        </tr>
                    </table>
                    <br>
                    <div class="text-center">
                      <input type="submit" class="btn btn-success" value="บันทึก">
                    </div>
                  </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script>

    $( document ).ready(function() {
      $('#inform_text').keyup( function() {
        $(this).val( $(this).val().replace( /\r?\n/gi, '' ) );
      });
      var site_status = '<?php echo $global_setting->site_underconstruction; ?>';
      var deposit_auto_status = '<?php echo $global_setting->sbobet_deposit_enable_by_cc; ?>';
      var withdraw_status = '<?php echo $global_setting->sbobet_withdraw_enable_by_cc; ?>';
      var regis_status = '<?php echo $global_setting->new_register_enable; ?>';
      var inform_status = '<?php echo $global_setting->announce_enable; ?>';
      var inform_text = '<?php echo $global_setting->announce_text; ?>';

      $('input:radio[name="site_status"]').filter('[value="' + site_status + '"]').attr('checked', true);
      $('input:radio[name="deposit_auto_status"]').filter('[value="' + deposit_auto_status + '"]').attr('checked', true);
      $('input:radio[name="withdraw_status"]').filter('[value="' + withdraw_status + '"]').attr('checked', true);
      $('input:radio[name="regis_status"]').filter('[value="' + regis_status + '"]').attr('checked', true);
      $('input:radio[name="inform_status"]').filter('[value="' + inform_status + '"]').attr('checked', true);
      $("textarea#inform_text").val(inform_text);
    });
</script>

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
        }, 4000);
    });
</script>
<?php
    }
