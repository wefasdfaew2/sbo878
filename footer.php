<?php
/**
 * The template for displaying the footer.
 */
?>
	</div><!-- .content -->
</div><!-- #page -->
<?php
	$carousel_section = get_theme_mod('point_carousel_section', '1');
	$carousel_cats = get_theme_mod('point_carousel_cat');
 // thai month
 $thai_m=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม",
"กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
// db
 date_default_timezone_set("Asia/Bangkok");
  $configs = include('php_db_config/config.php');
  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname = "sbobet878";
 // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset('utf8');
  // Check connection
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
  //init link str
  $link_3bb_s='';
  $link_3bb_g='';
  $link_trueonline_s='';
  $link_trueonline_g='';
  $link_tot_s='';
  $link_tot_g='';
  $link_cat_s='';
  $link_cat_g='';
  $link_ais_s='';
  $link_ais_g='';
  $link_dtac_s='';
  $link_dtac_g='';
  $link_truemove_s='';
  $link_truemove_g='';
  //lotto
  $lotto_date='';
  $lotto_number='';
  //top user cashback
  $u_cashback1='';
  $u_cashback2='';
  $u_cashback3='';
  $u_cashback4='';
  $u_cashback5='';

  $sql_get_url =  "SELECT `sort`,`bet_name`,`isp_name`,`url`
						FROM  `all_bet_link_url`";

   $result_get_url = $conn->query($sql_get_url);

   if ($result_get_url->num_rows > 0){
    while($row = $result_get_url->fetch_assoc())
    {

		$db_sort= $row["sort"];
	  $db_bet_name= $row["bet_name"];
	  $db_isp_name= $row["isp_name"];
	  $db_url= $row["url"];

	  //assign url

	  if($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='3bb'){
		$link_3bb_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='3bb'){
		$link_3bb_g=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='trueonline'){
		$link_trueonline_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='trueonline'){
		$link_trueonline_g=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='tot'){
		$link_tot_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='tot'){
		$link_tot_g=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='cat'){
	   $link_cat_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='cat'){
	   $link_cat_g=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='ais'){
	   $link_ais_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='ais'){
	   $link_ais_g=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='dtac'){
	   $link_dtac_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='dtac'){
	   $link_dtac_g=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'sbobet' && $db_isp_name=='truemove'){
	   $link_truemove_s=$db_url;
	  }elseif($db_sort=='1' && $db_bet_name == 'gclub' && $db_isp_name=='truemove'){
	   $link_truemove_g=$db_url;
	  }

	}

   }else{
  //  echo "ref_otp not found on db";
   }
   // sql lotto

	$sql_get_lotto =  "SELECT `current_pro_lotto_date`,`current_pro_lotto_number`
						FROM `global_setting` WHERE 1";
   $result_get_lotto = $conn->query($sql_get_lotto);
   if ($result_get_lotto->num_rows > 0){
    while($row = $result_get_lotto->fetch_assoc())
    {
	 $lotto_date=$row["current_pro_lotto_date"];
	 $lotto_number=$row["current_pro_lotto_number"];
	}
	}
   //sql top 5 cashback user
   $sql_get_cashback =  "SELECT reward,username FROM `promotion_cashback`
							WHERE  MONTH(`date`) = MONTH(NOW()) order by reward";
   $result_get_cashback = $conn->query($sql_get_cashback);
   if ($result_get_cashback->num_rows > 0){
    while($row = $result_get_cashback->fetch_assoc())
    {
	 $db_reward=$row["reward"];
	 $db_username=$row["username"];
	 if($db_reward=='1'){
		$u_cashback1=$db_username;
	 }elseif($db_reward=='2'){
		$u_cashback2=$db_username;
	 }elseif($db_reward=='3'){
		$u_cashback3=$db_username;
	 }elseif($db_reward=='4'){
		$u_cashback4=$db_username;
	 }elseif($db_reward=='5'){
		$u_cashback5=$db_username;
	 }
	}
	}else{
	//if return 0 show last month
	$sql_get_cashback =  "SELECT reward,username FROM `promotion_cashback`
							WHERE  MONTH(`date`) = MONTH(NOW())-1 order by reward";
	$result_get_cashback = $conn->query($sql_get_cashback);
   if ($result_get_cashback->num_rows > 0){
    while($row = $result_get_cashback->fetch_assoc())
    {
	 $db_reward=$row["reward"];
	 $db_username=$row["username"];
	 if($db_reward=='1'){
		$u_cashback1=$db_username;
	 }elseif($db_reward=='2'){
		$u_cashback2=$db_username;
	 }elseif($db_reward=='3'){
		$u_cashback3=$db_username;
	 }elseif($db_reward=='4'){
		$u_cashback4=$db_username;
	 }elseif($db_reward=='5'){
		$u_cashback5=$db_username;
	 }
	}
	}

	}

