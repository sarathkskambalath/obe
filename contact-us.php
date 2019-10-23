   <?php
  require_once "php/config.php";
	$_PHP_SELF   = $_SERVER['PHP_SELF'];
	$REQUEST_URI = '';
  $flag        = 'null';

   $content = 'This is about us page content';
   require_once('common/header.php');

   if( isset($_POST['sendmsg']) ) {

   	$flag     = 1;

    $name     = !empty($_POST['name'])?$_POST['name']:$flag   = 0;
   	$email    = !empty($_POST['email'])?$_POST['email']:$flag = 0;
   	$phone    = !empty($_POST['phone'])?$_POST['phone']:$flag = 0;
   	$message  = !empty($_POST['message'])?$_POST['message']:$flag = 0;
    $from     = 'info@obearchitects.com';
    $subject  = 'Successfully Submited Contact Form of "obearchitects.com".';

   	if($flag  == 1){
      $dataAraay = array('from'=>$from,'name'=>$name,'subject'=>$subject,'email'=>$email,'phone'=>$phone,'message'=>$message);
   		$objSendEmail->send_contact_us($dataAraay);
   	}

   }

?>
        <!-- MAIN-->
        <main id="main">
            <!-- PAGE LINE-->
            <div class="page-line">
                <div class="container">
                    <div class="page-line__inner">
                        <div class="page-col"></div>
                        <div class="page-col"></div>
                        <div class="page-col"></div>
                    </div>
                </div>
            </div>
            <!-- END PAGE LINE-->

            <!-- PAGE HEADING-->


            <section class="section p-t-100 p-b-65">
                <div class="container">
                    <div class="page-heading">
                        <h4 class="title-sub title-sub--c8 m-b-15">Contact Us </h4>

                    </div>
                </div>
            </section>
            <!-- END PAGE HEADING-->

            <!-- CONTACT-->

            <section class="section p-b-80">
                <div class="container">
                    <div class="map-wrapper  p-b-80">
                        <div id="map" style="width:100%; height:250px;"></div>

                    </div>
                    <div class="row no-gutters">
                        <div class="col-lg-4">
                            <div class="contact-info">
                                <div class="contact-info__item">
                                    <h5 class="title--sm2">address:</h5>
                                    <p class="value">Off.No 602, A-Block Gulf Towers, Oud Metha, Dubai, UAE</p>
                                </div>
                                <div class="contact-info__item">
                                    <h5 class="title--sm2">PHONE NUMBER :</h5>
                                    <p class="value">+971 4 370 71 71</p>
                                </div>
                                <div class="contact-info__item">
                                    <h5 class="title--sm2">email:</h5>
                                    <p class="value">info@obearchitects.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                        	<?php
                        		if($flag == 1){
                        			echo '<div class="alert alert-success" role="alert">
            										        Your Contact Information is Successfully Submited!
            										    </div>';
            								}elseif($flag == 0 & isset($_POST['sendmsg']) ){
            									echo '<div class="alert alert-danger" role="alert">
            											       Submition went error!
  										              </div>';
                            }
                        	?>
                            <form class="form-contact-js-contact-form" method="POST" action="<?= $_PHP_SELF; ?>">
                                <div class="form-row no-gutters-">
                                    <div class="col-md-6">
                                        <input class="au-input" type="text" name="name" placeholder="Name*" required="required">
                                        <input class="au-input" type="email" name="email" placeholder="Email Address*" required="required" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
                                        <input class="au-input" type="text" name="phone" placeholder="Phone*" required="required">
                                    </div>
                                    <div class="col-md-6 p-r-0">
                                        <textarea class="au-textarea" name="message" placeholder="Message*" required="required"></textarea>
                                        <div class="text-right">
                                            <button class="au-btn au-btn-solid" type="submit" name="sendmsg">Send message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END CONTACT-->


        </main>
        <!-- MAIN-->
   <?php
   $content = 'This is about us page content';
   include('common/footer-contact.php');
?>
