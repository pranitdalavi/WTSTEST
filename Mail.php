<?php

namespace App\Helpers;
$orderItemObj = new \App\Orderitem();
$extraObj = new \App\Extra();
$orderObj = new \App\Order();
$productObj = new \App\Product();
class Mail
{

    public static function send($emailAddress, $message, $subject ,$fromEmail,$bcc = false)
    {

	$message = self::emailHeader().$message.self::emailFooter();

        require_once __DIR__.'/../../includes/class.phpmailer.php';

        $email = new \PHPMailer();

        $email->IsSMTP();

        //$email->SMTPDebug  = 2;

        $email->Encoding = "base64";

        $email->SMTPAuth   = true;

        $email->Host       = SMTP_HOST;

        $email->Port       = 587;

        $email->Username   = SMTP_EMAIL;

        $email->Password   = SMTP_PASSWORD;

        $email->From      = SMTP_EMAIL;

        $email->FromName  = COMPANY_NAME;

        $email->Subject   = $subject;

        $email->MsgHTML($message);

        $email->AddAddress( trim($emailAddress) );
        if($bcc == true){
            $email->AddBCC("www-comfortbedsltd-co-uk@b2b.reviews.co.uk");
        }

        $email->Send();

    }
    public static function sendNewletter($emailAddress, $message, $subject ,$fromEmail)
    {

	$message = self::emailHeaderNewletter().$message.self::emailFooterNewletter();
/*
        require_once __DIR__.'/../../includes/class.phpmailer.php';

        $email = new \PHPMailer();

        $email->IsSMTP();

        //$email->SMTPDebug  = 2;

        $email->Encoding = "base64";

        $email->SMTPAuth   = true;

        $email->Host       = SMTP_HOST;

        $email->Port       = 587;

        $email->Username   = SMTP_EMAIL;

        $email->Password   = SMTP_PASSWORD;

        $email->From      = SMTP_EMAIL;

        $email->FromName  = COMPANY_NAME;

        $email->Subject   = $subject;

        $email->MsgHTML($message);

        $email->AddAddress( trim($emailAddress) );

        $email->Send();
*/

        require __DIR__.'/../../includes/class.phpmailer.php';

        $mail = new \PHPMailer();

        if($_SERVER['HTTP_HOST'] == "localhost"){

            $mail->IsSMTP();

        }

        $mail->Encoding = "base64";
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth   = true;
        $mail->Host       = SMTP_HOST;
        $mail->Port       = 25;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SetFrom(SMTP_EMAIL, COMPANY_NAME);
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress( trim($emailAddress));
        $mail->Send();
    }


    public static function enquiry()
    {

        $message = '<p style="text-align: center"><b>Enquiry Form</b><hr></p>';
        $message .= "<p>Name - " . $_POST["name"] . "</p>";
        $message .= "<p>Email - " . $_POST["email"] . "</p>";
        $message .= "<p>Telephone - " . $_POST["phone"] . "</p>";
        $message .= "<p>Subject - " . $_POST["subject"] . "</p>";
        $message .= "<p>Message - " . $_POST["message"] . "</p>";

        self::sendNewletter(SMTP_EMAIL, $message, COMPANY_NAME. ' - Enquiry Form', COMPANY_NAME);
        return redirect( 'contact#confirmation', 'Thank you for contacting us. A member of our team will be in touch with you shortly!' );


    }