?>
<footer>
	<?php if( $carousel_section == 1 && isset($carousel_cats) ) { ?>
		<div class="carousel">
			<h3 class="frontTitle"><div class="latest"><?php echo $carousel_cats[0]; ?></div></h3>
			<?php
				// prevent implode error
                if (empty($carousel_cats) || !is_array($carousel_cats)) {
                    $carousel_cats = array('0');
                }
				$carousel_cat = implode(",", $carousel_cats);
				$i = 1; $my_query = new wp_query( 'category_name='.$carousel_cat.'&posts_per_page=6&ignore_sticky_posts=1' );
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<div class="excerpt">
						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="footer-thumbnail">
							<div>
								<div class="hover"><i class="point-icon icon-zoom-in"></i></div>
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail('carousel',array('title' => '')); ?>
								<?php } else { ?>
									<div class="featured-thumbnail">
										<img src="<?php echo get_template_directory_uri(); ?>/images/footerthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
									</div>
								<?php } ?>
							</div>
							<p class="footer-title">
								<span class="featured-title"><?php the_title(); ?></span>
							</p>
						</a>
					</div><!--.post excerpt-->
			<?php endwhile; wp_reset_query(); ?>
		</div>
	<?php } ?>
</footer><!--footer-->

<?php $postid = get_the_ID(); if($postid=='46') {?>
<!--newspaper -->

<div style="margin-bottom:16px;">
	<center>
		<a href="<?php echo get_permalink(352);?>" target="_blank">
			<div style="position:relative;">
				<img style="" src="<?php echo get_template_directory_uri(); ?>/images/Newspaper_border.png"/>
				<div style="position:absolute;z-index:5;top:18%;left:30px;width:930px;">
					<span style="margin:0 15px 15px;display: inline-block;">
						<img id="sportpool_img" style="width:170px;" src="https://tded.sbobet878.com/real/sportpool/cover.jpg"/>
						<div id="sportpool_date"></div>
					</span>
					<span style="margin:0 15px 15px;display: inline-block;">
						<img id="sportman_img" style="width:170px;" src="https://tded.sbobet878.com/real/sportman/cover.jpg"/>
						<div id="sportman_date"></div>
					</span>
					<span style="margin:0 15px 15px;display: inline-block;">
						<img id="tarad_img" style="width:170px;" src="https://tded.sbobet878.com/real/tarad/cover.jpg"/>
						<div id="tarad_date"></div>
					</span>
					<span style="margin:0 15px 15px;display: inline-block;">
						<img id="starsoccer_img" style="width:170px;" src="https://tded.sbobet878.com/real/starsoccer/cover.jpg"/>
						<div id="starsoccer_date"></div>
					</span>
				</div>
			</div>
		</a>
	<center>
</div>

<!--lotto-->
<div class="carousel" style="height:40px;margin-bottom:10px;">
 <div class="row " >
		<div class="col-md-6  col-xs-6  col-sm-6 text-center " >
		<h3 class="frontTitle">ตรวจโปรเลขท้ายสามตัว</h3>
		</div>
		<div class="col-md-6  col-xs-6  col-sm-6 text-center " >
		<h3 class="frontTitle">ตรวจโปรคืนยอดเสีย</h3>
		</div>
 </div>

	</div>

  <div class="row " >
    <div class="col-md-6  col-xs-6  col-sm-6 text-center " >
			<table style="width:100%;" >
				<tr>
					<td>งวดประจำวันที่ <?php echo $lotto_date;?></td>
				</tr>
				<tr>
					<td>
					</br>
					<font color="blue"><strong>รางวัลที่ 1</strong></font>
					</td>
				</tr>
				<tr>
					<td style="word-spacing: 30px;">
					<?php echo  $lotto_number[0];?>
					<?php echo  $lotto_number[1];?>
					<?php echo  $lotto_number[2];?>
					<font style="color: red; text-decoration: underline;">
					<strong>
					<?php echo  $lotto_number[3];?>
					<?php echo  $lotto_number[4];?>
					<?php echo  $lotto_number[5];?>
					</strong>
					</font>
					 </td>
				</tr>
				<tr>
					<td>
					</br>
						<a href = "<?php echo get_permalink(133); ?>#pro_lotto" class = "btn btn-danger" role = "button">
						อ่านรายละเอียดโปรโมชั่นนี้
						</a>

						<a href = "<?php echo get_permalink(310); ?>" class = "btn btn-danger" role = "button">
					ตรวจสอบรายชือผู้โชคดี
						</a>
				   </td>
				</tr>
				</table>
	</div>

    <div class="col-md-6  col-xs-6  col-sm-6   " >
			<table style="width:100%;" class="text-center" >
				<tr>
					<td>ประจำเดือน <?php echo $thai_m[date("n")-1];?>
					(<?php echo date('j',strtotime("first day of this month")),"-",date('j',strtotime("last day of this month"))," ",$thai_m[date("n")-1]," ",date("Y")+543;?>)

					</td>
				</tr>
				<tr>
				 <td></br></td>
				</tr>
				</table>

				<table   style="width:95%;border:1px solid #A2B964;"   >

				<tr bgcolor="#A2B964" >
					<td style="color:white;padding:5px 0px 0px 50px;">อันดับที่ 1 (คืนยอดเสีย 10%) </td>
					<td style="color:white;padding:5px 0px 0px 50px;"><?php echo $u_cashback1;?></td>
				</tr>
				<tr  style="border:1px solid #A2B964;"   >
					<td style="padding-left:50px;">อันดับที่ 2 (คืนยอดเสีย 7%) </td>
					<td style="padding-left:50px;"><?php echo  $u_cashback2;?></td>
				</tr>
				<tr style="border:1px solid #A2B964;"  >
					<td style="padding-left:50px;">อันดับที่ 3 (คืนยอดเสีย 5%) </td>
					<td style="padding-left:50px;"><?php echo  $u_cashback3;?></td>
				</tr>
				<tr style="border:1px solid #A2B964;"  >
					<td style="padding-left:50px;">อันดับที่ 4 (คืนยอดเสีย 3%) </td>
					<td style="padding-left:50px;"><?php echo  $u_cashback4;?></td>
				</tr>
				<tr style="border:1px solid #A2B964;"  >
					<td style="padding-left:50px;">อันดับที่ 5 (คืนยอดเสีย 3%) </td>
					<td style="padding-left:50px;"><?php echo  $u_cashback5;?></td>
				</tr>

				</table>
				<table style="width:100%;" class="text-center"  >
				<tr>
					<td>
					</br>
						<a href = "<?php echo get_permalink(133); ?>#pro_cashback" class = "btn btn-success" role = "button">
						อ่านรายละเอียดโปรโมชั่นนี้
						</a>

						<a href = "<?php echo get_permalink(312); ?>" class = "btn btn-success" role = "button">
					ตรวจสอบรายชือผู้โชคดี
						</a>
					</td>
				</tr>
				</table>

	</div>

   </div>

 </br>

<!--score table-->
	<div class="carousel" style="height:40px;margin-bottom:10px;">
			<h3 class="frontTitle">ตารางคะแนน (อัพเดทอัตโนมัติ)</h3>
	</div>
	<div style="text-align:center;">
		<script language='javascript'> var timeZone ='%2B0700'; var dstbox =''; var cpageBgColor = 'FFFFFF'; var wordAd='  Sbobet878.Com'; var wadurl='https://www.sboobet878.com'; var width='100%'; var tableFontSize='12'; var cborderColor='333333'; var ctdColor1='EEEEEE'; var ctdColor2='FFFFFF'; var clinkColor='0044DD'; var cdateFontColor='FFFFFF'; var cdateBgColor='333333'; var scoreFontSize='12'; var cteamFontColor='000000'; var cgoalFontColor='FF0000'; var cgoalBgColor='FFFF99'; var cremarkFontColor='000000'; var mark ='en'; var cremarkBgColor='F7F8F3'; var Skins='2'; var teamWeight='400'; var scoreWeight='700'; var goalWeight='700'; var fontWeight='700'; document.write("<iframe align='center' src='http://www.nowgoal.cc/Asianbookie.aspx?tv=false&amp;link=facebook" +"'  height='470' width='95%' scrolling='yes' border='0' frameborder='0'></iframe>")</script>
	</div>
	<br>
<?php } ?>
<!--sbobet url check access from isp-->
	<div class="carousel">
			<h3 class="frontTitle">ทางเข้าเว็บพนัน (อัพเดทลิ้งค์ใหม่อัตโนมัติหากโดนบล๊อค)</h3>
	</div>


