<?php
/*
Template Name: promotion
*/
?>
<?php get_header();?>

<style>
  .sameheight.row {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
  }
  .sameheight.row > [class*='col-'] {
   display: flex;
   flex-direction: column;
  }
</style>
 <div id="page" class="single">
   <div class="content">
     <div  style="margin-top:0px;">
       <center>
         <h2>รายละเอียดโปรโมชั่น</h2>
         <br>
       </center>
       <div style="background-color:#f0f0f0;border-radius:10px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-1.png">

           <div class="container">
             <div class="row sameheight">
               <div class="col-md-8 col-xs-8 col-sm-8" style="margin: auto;">
                 <ul>
                   <li>รับโบนัสเครดิตเพิ่มทันที 100% จากยอดฝากเงิน</li>
                 </ul>
               </div>
               <div class="col-md-4 col-xs-4 col-sm-4" align="center">
                 <img src="<?php echo get_template_directory_uri()?>/images/100_per_bonus.png" style="display: none;width:30%;height:auto;"/>
               </div>
             </div>
           
		   <div class="row" style="margin-top:16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/Promotion1.jpg">
             </div>
           </div>

              <div class="row" style="margin:25px 16px 16px 16px;">
                <div class="col-md-12 col-xs-12 col-sm-12" style="color:red;">
                  <p style="text-indent: 2em;">
                    เงื่อนไขการรับโปรโมชั่นนี้
                  </p>
                  <ol type="1">
                    <li>จำกัดการให้ 100% ของยอดฝากที่ไม่เกิน 1,500 บาท</li>
                    <li>ต้องมียอด Turnover 8 เท่าของยอดฝากขึ้นไป จึงจะสามารถถอนได้ ไม่เช่นนั้นจะถูกตัดโบนัสออกตอนถอนเงิน</li>
                  </ol>
                </div>
              </div>
           </div>
			<div align="right">
          <a href="<?php echo get_page_link(129);?>">
             <button style="margin:15px;background-color:#387ef5;" type="button" class="btn btn-primary">สมัครสมาชิก</button>
          </a>
         </div>
       </div>
       <div style="background-color:#f0f0f0;border-radius:10px;margin-top:10px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-2.png">
         <div class="container">
           <div class="row sameheight">
             <div class="col-md-9 col-xs-9 col-sm-9" style="margin: auto;">
               <ul>
                 <li>รับโบนัสเครดิตเพิ่มทันที 10% ของยอดฝากเงิน เมื่อฝากเงินตั้งแต่ 10,000 บาทขึ้นไป</li>
                 <li>รับโบนัสเครดิตเพิ่มทันที 5% ของยอดฝากเงิน เมื่อฝากเงินตั้งแต่ 5,000 บาทขึ้นไปแต่ไม่ถึง 10,000 บาท</li>
               </ul>
             </div>
             <div class="col-md-3 col-xs-3 col-sm-3" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/100_per_bonus.png" style="display: none;width:30%;height:auto;"/>
             </div>
           </div>
             <div class="row" style="margin-top:16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/Promotion2.jpg">
             </div>
           </div>
		   
            <div class="row" style="margin:25px 16px 16px 16px;">
              <div class="col-md-12 col-xs-12 col-sm-12" style="color:red;">
                <p style="text-indent: 2em;" id="pro_lotto">
                  เงื่อนไขการรับโปรโมชั่นนี้
                </p>
                <ol type="1">
                  <li>ต้องมียอด Turnover 5 เท่าของยอดฝากขึ้นไป จึงจะสามารถถอนได้ ไม่เช่นนั้นจะถูกตัดโบนัสออกตอนถอนเงิน</li>
                </ol>
              </div>
            </div>
         </div>
	<div align="right">
          <a href="<?php echo get_page_link(279);?>">
             <button style="margin:15px;background-color:#387ef5;" type="button" class="btn btn-primary">เติมเครดิต (ระบบ Auto)</button>
          </a>
         </div>
       </div>
       <!--<div style="background-color:#f0f0f0;border-radius:10px;margin-top:10px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-3.png">
         <div style="padding:16px;">
           <p style="text-indent: 3em;font-size:120%">
             &nbsp;รับโบนัสเครดิตเพิ่มทันที 5% ของยอดฝากเงิน เมื่อฝากเงินกับทาง sbobet878 ทุกยอดฝาก
              <p style="text-indent: 5em;font-size:120%">
                ** ตัวอย่าง ฝากเงินเข้ามา 2,000 บาท รับเครดิตไปเลย 2,100 บาท **
              </p>
            </p>
         </div>
       </div>-->
       <div style="background-color:#f0f0f0;border-radius:10px;margin-top:10px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-3.png">
         <div class="container">
           <div class="row sameheight">
             <div class="col-md-8 col-xs-8 col-sm-8" style="margin: auto;">
               <ul>
                 <li>ทุกวันหวยออก ลุ้นเลขท้ายสมาชิก 3 ตัว ท่านใดตรงกับเลขท้าย 3 ตัวบน(เลขท้ายรางวัลที่ 1 สลากกินแบ่งรัฐบาล) รับเครดิตฟรีทันที 2,500 บาท</li>
               </ul>
             </div>
             <div class="col-md-4 col-xs-4 col-sm-4" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/100_per_bonus.png" style="display: none;width:30%;height:auto;"/>
             </div>
           </div>
		   
		             <div class="row" style="margin-top:16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/Promotion3.jpg">
             </div>
           </div>
		   
           <div class="row" style="margin:25px 16px 16px 16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" style="color:red;">
               <p style="text-indent: 2em;">
                 เงื่อนไขการรับโปรโมชั่นนี้
               </p>
               <ol type="1">
                 <li>จะต้องเป็นสมาชิกกับ SBOBET878</li>
                 <li>ทางเราจะตัดสินผลรางวัล หลังจากมีการประกาศผลสลากกินแบ่งรัฐบาลอย่างเป็นทางการภายใน 5 วัน</li>
                 <li>ท่านจะต้องมียอด Turn Over ไม่ต่ำกว่า 5 เท่าของยอดรางวัล ในรอบ 15 วันก่อนหวยออก</li>
                 <li>ระบบจะปรับยอดเครดิตให้ท่านที่ถูกรางวัลโดยอัตโนมัติ</li>
				 <li>รางวัลเลขท้าย 3 ตัวบน อ้างอิงจากเลขท้ายของรางวัลที่ 1 ของสลากกินแบ่งรัฐบาล</li>
               </ol>
             </div>
           </div>
         </div>
         <div align="right">
          <a href="<?php echo get_page_link(310);?>">
             <button style="margin:15px;background-color:#387ef5;" type="button" class="btn btn-primary">ตรวจสอบรายชื่อผู้โชคดี</button>
          </a>
         </div>
       </div>
       <!--<div style="background-color:#f0f0f0;border-radius:10px;margin-top:10px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-5.png">
         <div style="padding:16px;">
           <p style="text-indent: 3em;font-size:120%">
             &nbsp;ทุกยอดพนันของท่าน จะได้ค่าคอมสูงสุดคืนทันที จากยอดที่ท่านพนัน ไม่ว่าจะบวกหรือลบ
            </p>
         </div>
       </div>-->
       <div style="background-color:#f0f0f0;border-radius:10px;margin-top:10px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-4.png">
         <div class="container">
           <div class="row sameheight">
             <div class="col-md-8 col-xs-8 col-sm-8" style="margin: auto;">
               <ul>
                 <li>เพียงแนะนำเพื่อนหรือโปรโมท เพื่อหาสมาชิกใหม่เพิ่มให้กับเรา ท่านที่แนะนำรับ 5% จากยอดเสียตลอดชีพ</li>
               </ul>
             </div>
             <div class="col-md-4 col-xs-4 col-sm-4" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/100_per_bonus.png" style="display: none;width:30%;height:auto;"/>
             </div>
           </div>
		           <div class="row" style="margin-top:16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/Promotion4.jpg">
             </div>
           </div>
           <div class="row" style="margin:25px 16px 16px 16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" style="color:red;">
               <p style="text-indent: 2em;">
                 เงื่อนไขการรับโปรโมชั่นนี้
               </p>
               <ol type="1" id="pro_cashback">
                 <li>จะต้องเป็นสมาชิกกับทาง SBOBET878 เพื่อใช้ในการรับเงินปันผลในแต่ละเดือน</li>
				 <li>ท่านจะต้องนำ Link ที่ทางเราจัดทำไว้ให้ นำไปใช้ในการแนะนำเพื่อนหรือโปรโมทหาสมาชิกให้กับเรา ซึ่ง</li>
				 <li>ระบบจะตรวจสอบให้อัตโนมัติ ว่าสมาชิกที่สมัครใหม่นั้น สมัครมาจาก Link ที่ท่านโปรโมทไว้</li>
				 <li>ทางเราจะจัดเก็บยอดเงินที่ท่านได้ แสดงให้ท่านดูใน account สมาชิกของท่านเอง</li>
				 <li>ทางเราจะสรุปยอดให้ท่านทุกๆสิ้นเดือน ท่านสามารถถอนเงินได้ทันทีหลังจากสรุปยอด</li>
               </ol>
             </div>
           </div>
         </div>
		  <div align="right">
          <a href="<?php echo get_page_link(263);?>">
             <button style="margin:15px;background-color:#387ef5;" type="button" class="btn btn-primary">เริ่มต้นแนะนำเพื่อนคลิกที่นี่</button>
          </a>
         </div>
       </div>

       <div style="background-color:#f0f0f0;border-radius:10px;margin-top:10px;margin-bottom:50px;">
         <img src="<?php echo get_template_directory_uri()?>/images/promo-bar-5.png">
         <div class="container">
           <div class="row sameheight">
             <div class="col-md-12 col-xs-12 col-sm-12" style="margin: auto;">
               <ul>
                 <li>ทุกๆต้นเดือน ทางเราจะคิดยอดเสียรวมกันในตลอดทั้งเดือนก่อนหน้า เพื่อหาผู้ที่มียอดเสียสูงสุดและรองลงมา รวม 5 อันดับ</li>
               </ul>
             </div>
           </div>
           <div class="row" style="margin-top:16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" align="center">
               <img src="<?php echo get_template_directory_uri()?>/images/Promotion_CASH_BACK.jpg">
             </div>
           </div>

           <div class="row sameheight" style="margin:25px 16px 16px 16px;">
             <div class="col-md-12 col-xs-12 col-sm-12" style="color:red;">
               <p style="text-indent: 2em;">
                 เงื่อนไขการรับโปรโมชั่นนี้
               </p>
               <ol type="1">
                 <li>รางวัลจากโปรโมชั่นนี้ จะถูกโอนเข้าเป็นเครดิตใน account ของท่านสมาชิกเท่านั้น</li>
                 <li>ต้องมี Turnover 3 เท่า ของรางวัล ที่ทางเราเติมเครดิตให้ จึงจะสามารถถอนเงินได้</li>
                 <li>การคิดยอดเสียจะไม่นับค่าโบนัสและค่าคอมมิชชั่นใดๆ ที่ทางเราได้เติมให้ในเครดิตของท่าน</li>
                 <li>ทางเราจะเติมเครดิตให้ user ของท่านสมาชิก ก่อนวันที่ 5 ของเดือนถัดไป</li>
                 <li>จ่ายสูงสุดไม่เกิน 100,000 บาท / 1 account</li>
                 <li>ทางเราจะสรุปยอดเงินให้ท่านและประกาศรายชื่อผู้ที่ได้รับโบนัสบน website ที่หน้าโปรโมชั่น</li>
               </ol>
             </div>
           </div>
         </div>
         <div align="right">
          <a href="<?php echo get_page_link(312);?>">
             <button style="margin:0 15px 15px 15px;background-color:#387ef5;" type="button" class="btn btn-primary">ตรวจสอบรายชื่อผู้โชคดี</button>
          </a>
         </div>
       </div>
     </div>

<?php get_footer(); ?>