    public static function book_a_table()
    {
        $occasion = $_POST["occasion"];

        $special_requirements = $_POST["special_requirements"];
        if($_POST["occasion"] == ""){
            $occasion = "Not specified";
        }
        if($_POST["special_requirements"] == ""){
            $special_requirements = "Not specified";
        }

        $message = '<p style="text-align: center"><b>TABLE BOOKING</b><hr></p>';
        $message .= "<p>Thank you for making a reservation with us. You can find your information down below that you've given. We'll see you at Thai Sun soon!</p><br>";



        $message .= "<p>Name - " . $_POST["name"] . "</p>";
        $message .= "<p>Telephone - " . $_POST["telephone"] . "</p>";
        $message .= "<p>Email - " . $_POST["email"] . "</p>";
        $message .= "<p>Occasion - " . $occasion . "</p>";
        $message .= "<p>Date - " . date_format(date_create($_POST["date"]),"d/m/Y") . "</p>";
        $message .= "<p>Time - " . $_POST["time"] . "</p>";
        $message .= "<p>Number of People - " . $_POST["no_people"] . "</p>";
        $message .= "<p>Special Requirements - " . $special_requirements . "</p>";

        $message .= "<br><br><p><small>If any of the above details are incorrect or you wish to cancel your booking please give us a call on <a href='tel:0113 318 7268'>0113 318 7268</a>. Please be aware that cancellation has to be made 24 hours prior to your reservation date.</small></p>";
        self::sendNewletter(SMTP_EMAIL, $message, COMPANY_NAME. ' - Table Booking', COMPANY_NAME);
        self::sendNewletter($_POST["email"], $message, COMPANY_NAME. ' - Table Booking', COMPANY_NAME);
        return redirect( 'book-a-table#confirmation', 'Thank you for booking with us. We have sent you a confirmation email!' );

    }
    public static function password_reset($token,$name,$email){
        $message = '<p style="text-align: center"><b>PASSWORD RESET</b><hr></p>';
        $message .= "<p>Hello ".$name.", please click the link below where you can reset your password!</p><br>";


        $message .= '<p class="text-center"><a href="'.DOMAIN.'/change-password.php?remember_token='.$token.'">Reset Link</a></p>';
        self::sendNewletter($email, $message, COMPANY_NAME. ' - Password Reset', COMPANY_NAME);
    }
    public static function order_confirmation($content,$orderCurrent)
    {



        $message = '<p style="text-align: center"><b>ORDER CONFIRMATION</b><hr></p>';
        $message .= "<p>Thank you for ordering with us. Your order is getting ready and will be ready within 45mins!</p>";

        $message .= "<Br><p><b>Your Order</b></p><hr>";



        $message .= $content;



        $message .= "<br><p><b>Delivery Information</b></p><hr>";
        $message .= "<p>Payment Method : ".$orderCurrent->payment_method."</p>";
        $message .= "<p>First Name : ".$orderCurrent->first_name."</p>";
        $message .= "<p>Last Name : ".$orderCurrent->last_name."</p>";
        $message .= "<p>Email : ".$orderCurrent->email."</p>";
        $message .= "<p>Phone : ".$orderCurrent->mobile."</p>";

        $message .= "<p>Address 1 : ".$orderCurrent->address1."</p>";
        $message .= "<p>Address 2 : ".$orderCurrent->address2."</p>";
        $message .= "<p>City : ".$orderCurrent->city."</p>";
        $message .= "<p>Postcode : ".$orderCurrent->postcode."</p>";
        $message .= "<p>Note : ".$orderCurrent->note."</p>";



        $message .= "<br><p>If you experience any issue with the order, please dont hesitate to get in touch on: <a href='tel:0113 318 7268'>0113 318 7268</a></p>";
        self::sendNewletter(SMTP_EMAIL, $message, 'Order Confirmation', COMPANY_NAME);
        self::sendNewletter($orderCurrent->email, $message,'Order Confirmation', COMPANY_NAME);

    }

    public static function newsletter()
    {

        $message = 'TEST EMAIL';
        self::sendNewletter(SMTP_EMAIL, $message, 'Enquiry Form', COMPANY_NAME);
        return redirect( 'contact', 'Thank you, your enquiry has been sent' );

    }


