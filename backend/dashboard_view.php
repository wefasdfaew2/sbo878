<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">
                Dashboard
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="icon-home"></i>
                    <a href="<?php echo base_url('backend/dashboard'); ?>">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <div class="visual">
                    <i class="icon-download-alt"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?php
                            $deposit_head = $this->head_model->get_deposit_head(1);
                            echo $deposit_head->num_rows();
                        ?>
                    </div>
                    <div class="desc">รออนุมัติการแจ้งฝาก</div>
                </div>
                <a class="more" href="<?php echo base_url('backend/deposit'); ?>">
                    ดูรายการทั้งหมด <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="icon-upload-alt"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?php
                            $withdraw_head = $this->head_model->get_withdraw_head(1);
                            echo $withdraw_head->num_rows();
                        ?>
                    </div>
                    <div class="desc">รออนุมัติการแจ้งถอน</div>
                </div>
                <a class="more" href="<?php echo base_url('backend/withdraw'); ?>">
                    ดูรายการทั้งหมด <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat purple">

			   <div class="visual">
			   <!--
                    <i class="icon-user"></i>
					-->
                </div>
                <div class="details">
                    <div class="number">

                        <?php

							//$member_head = $this->head_model->get_member_head(1);
                            //echo $member_head->num_rows();

							// START query diafaan db
							 $dbname = "SMSServer";
							//check is_complete
							 // Create connection
							  $conn = new mysqli('27.254.86.130', 'sc', '27qr9rseGY7C59L8', $dbname);
							  $conn->set_charset('utf8');
							  // Check connection
							  if ($conn->connect_error)
							  {
								  die("Connection failed: " . $conn->connect_error);
							  }

							$sql_diafaan = "SELECT MessageText FROM `MessageIn`
											WHERE  `MessageFrom` ='#123*2#'
											and `MessageType` ='gsm.ussd'  order by `Id` DESC  LIMIT 1";
						//echo $sql;
						 $result_sql_diafaan = $conn->query($sql_diafaan);
						  if ($result_sql_diafaan->num_rows > 0){
							while($row = $result_sql_diafaan->fetch_assoc())
							{
							  $diafaan_count = $row["MessageText"];
							}

						}
						$sms_empty ="0E040E380E130E440E210E480E210E350E220E2D0E140E040E070E400E2B0E250E370E2D0E040E480E30";
						 if($diafaan_count==$sms_empty){
						 echo "ไม่มียอดเหลือ";

						 }else{
						 $str_diafaan = pack('H*', $diafaan_count);
							 $pieces = explode(" ", $str_diafaan);
										$sms_count = $pieces[2];
										$sms_date = $pieces[5];

							 echo $sms_count." ถึง<br>".$sms_date;
						 }
             ?>
                    </div>
                   <!-- <div class="desc">sms diafaan เครดิตคงเหลือ</div> -->
                </div>
				 <div  class="more" href="<?php echo base_url('backend/member'); ?>">
                    *sms diafaan คงเหลือ ,update db ทุกเที่ยงวัน
                </div>
				<?php /* ?>
                <a class="more" href="<?php echo base_url('backend/member'); ?>">
                    ดูรายการทั้งหมด <i class="m-icon-swapright m-icon-white"></i>
                </a>
<?php */ ?>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat yellow">
                <div class="visual">
                    <i class="icon-envelope-alt"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <?php

                            //$sms_credit = $this->head_model->get_sms_credit_head();
                            //echo $sms_credit[0]->sms_credit;
							function check_credit($username,$password,$credit_type = "credit_remain"){
							if(extension_loaded('curl')){
								$url = "http://www.thaibulksms.com:8081/sms_api.php";
								$data_string = "username=$username&password=$password&tag=$credit_type";

								$agent = "ThaiBulkSMS API PHP Client";
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_USERAGENT, $agent);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
								curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
								$result = curl_exec ($ch);
								$info = curl_getinfo($ch);
								curl_close ($ch);

								if($info['http_code'] == 200){
									if(is_numeric($result)){
										$msg_string = "Std ".$result;
									}else{
										$msg_string = $result;
									}
								}else{
									//$http_codes = parse_ini_file("http_code.ini");
									//$msg_string = "เน€เธเธดเธ”เธเนเธญเธเธดเธ”เธเธฅเธฒเธ”เนเธเธเธฒเธฃเธ—เธณเธเธฒเธ: <br />" . $info['http_code'] . " " . $http_codes[$code['http_code']];
									$msg_string = "เหลือ: <br />" . $info['http_code'];
								}

							}else if(function_exists('fsockopen')) {
								$result = $this->check_credit_fsock($username,$password,$credit_type);
								if(is_numeric($result)){
									$msg_string = "s".$result." ----";
								}else{
									$msg_string = $result;
								}

							}else{
								$msg_string = "cURL OR fsockopen is not enabled";
							}

							return $msg_string;
						}

							$sms_result =  check_credit('0932531478','961888');
							echo $sms_result;
							?>
                    </div>
                   <!-- <div class="desc">sms เครดิตคงเหลือ</div>-->
                </div>

				 <div  class="more">
                   thaibulksms เครดิตคงเหลือ
                </div>
				<!--
                <a class="more" href="<?php echo base_url('backend/sms'); ?>">
                    ดูรายการทั้งหมด <i class="m-icon-swapright m-icon-white"></i>
                </a>
