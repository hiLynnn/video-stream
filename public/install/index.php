<?php
session_start();

require_once '../lb_helper.php'; // Include LicenseBox external/client api helper file
$api = new LicenseBoxAPI(); // Initialize a new LicenseBoxAPI object
 
$filename = 'database.sql';

$product_info=$api->get_latest_version();

function getBaseUrl() {
     
     if( isset($_SERVER['HTTPS'] ) ) 
      {  
        $file_path = 'https://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
      }
      else
      {
        $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';
      }

      return substr($file_path,0,-8);
}
 
//print_r($product_info);
//exit;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title><?php echo $product_info['product_name']; ?> - Installer</title>
	<!-- Favicons -->
	<link rel="icon" type="image/png" href="img/favicon.png">
	
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css"/>
    <link rel="stylesheet" href="css/fontawesome.min.css"/>
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/sharp-thin.css">
    <link rel="stylesheet" href="css/sharp-solid.css">
    <link rel="stylesheet" href="css/sharp-regular.css">
    <link rel="stylesheet" href="css/sharp-light.css">
	<link rel="stylesheet" href="css/style.css"/>
  </head>
  <body>
    <?php
      $errors = false;
      $step = isset($_GET['step']) ? $_GET['step'] : '';
    ?>
    <div class="container"> 
      <div class="section pt-20 pb-20">
        <div class="column is-6 is-offset-3">
		  <div class="logo_header">
			<a href="https://www.viaviweb.com" target="_blank"><img src="img/viaviweb_logo.png" alt="viaviweb_logo" title="viaviweb_logo"/></a>
		  </div>
          <center class="mb-25">
            <h1><?php echo $product_info['product_name'];?> Installer</h1>
			<span class="version_name">Version 2.3</span>
          </center>
          <div class="box">
            <?php
            switch ($step) {
              default: ?>
                <div class="tabs is-fullwidth">
                  <ul>
                    <li class="is-active">
                      <a>
                        <span>Requirements</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Verify</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Database</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Finish</span>
                      </a>
                    </li>
                  </ul>
                </div>
				 
        <div class="requirement_list">
					<ul>
                <?php  
                // Add or remove your script's requirements below
                if(phpversion() < "8.1"){
                  $errors = true;
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Current PHP version is ".phpversion()."! minimum PHP 8.1 or higher required.</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> You are running PHP version ".phpversion()."</li>";
                }

                if(!extension_loaded('bcmath')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> BCMath PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> BCMath PHP extension available</li>";
                }

                if(!extension_loaded('ctype')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> CTYPE PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> CTYPE PHP extension available</li>";
                }

                if(!extension_loaded('fileinfo')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Fileinfo PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> Fileinfo PHP extension available</li>";
                }

                 if(!extension_loaded('json')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> JSON PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> JSON PHP extension available</li>";
                }

                
                if(!extension_loaded('mbstring')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Mbstring PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> Mbstring PHP extension available</li>";
                }
  

                if(!extension_loaded('openssl')){
                  $errors = true; 
                echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Openssl PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> Openssl PHP extension available</li>";
                }

                if(!extension_loaded('pdo')){
                  $errors = true; 
                echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> PDO PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> PDO PHP extension available</li>";
                }

                if(!extension_loaded('tokenizer')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Tokenizer PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> Tokenizer PHP extension available</li>";
                }
 
               
                if(!extension_loaded('xml')){
                  $errors = true; 
                  echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> XML PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> XML PHP extension available</li>";
                }

                if(!extension_loaded('curl')){
                  $errors = true; 
                echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Curl PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> Curl PHP extension available</li>";
                }
                
                if(!extension_loaded('intl')){
                  $errors = true; 
                echo "<li class='excl_alert'><i class='fa-solid fa-circle-exclamation'></i> Intl PHP extension missing!</li>";
                }else{
                  echo "<li><i class='fa-solid fa-circle-check'></i> Intl PHP extension available</li>";
                }
                  
                ?>
          </ul>
				</div>
                <div class="mt-20" style='text-align: center;'>
                  <?php if($errors==true){ ?>
                  <a href="#" class="button is-link" disabled>NEXT <i class="fa-solid fa-arrow-right pl-10"></i></a>
                  <?php }else{ ?>
                  <a href="index.php?step=0" class="button is-link">NEXT <i class="fa-solid fa-arrow-right pl-10"></i></a>
                  <?php } ?>
                </div><?php
                break;
              case "0": ?>
                <div class="tabs is-fullwidth">
                  <ul>
                    <li>
                      <a>
                        <span>Requirements</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li class="is-active">
                      <a>
                        <span>Verify</span>		
						<i class="fa-solid fa-chevron-right"></i>	
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Database</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Finish</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <?php
                  $license_code = null;
                  $client_name = null;
                  if(!empty($_POST['license'])&&!empty($_POST['client'])){
                    $license_code = strip_tags(trim($_POST["license"]));
                    $client_name = strip_tags(trim($_POST["client"]));
                    /* Once we have the license code and client's name we can use LicenseBoxAPI's activate_license() function for activating/installing the license, if the third parameter is empty a local license file will be created which can be used for background license checks. */
                    $activate_response = $api->activate_license($license_code,$client_name);

                    $_SESSION['envato_buyer_name']=$client_name;
                    $_SESSION['envato_purchase_code']=$license_code;
                     
                    if(empty($activate_response)){
                      $msg='Server is unavailable.';
                    }else{
                      $msg=$activate_response['null'];
                    }
                    if($activate_response['status'] != true){ ?>
                      <form action="index.php?step=0" method="POST">
                        <div class="notification is-danger"><?php echo ucfirst($msg); ?></div>
                        
                        <div class="field">
                          <label class="label" style="display: flex;">Username <p class="control-label-help pl-5">(<p style="color: #0E8BCB">Write your Codecanyon Username</p>)</p></label>
                          <div class="control">
                            <input class="input" type="text" placeholder="enter your name" name="client" required>
                          </div>
                        </div>
                        <div class="field">
                          <label class="label" style="display: flex;">Purchase Code
                          <p class="control-label-help pl-5">(<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where Is My Purchase Code?</a>)</p>
                          </label>
                          <div class="control">
                            <input class="input" type="text" placeholder="enter your purchase" name="license" required>
                          </div>
                        </div>
                        <div class="mt-15" style='text-align: center;'>
                          <button type="submit" class="button is-link">VERIFY <i class="fa-solid fa-arrow-right pl-10"></i></button>
                        </div>
                      </form><?php
                    }else{ 
 
                      ?>



                      <form action="index.php?step=1" method="POST">
                        <div class="notification is-success"><?php echo ucfirst($msg); ?></div>
                        <input type="hidden" name="lcscs" id="lcscs" value="<?php echo ucfirst($activate_response['status']); ?>">
                        <div class="mt-15" style='text-align: center;'>
                          <button type="submit" class="button is-link">NEXT <i class="fa-solid fa-arrow-right pl-10"></i></button>
                        </div>
                      </form><?php
                    }
                  }else{ ?>
                    <form action="index.php?step=0" method="POST">
                      <div class="field">
                        <label class="label" style="display: flex;">Username <p class="control-label-help pl-5">(<p style="color: #0E8BCB">Write your Codecanyon Username</p>)</p></label>
                        <div class="control">
                          <input class="input" type="text" placeholder="username" name="client" required>
                        </div>
                      </div>
                      <div class="field">
                        <label class="label" style="display: flex;">Purchase Code
                          <p class="control-label-help pl-5">(<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank" style="color:#10B149">Where Is My Purchase Code?</a>)</p>
                        </label>
                        <div class="control">
                          <input class="input" type="text" placeholder="enter your purchase" name="license" required>
                        </div>
                      </div>
                      
                      <div class="mt-15" style='text-align: center;'>
                        <button type="submit" class="button is-link">VERIFY <i class="fa-solid fa-arrow-right pl-10"></i></button>
                      </div>
                    </form>
                  <?php } 
                break;
              case "1": ?>
                <div class="tabs is-fullwidth">
                  <ul>
                    <li>
                      <a>
                        <span>Requirements</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Verify</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li class="is-active">
                      <a>
                        <span>Database</span>
						<i class="fa-solid fa-chevron-right"></i>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Finish</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <?php
                  if($_POST && isset($_POST["lcscs"])){
                    $valid = strip_tags(trim($_POST["lcscs"]));
                    $db_host = strip_tags(trim($_POST["host"]));
                    $db_user = strip_tags(trim($_POST["user"]));
                    $db_pass = strip_tags(trim($_POST["pass"]));
                    $db_name = strip_tags(trim($_POST["name"]));
                    // Let's import the sql file into the given database
                    if(!empty($db_host)){

                      $myfile = fopen("../../.env", "w") or die("Unable to open file!");
                      $txt = "";
                      fwrite($myfile, $txt);
                      $txt = "APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:1rEFpUtOFXmy15sMO6Fie+uC1fz6bZlWGLTAIdOPcOE=
APP_DEBUG=true
APP_URL=http://localhost/

APP_TIMEZONE=Asia/Kolkata
APP_LANG=en

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=".$db_host."
DB_PORT=3306
DB_DATABASE=".$db_name."
DB_USERNAME=".$db_user."
DB_PASSWORD=".$db_pass."

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=SSL
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY=
MIX_PUSHER_APP_CLUSTER=

STRIPE_SECRET=

BUYER_NAME=
BUYER_PURCHASE_CODE=
BUYER_EMAIL=
BUYER_APP_PACKAGE_NAME=com.example.videostreamingapp

GOOGLE_CLIENT_DI=
GOOGLE_SECRET=
GOOGLE_REDIRECT=

FB_APP_ID=
FB_SECRET=
FB_REDIRECT=

PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=
PAYPAL_SANDBOX_CLIENT_SECRET=
PAYPAL_LIVE_CLIENT_ID=
PAYPAL_LIVE_CLIENT_SECRET=                      
";
                      fwrite($myfile, $txt);
                      fclose($myfile);

                      $con = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

                      mysqli_query($con,"SET NAMES 'utf8'");  

                      if(mysqli_connect_errno()){ ?>
                        <form action="index.php?step=1" method="POST">
                          <div class='notification is-danger'>Failed to connect to MySQL: <?php echo mysqli_connect_error(); ?></div>
                          <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
                          <div class="field">
                            <label class="label">Database Host</label>
                            <div class="control">
                              <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Username</label>
                            <div class="control">
                              <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Password</label>
                            <div class="control">
                              <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Name</label>
                            <div class="control">
                              <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
                            </div>
                          </div>
                          <div class="mt-15" style='text-align: center;'>
                            <button type="submit" class="button is-link">IMPORT <i class="fa-solid fa-arrow-right pl-10"></i></button>
                          </div>
                        </form><?php
                        exit;
                      }
                      $templine = '';
                      $lines = file($filename);
                      foreach($lines as $line){
                        if(substr($line, 0, 2) == '--' || $line == '')
                          continue;
                        $templine .= $line;
                        $query = false;
                        if(substr(trim($line), -1, 1) == ';'){
                          $query = mysqli_query($con, $templine);
                          $templine = '';
                        }
                      } 

                      //Update buyer name and code
                      $envato_sql="UPDATE settings SET `envato_buyer_name` = '".$_SESSION['envato_buyer_name']."',`envato_purchase_code` = '".$_SESSION['envato_purchase_code']."'WHERE `id`='1'";
                      mysqli_query($con, $envato_sql);
                       
                      ?>
                    <form action="index.php?step=2" method="POST">
                      <div class='notification is-success'>Database was Successfully Imported.</div>
                      <input type="hidden" name="dbscs" id="dbscs" value="true">
                      <div class="mt-15" style='text-align: center;'>
                        <button type="submit" class="button is-link">NEXT <i class="fa-solid fa-arrow-right pl-10"></i></button>
                      </div>
                    </form><?php
                  }else{ ?>
                    <form action="index.php?step=1" method="POST">
                      <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
                      <div class="field">
                        <label class="label">Database Host</label>
                        <div class="control">
                          <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Database Username</label>
                        <div class="control">
                          <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Database Password</label>
                        <div class="control">
                          <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Database Name</label>
                        <div class="control">
                          <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
                        </div>
                      </div>
                      <div class="mt-15" style='text-align: center;'>
                        <button type="submit" class="button is-link">IMPORT <i class="fa-solid fa-arrow-right pl-10"></i></button>
                      </div>
                    </form><?php
                } 
              }else{ ?>
                <div class='notification is-danger'>Sorry, Something Went Wrong.</div><?php
              }
              break;
            case "2": ?>
              <div class="tabs is-fullwidth">
                <ul>
                  <li>
                    <a>
                      <span>Requirements</span>
					  <i class="fa-solid fa-chevron-right"></i>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span>Verify</span>
					  <i class="fa-solid fa-chevron-right"></i>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span>Database</span>
					  <i class="fa-solid fa-chevron-right"></i>
                    </a>
                  </li>
                  <li class="is-active">
                    <a>
                      <span>Finish</span>
                    </a>
                  </li>
                </ul>
              </div>
              <?php
              if($_POST && isset($_POST["dbscs"])){
                $valid = $_POST["dbscs"];
                ?>
                <center>
                  <p class="successfull_text"><strong><?php echo $product_info['product_name']; ?> is Successfully Installed.</strong></p>
                  <br>
                  <p class="login_using_text">You can Now Login Using Default Email: <strong>admin@admin.com</strong><br> and Default Password: <strong>admin</strong></p><br><strong>
                  <p><a class='button is-link' href='../admin'>LOGIN <i class="fa-solid fa-arrow-right pl-10"></i></a></p></strong>
                  <p class='first_thing help has-text-grey'>The First Thing you Should do is Change your Account Details.</p>
                </center>
                <?php
              }else{ ?>
                <div class='notification is-danger'>Sorry, Something Went Wrong.</div><?php
              } 
            break;
          } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="purchas_message">
	<h2>Thank you for Purchasing Our Product,</h2>
	<h3>If you Have any Questions or Want Customization Contact Us.</h3>
	<div class="whatsapp_dtl"><span style="color:#10B149;">WhatsApp:</span> <a href="https://wa.me/+919227777522?text=Inquiry" target="_blank">+91 92277 77522</a></div>
	<div class="skype_dtl"><span style="color:#0E8BCB;">Skype:</span> <a href="skype:viaviwebtech?call" target="_blank">support.viaviweb</a></div>
	<div class="email_dtl"><span style="color:#FF1B1B;">Email:</span> <a href="mailto:info@viaviweb.com">info@viaviweb.com</a></div>
  </div>
  <div class="content has-text-centered">
    <p class="pb-20">Copyright <?php echo date('Y'); ?> <a href="https://www.viaviweb.com" style="color:#0E8BCB;" target="_blank"><b>viaviweb.com</b></a>, All rights reserved.</p>
  </div>
</body>
</html>
 