    public static function emailHeader()
    {

	return '<!DOCTYPE HTML>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Message</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
  #absolute{position: absolute !important;}
</style>
</head>

<body bgcolor="#FFFFFF">
  <table border="0" cellpadding="10" cellspacing="0" style=
  "background-color: #FFFFFF" width="100%">
    <tr>
      <td>
        <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->

        <table align="center" border="0" cellpadding="0" cellspacing="0" class=
        "content" style="background-color: #FFFFFF">
          <tr>
            <td id="templateContainerHeader" valign="top" mc:edit="welcomeEdit-01">
              <p style="text-align:center;margin:0;padding:0;"><img width="181" src="'.DOMAIN.'/images/logo.png" style="display:inline-block;"></p>
			<br><br>
            </td>
          </tr>

          <tr>
            <td align="center" valign="top">';

    }
   public static function emailFooter()
    {

	return '</td>
                </tr>
              </table>
            </td>
          </tr>
 
          <tr>
            <td align="center" class="unSubContent" id="bodyCellFooter" valign=
            "top">
              <table border="0" cellpadding="0" cellspacing="0" id=
              "templateContainerFooter" width="100%">
                <tr>
                  <td valign="top" width="100%" mc:edit="welcomeEdit-11">

                    <p style="text-align:center;margin-top: 20px; color:#A1A1A1;font-size:14px;margin-bottom:0px">'.COMPANY_NAME.'</p>
                    <p style="text-align:center;margin-top: 0px; color:#A1A1A1;font-size:14px"><a style="color:#A1A1A1;text-decoration:none" href="'.DOMAIN.'">'.DOMAIN.'</a></p>

                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table><!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
      </td>
    </tr>
  </table>

  <style type="text/css">

    span.preheader {
    display:none!important
    }
    td ul li {
      font-size: 16px;
    }
    
    p{ font-size:16px }

    /* /\/\/\/\/\/\/\/\/ CLIENT-SPECIFIC STYLES /\/\/\/\/\/\/\/\/ */
    #outlook a {
    padding:0
    }

    /* Force Outlook to provide a "view in browser" message */
    .ReadMsgBody {
    width:100%
    }

    .ExternalClass {
    width:100%
    }

    /* Force Hotmail to display emails at full width */
    .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {
    line-height:100%
    }

    /* Force Hotmail to display normal line spacing */
    body,table,td,p,a,li,blockquote {
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%
    }

    /* Prevent WebKit and Windows mobile changing default text sizes */
    table,td {
    mso-table-lspace:0;
    mso-table-rspace:0
    }

    /* Remove spacing between tables in Outlook 2007 and up */
    /* /\/\/\/\/\/\/\/\/ RESET STYLES /\/\/\/\/\/\/\/\/ */
    body {
    margin:0;
    padding:0
    }

    img {
    max-width:100%;
    border:0;
    line-height:100%;
    outline:none;
    text-decoration:none
    }

    table {
    border-collapse:collapse!important
    }

    .content {
    width:100%;
    max-width:600px
    }

    .content img {
    height:auto;
    min-height:1px
    }