-->
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-download-alt"></i> รายการแจ้งฝากล่าสุด</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="deposit">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">ชื่อบัญชี</th>
                                <th class="text-center">ชื่อสมาชิก</th>
                                <th class="text-center">จำนวนเงิน</th>
                                <th class="text-center">เวลาฝากเงิน</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ตรวจสอบ</th>
                                <th class="text-center">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($this->deposit_model->get_deposit()->result() as $row) {
                                ?>
                                <tr class="odd gradeX">
                                    <!--<td class="text-center"><?php echo $i++; ?></td>-->
                                    <td class="text-center"><?php echo $row->deposit_id; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_account; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_nickname; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_amount; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_date . ' ' . $row->deposit_time; ?></td>
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
                                    <td class="text-center" >
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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-upload-alt"></i> รายการแจ้งถอนล่าสุด</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="withdraw">
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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-download-alt"></i> รายการแจ้งฝากอัตโนมัติที่ขัดข้องล่าสุด</div>
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
                                <th class="text-center">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($this->deposit_model->get_deposit_auto_fail()->result() as $row) {
                                ?>
                                <tr class="odd gradeX">
                                    <!--<td class="text-center"><?php echo $i++; ?></td>-->
                                    <td class="text-center"><?php echo $row->deposit_id; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_account; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_nickname; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_amount; ?></td>
                                    <td class="text-center"><?php echo $row->deposit_date . ' ' . $row->deposit_time; ?></td>
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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-user"></i> สมาชิก</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="member">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">ชื่อบัญชี</th>
                                <th class="text-center">ชื่อสมาชิก</th>
                                <th class="text-center">เบอร์โทรศัพท์</th>
                                <th class="text-center">เลขบัญชี ( ธนาคาร )</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ตรวจสอบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($this->member_model->get_member()->result() as $row) {
                                ?>
                                <tr class="odd gradeX">
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class="text-center">
                                        <?php
                                            $lable_status = '';
                                            $icon_status = '';
                                            if ($row->member_status_id == 1) {
                                                $lable_status = 'label label-sm label-warning';
                                                $icon_status = 'icon-question-sign';
                                            } else if ($row->member_status_id == 2) {
                                                $lable_status = 'label label-sm label-success';
                                                $icon_status = 'icon-ok';
                                            } else {
                                                $lable_status = 'label label-sm label-danger';
                                                $icon_status = 'icon-remove';
                                            }

                                            if ($row->member_sbobet_account_id != 0) {
                                                echo $row->sbobet_username;
                                            } else {
                                        ?>
                                        <span class="<?php echo $lable_status; ?>"><i class="<?php echo $icon_status; ?>"></i> <?php echo $row->member_status_name; ?></span>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            if ($row->member_nickname != '') {
                                                echo $row->member_nickname;
                                            } else {
                                                echo 'ไม่ระบุ';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            if ($row->member_telephone_1 != '') {
                                                echo $row->member_telephone_1;
                                            } else {
                                                if ($row->member_telephone_2 != '') {
                                                    echo $row->member_telephone_2;
                                                } else {
                                                    echo 'ไม่ระบุ';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            if ($row->member_bank_account != '') {
                                                echo $row->member_bank_account;
                                            } else {
                                                echo 'ไม่ระบุ';
                                            }

                                            if ($row->member_bank_name != '') {
                                                echo ' ( ' . $row->member_bank_name . ' )';
                                            } else {
                                                echo ' ( ไม่ระบุ )';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="<?php echo $lable_status; ?>"><i class="<?php echo $icon_status; ?>"></i> <?php echo $row->member_status_name; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-xs dark" onclick="show_modal('member_model/modal_member_view/<?php echo $row->member_id; ?>');"><i class="icon-search"></i> ตรวจสอบ</button>
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
    <?php /* ?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-envelope-alt"></i> รายงานการส่งข้อความ</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sms">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">การแจ้งเตือน</th>
                                <th class="text-center">เบอร์ผู้รับ</th>
                                <th class="text-center">เวลา</th>
                                <th class="text-center">ข้อความ</th>
                                <th class="text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($this->sms_model->get_sms_log(100)->result() as $row) {
                                ?>
                                <tr class="odd gradeX">
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class="text-center">
                                        <?php
                                            if ($row->sms_log_type == 1) {
                                                echo 'สมัครสมาชิก';
                                            } else if ($row->sms_log_type == 2) {
                                                echo 'แจ้งฝาก';
                                            } else if ($row->sms_log_type == 3) {
                                                echo 'แจ้งถอน';
                                            } else {
                                                echo 'ข้อมูลสมาชิก';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $row->sms_log_to; ?></td>
                                    <td class="text-center"><?php echo $row->sms_log_time; ?></td>
                                    <td class="text-center"><?php echo $row->sms_log_msg; ?></td>
                                    <td class="text-center">
                                        <?php
                                            $lable_status = '';
                                            $icon_status = '';
                                            if ($row->sms_log_status == 1) {
                                                $lable_status = 'label label-sm label-success';
                                                $icon_status = 'icon-ok';
                                                $sms_status_name = 'ส่งข้อความสำเร็จ';
                                            } else {
                                                $lable_status = 'label label-sm label-danger';
                                                $icon_status = 'icon-remove';
                                                $sms_status_name = 'ส่งข้อความไม่สำเร็จ';
                                            }
                                        ?>
                                        <span class="<?php echo $lable_status; ?>"><i class="<?php echo $icon_status; ?>"></i> <?php echo $sms_status_name; ?></span>
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
	<?php */ ?>
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