<table style="width:100%"  >
<tr align="center">
    <td>
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/3BB.jpg" alt="sbobet878">
	 </td>
    <td>
	 <a target="_blank" href="<?php echo $link_3bb_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_3bb_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
		</td>
		<!--x -->
	<td>
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/True.jpg" alt="sbobet878">
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_trueonline_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_trueonline_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
	</td>
</tr>
<tr align="center">
  <td>
	<a href="<?php echo  get_permalink(198); ?>">ทางเข้าทั้งหมดผ่าน3bb</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_3bb_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_3bb_g;?>">
	Royal Gclub link1
	</a>
  </td>
  <!--x -->
  <td>
	<a href="<?php echo  get_permalink(200); ?>">ทางเข้าทั้งหมดผ่านทรู</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_trueonline_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_trueonline_g;?>">
	Royal Gclub link1
	</a>
  </td>
  </tr>
</table>

<table style="width:100%"  >
<tr align="center">
    <td>
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/TOT.jpg" alt="sbobet878">
	 </td>
    <td>
	<a target="_blank" href="<?php echo $link_tot_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_tot_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
		</td>
		<!--x -->
	<td>
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/CAT.jpg" alt="sbobet878">
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_cat_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_cat_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
	</td>
</tr>
<tr align="center">
  <td>
	<a href="<?php echo  get_permalink(202); ?>">ทางเข้าทั้งหมดผ่านทีโอที</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_tot_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_tot_g;?>">
	Royal Gclub link1
	</a>
  </td>
  <!--x -->
  <td>
	<a href="<?php echo  get_permalink(204); ?>">ทางเข้าทั้งหมดผ่านแคท</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_cat_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_cat_g;?>">
	Royal Gclub link1
	</a>
  </td>
  </tr>