    #bodyTable {
    margin:0;
    padding:0;
    width:100%!important
    }

    #bodyCell {
    margin:0;
    padding:0
    }

    #bodyCellFooter {
    margin:0;
    padding:0;
    width:100%!important;
    padding-top:39px;
    padding-bottom:15px
    }

    body {
    margin:0;
    padding:0;
    min-width:100%!important
    }

    #templateContainerHeader {
    font-size:16px;
    padding-top:1.429em;
    padding-bottom:.929em
    }

    #templateContainerFootBrd {
    border-bottom:1px solid #e2e2e2;
    border-left:1px solid #e2e2e2;
    border-right:1px solid #e2e2e2;
    border-radius:0 0 4px 4px;
    background-clip:padding-box;
    border-spacing:0;
    height:10px;
    width:100%!important
    }

    #templateContainer {
    border-top:1px solid #e2e2e2;
    border-left:1px solid #e2e2e2;
    border-right:1px solid #e2e2e2;
    border-radius:4px 4px 0 0;
    background-clip:padding-box;
    border-spacing:0
    }

    #templateContainerMiddle {
    border-left:1px solid #e2e2e2;
    border-right:1px solid #e2e2e2
    }

    #templateContainerMiddleBtm {
    border-left:1px solid #e2e2e2;
    border-right:1px solid #e2e2e2;
    border-bottom:1px solid #e2e2e2;
    border-radius:0 0 4px 4px;
    background-clip:padding-box;
    border-spacing:0
    }

    #templateContainerMiddleBtm .bodyContent {
    padding-bottom:2em
    }



    .unSubContent a:visited {
    color:#a1a1a1;
    text-decoration:underline;
    font-weight:400
    }

    .unSubContent a:focus {
    color:#a1a1a1;
    text-decoration:underline;
    font-weight:400
    }

    .unSubContent a:hover {
    color:#a1a1a1;
    text-decoration:underline;
    font-weight:400
    }

    .unSubContent a:link {
    color:#a1a1a1;
    text-decoration:underline;
    font-weight:400
    }

    .unSubContent a .yshortcuts {
    color:#a1a1a1;
    text-decoration:underline;
    font-weight:400
    }

    .unSubContent h6 {
    color:#a1a1a1;
    font-size:12px;
    line-height:1.5em;
    margin-bottom:0
    }

    .bodyContent {
    color:#505050;
    font-family:Helvetica;
    font-size:14px;
    line-height:150%;
    padding-top:3.143em;
    padding-right:3.5em;
    padding-left:3.5em;
    padding-bottom:.714em;
    text-align:left
    }

    .bodyContentImage {
    color:#505050;
    font-family:Helvetica;
    font-size:14px;
    line-height:150%;
    padding-top:0;
    padding-right:3.571em;
    padding-left:3.571em;
    padding-bottom:1.357em;
    text-align:left
    }

    .bodyContentImage h4 {
    color:#4E4E4E;
    font-size:13px;
    line-height:1.154em;
    font-weight:400;
    margin-bottom:0
    }

    .bodyContentImage h5 {
    color:#828282;
    font-size:12px;
    line-height:1.667em;
    margin-bottom:0
    }


    a:visited {
    color:#3386e4;
    text-decoration:none;
    }

    a:focus {
    color:#3386e4;
    text-decoration:none;
    }

    a:hover {
    color:#3386e4;
    text-decoration:none;
    }

    a:link {
    color:#3386e4;
    text-decoration:none;
    }

    a .yshortcuts {
    color:#3386e4;
    text-decoration:none;
    }

    .bodyContent img {
    height:auto;
    max-width:498px
    }

    .footerContent {
    color:gray;
    font-family:Helvetica;
    font-size:10px;
    line-height:150%;
    padding-top:2em;
    padding-right:2em;
    padding-bottom:2em;
    padding-left:2em;
    text-align:left
    }


    .footerContent a:link,.footerContent a:visited,/* Yahoo! Mail Override */ .footerContent a .yshortcuts,.footerContent a span /* Yahoo! Mail Override */ {
    color:#606060;
    font-weight:400;
    text-decoration:underline
    }


    .bodyContentImageFull p {
    font-size:0!important;
    margin-bottom:0!important
    }

    .brdBottomPadd {
    border-bottom:1px solid #f0f0f0
    }

    .brdBottomPadd-two {
    border-bottom:1px solid #f0f0f0
    }

    .brdBottomPadd .bodyContent {
    padding-bottom:2.286em
    }

    .brdBottomPadd-two .bodyContent {
    padding-bottom:.857em
    }

    a.blue-btn {
      background: #5098ea;
      display: inline-block;
      color: #FFFFFF;
      border-top:10px solid #5098ea;
      border-bottom:10px solid #5098ea;
      border-left:20px solid #5098ea;
      border-right:20px solid #5098ea;
      text-decoration: none;
      font-size: 14px;
      margin-top: 1.0em;
      border-radius: 3px 3px 3px 3px;
      background-clip: padding-box;
    }

    .bodyContentTicks {
    color:#505050;
    font-family:Helvetica;
    font-size:14px;
    line-height:150%;
    padding-top:2.857em;
    padding-right:3.5em;
    padding-left:3.5em;
    padding-bottom:1.786em;
    text-align:left
    }

    .splitTicks {
    width:100%
    }

    .splitTicks--one {
    width:19%;
    color:#505050;
    font-family:Helvetica;
    font-size:14px;
    padding-bottom:1.143em
    }

    .splitTicks--two {
    width:5%
    }

    .splitTicks--three {
    width:71%;
    color:#505050;
    font-family:Helvetica;
    font-size:14px;
    padding-top:.714em
    }

    .splitTicks--three h3 {
    margin-bottom:.278em
    }

    .splitTicks--four {
    width:5%
    }

    @media only screen and (max-width: 550px),screen and (max-device-width: 550px) {
    body[yahoo] .hide {
    display:none!important
    }

    body[yahoo] .buttonwrapper {
    background-color:transparent!important
    }

    body[yahoo] .button {
    padding:0!important
    }

    body[yahoo] .button a {
    background-color:#e05443;
    padding:15px 15px 13px!important
    }

    body[yahoo] .unsubscribe {
    font-size:14px;
    display:block;
    margin-top:.714em;
    padding:10px 50px;
    background:#2f3942;
    border-radius:5px;
    text-decoration:none!important
    }
    }

    @media only screen and (max-width: 480px),screen and (max-device-width: 480px) {
      .bodyContentTicks {
        padding:6% 5% 5% 6%!important
      }

      .bodyContentTicks td {
        padding-top:0!important
      }

      h1 {
        font-size:34px!important
      }

      h2 {
        font-size:30px!important
      }

      h3 {
        font-size:24px!important
      }

      h4 {
        font-size:18px!important
      }

      h5 {
        font-size:16px!important
      }

      h6 {
        font-size:14px!important
      }

      p {
        font-size:18px!important
      }

      .brdBottomPadd .bodyContent {
        padding-bottom:2.286em!important
      }

      .brdBottomPadd-two .bodyContent {
        padding-bottom:.857em!important
      }

      #templateContainerMiddleBtm .bodyContent {
        padding:6% 5% 5% 6%!important
      }

      .bodyContent {
        padding:6% 5% 1% 6%!important
      }

      .bodyContent img {
        max-width:100%!important
      }

      .bodyContentImage {
        padding:3% 6% 6%!important
      }

      .bodyContentImage img {
        max-width:100%!important
      }

      .bodyContentImage h4 {
        font-size:16px!important
      }

      .bodyContentImage h5 {
        font-size:15px!important;
        margin-top:0
      }
    }
    .ii a[href] {color: inherit !important;}
    span > a, span > a[href] {color: inherit !important;}
    a > span, .ii a[href] > span {text-decoration: inherit !important;}
  </style>

