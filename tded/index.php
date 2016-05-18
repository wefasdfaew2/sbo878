<!DOCTYPE html>
<html  lang="en-US" >
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <?php
      if(empty($_POST["password"]))
        {
          $check_p = 'false';
        }else {
          if($_POST["password"] == 's4722team'){
            $check_p = 'true';
          }
        }
     ?>

    <?php
    if($check_p == 'true'){
    ?>
    <form class="" action="bath_run.php" method="post">
      <table border="1" style="margin:40px auto;">
        <tr>
          <th>ชื่อหนังสือพิมพ์</th>
          <th>ดำเนินการ</th>
        </tr>
        <tr>
          <td>สปอร์ตพูล</td>
          <td>
            <button name="newspaper_name" type="submit" value="sportpool">BathRun</button>
          </td>
        </tr>
        <tr>
          <td>สปอร์ตแมน</td>
          <td>
            <button name="newspaper_name" type="submit" value="sportman">BathRun</button>
          </td>
        </tr>
        <tr>
          <td>ตลาดลูกหนัง</td>
          <td>
            <button name="newspaper_name" type="submit" value="tarad">BathRun</button>
          </td>
        </tr>
        <tr>
          <td>สตาร์ซอคเกอร์</td>
          <td>
            <button name="newspaper_name" type="submit" value="starsoccer">BathRun</button>
          </td>
        </tr>
      </table>
    </form>
    <center>คลิก BathRun แล้วรอก่อนจ้า....กำลังแปลงไฟล์...กิกิ</center>
    <?php
    }else{
      ?>
      <center>
      <div style="margin-top:100px;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          Password:
          <input type="password" name="password" />
          <input type="submit" name="submit" />
        </form>
      </div>
    </center>
      <?php
    }
    ?>
  </body>
</html>