</table>

<table style="width:100%"  >
<tr align="center">
    <td>
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/AIS.jpg" alt="sbobet878">
	 </td>
    <td>
	<a target="_blank" href="<?php echo $link_ais_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_ais_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
		</td>
		<!--x -->
	<td>
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/Dtac.jpg" alt="sbobet878">
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_dtac_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td>
	<a target="_blank" href="<?php echo $link_dtac_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
	</td>
</tr>
<tr align="center">
  <td>
	<a href="<?php echo  get_permalink(206); ?>">ทางเข้าทั้งหมดผ่านเอไอเอส</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_ais_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_ais_g;?>">
	Royal Gclub link1
	</a>
  </td>
  <!--x -->
  <td>
	<a href="<?php echo  get_permalink(210); ?>">ทางเข้าทั้งหมดผ่านดีแทค</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_dtac_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_dtac_g;?>">
	Royal Gclub link1
	</a>
  </td>
  </tr>
</table>
<table style="width:100%" >
<tr align="center">
    <td  >
		<img src="<?php echo  content_url(); ?>/uploads/2016/02/TrueH.jpg" alt="sbobet878">
	 </td>
    <td style="padding-left: 4px;">
	<a target="_blank" href="<?php echo $link_truemove_s;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/SBOBET.jpg" alt="sbobet878">
		</a>
	</td>
    <td style="padding-left: 1px;">
	<a target="_blank" href="<?php echo $link_truemove_g;?>">
		<img height="84" width="117" src="<?php echo  content_url(); ?>/uploads/2016/02/royalgclub.jpg" alt="sbobet878">
		</a>
		</td>
		<!--x -->
	<td>

	</td>
    <td>
		 <a href="<?php echo  get_permalink(215); ?>">
      <img src="<?php echo  content_url(); ?>/uploads/2016/02/LinkEntry.png" alt="sbobet878" align="middle" >
     </a>
	</td>
    <td>

	</td>

</tr>
<tr align="center">
  <td>
	<a href="<?php echo  get_permalink(212); ?>">ทางเข้าทั้งหมดผ่านทรูมูฟเฮช</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_truemove_s;?>">
	sbobet link1
	</a>
  </td>
  <td>
  <a target="_blank" href="<?php echo $link_truemove_g;?>">
	Royal Gclub link1
	</a>
  </td>
  <!--x -->
   <td>
   </td>
   <td>
   </td>
   <td>
   </td>
  </tr>
</table>




<?php mts_copyrights_credit();?>
<?php wp_footer(); ?>

</div><!-- main-container -->
</body>
</html>