</body>
</html>';

    }

   public static function emailHeaderNewletter()
    {

	return '<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
        <style>
                        table{
                            width: 100%;
                        }
                        table tr td{
                            font-size: 14px !important;
                            vertical-align: baseline;
                            padding-bottom: 15px !important;
                               
                            
                        }
                       
                        table tr{
                        border-spacing: 25px !important;
                        }
                       
                        
                    </style>
    <style>
    *{
    word-break: normal !important; border-collapse : collapse !important;
    }
        @media  only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body style="box-sizing: border-box; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;"><tbody><tr>
    <td align="center" style="box-sizing: border-box; position: relative;">
        <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
            <tbody><tr>
                <td class="header" style="box-sizing: border-box; position: relative; padding: 25px 0; text-align: center;">
                    <a target="_blank" rel="noopener noreferrer" href="'. DOMAIN .'" style="box-sizing: border-box; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
                        <h1>'. COMPANY_NAME .'</h1>
                    </a>
                </td>
            </tr>
            <!-- Email Body --><tr>
                <td class="body" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; position: relative; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">
                    <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; position: relative; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
                        <!-- Body content --><tbody><tr>
                        <td class="content-cell" style="box-sizing: border-box; position: relative; max-width: 100vw; padding: 32px;">';

    }
   public static function emailFooterNewletter()
    {

	return ' </td>
                    </tr>
                    </tbody></table>
                </td>
            </tr>
            <tr>
                <td style="box-sizing: border-box; position: relative;">
                    <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; position: relative; margin: 0 auto; padding: 0; text-align: center; width: 570px;"><tbody><tr>
                        <td class="content-cell" align="center" style="box-sizing: border-box; position: relative; max-width: 100vw; padding: 32px;">
                            <p style="box-sizing: border-box;position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">'. date("Y") .' '.COMPANY_NAME.'. All rights reserved.</p>

                        </td>
                    </tr></tbody></table>
                </td>
            </tr>
            </tbody></table>
    </td>
</tr></tbody></table>


</body></html>';

    }


}
