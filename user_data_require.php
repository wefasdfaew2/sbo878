<?php
/*
Template Name: point
*/
?>

<?php get_header();?>
 <div  ng-app="max_MyApp" ng-controller="max_user_detail" ng-cloak="">



<?php global $current_user;
///check user already fill request field
      get_currentuserinfo();

//      echo 'Username: ' . $current_user->user_login . "\n";
  //    echo 'User email: ' . $current_user->user_email . "\n";
   //   echo 'User level: ' . $current_user->user_level . "\n";
    //  echo 'User first name: ' . $current_user->user_firstname . "\n";
     // echo 'User last name: ' . $current_user->user_lastname . "\n";
    //  echo 'User display name: ' . $current_user->display_name . "\n";
     // echo 'User ID: ' . $current_user->ID . "\n";
 $configs = include('php_db_config/config.php');

  $servername = $configs['servername'];
  $username = $configs['username'];
  $password = $configs['password'];
  $dbname = "test_wordpress";
//check is_complete
 // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset('utf8');
  // Check connection
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
$sql = "SELECT * FROM wp_users where ID=$current_user->ID";
$result = $conn->query($sql);

  if ($result->num_rows > 0)
  {

while($row = $result->fetch_assoc())
    {
        if ($row["is_complete"]==0){
// draw angularjs form

echo '<form name="userForm" ng-submit="submitForm('.$current_user->ID.')">
<div style="border-style: solid;border-color: #ff0000 #00ff00 #0000ff;">
    <h1 class="md-title">คุณ ' .$row["user_login"]. 'กรุณากรอกข้อมูลให้ครบคะ</h1>
    <div layout="column"  layout-align="center start">
      <md-input-container  class="md-block">
        <label>ชื่อธนาคาร</label>
        <md-select  ng-model="user_init.bname" required name="bank_name">
          <md-option ng-repeat="bnames in bank_name" value="{{bnames}}">
            {{bnames}}

          </md-option>

        </md-select>
		 <div ng-messages="userForm.bank_name.$error">
          <div ng-message="required">This is required.</div>
         </div>

	   </md-input-container>
        <md-input-container>
        <label>หมายเลขบัญชี</label>
        <input required name="bank_number"  type="text" name="bank_number"  ng-model="user.bank_number">
		<div ng-messages="userForm.bank_number.$error">
          <div ng-message="required">This is required.</div>
         </div>
	  </md-input-container>
      <md-input-container class="md-block">
        <label>ประเภทสมาชิก</label>
        <md-select ng-model="user_init.mtype" required name="m_type">
          <md-option ng-repeat="mtypes in m_type" value="{{mtypes}}">
   {{mtypes}}
          </md-option>
		  </md-select>
		  <div ng-messages="userForm.m_type.$error">
          <div ng-message="required">This is required.</div>
         </div>
      </md-input-container>
        <md-input-container>
        <label>เบอร์โทรศัพท์</label>
         <input required name="phone_number" type="text" name="phone_number"  ng-model="user.phone_number">
		 <div ng-messages="userForm.phone_number.$error">
          <div ng-message="required">This is required.</div>
         </div>

	   </md-input-container>
	   <input type="hidden" name="ID" ng-model="user.id">

<button type="submit" class="md-raised md-primary">Submit</button>
    </form>

    </div>
  </div>';

}else{  //check require filed is not empty

      echo "สวัสดี= ".$row["user_login"];
}
      //echo  $row["channel"];
    }

  }else{

echo "welcome page";

}


?>
</div>

		<?php get_sidebar(); ?>
		<?php get_footer(); ?>
