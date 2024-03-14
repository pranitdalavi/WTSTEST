<?php

namespace App\Helpers;

use App\ProductImage;

class Mail
{

    public static function send($emailAddress, $message, $subject, $bcs)
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

        if($bcs == true){
            $email->AddBCC("www-comfortbedsltd-co-uk@b2b.reviews.co.uk");


        }

        $email->Send();

    }



    public static function sendMail($emailAddress, $message, $subject, $fullname)
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

        $email->Send();

    }


    public static function enquiry()
    {

	$message = '<table width="500" cellpadding="10" cellspacing="0" border="1" style="font-family:arial">';
	$message .= '<tr><td colspan="2" bgcolor="#EAEAEA"><strong>You have a website enquiry</strong></td></tr>';
	$message .= '<tr><td>Contact Name:</td><td>'.$_POST['name'].'</td></tr>';
	$message .= '<tr><td>Email Address:</td><td>'.$_POST['email'].'</td></tr>';

        $message .= '<tr><td>Phone:</td><td>'.$_POST['phone'].'</td></tr>';
	$message .= '<tr><td>Message:</td><td>'.$_POST['message'].'</td></tr>';

	$message .= '</table>';
	self::send(SMTP_EMAIL, $message, 'Enquiry Form', false);
    return redirect(DOMAIN . "/contact-us", "Thank you for getting in touch with us, we will get back to you as soon as possible!");


    }
    public static function swatches()
    {

        $message = "<p>Name: ". $_POST["name"] ."</p>";
        $message .= "<p>E-mail: ". $_POST["email"] ."</p>";
        $message .= "<p>Phone: ". $_POST["phone"] ."</p>";
        $message .= "<p>Address 1: ". $_POST["address1"] ."</p>";
        $message .= "<p>Address 2: ". $_POST["address2"] ."</p>";
        $message .= "<p>City: ". $_POST["city"] ."</p>";
        $message .= "<p>Postcode: ". $_POST["postcode"] ."</p>";
        $message .= "<p>Country: ". $_POST["country"] ."</p>";

        $swatches = str_replace(",",", ", $_POST["swatches"]);
        $message .= "<p>Swatches: ". $swatches ."</p>";

	self::send(SMTP_EMAIL, $message, 'Sample Order', false);
    return redirect(DOMAIN . "/swatches", "Thank you for ordering swatches with us. We will handle your order straight away and you should receive your samples in 3 - 7 days!");


    }

    public static function shareEmail($row,$sendTo)
    {


        $productImageObj = new ProductImage();
$i = 1;
$image = "";
foreach ($productImageObj->getAll($row->id) as $product_image) {
    $image = DOMAIN ."/product-images/". $product_image->id.".".$product_image->ext;
    break;
}




        $message = '<table>
            <tr>
            <td>
            <div style="background: #f2f2f2;padding: 15px;border-radius: 10px;">
            <img src="'. $image .'" style="width: 100%;"> 
                <h1 style="margin-top: 3px !important;font-size: 27px;font-family: Calibri">'. $row->title .'</h1>
                <p style="margin-bottom: 0px !important;font-weight: 500;font-family: Calibri">Availability: <span style="width: 10px;height: 10px;border-radius: 100%;background:#1fac1f;display: inline-block;margin-right: 1px; "></span> '. $row->qty_available .' in stock</p>
                
               
                    
                    
                <p style="margin-top: 5px !important;font-family: Calibri">Price: &pound;'. $row->price .'</p>
                <div style="">
                <a href="'. DOMAIN .'/product/'. $row->seo_url .'" target="_blank">
                    <button onclick="window.location.href="'. DOMAIN .'/product/'. $row->seo_url .'" style="font-family: Calibri;width: 100%;background: #3a004a;color:white;border:0 !important;border-radius: 5px;padding: 6px;padding-left: 15px !important;padding-right: 15px !important;">VIEW PRODUCT</button>
                    
                </a>
                   
                </div>
</div>
                
               
            </td>
            </tr>
        </table>';

        self::send(SMTP_EMAIL, $message, $row->title, COMPANY_NAME);
        return redirect(DOMAIN . "/product/".$row->seo_url, "Thank you for sharing this product!");


    }
    

    public static function newsletter()
    {

	$message = "You have a newsletter sign up.<br /><br />Email: ".$_POST['newsletter_email'];
	self::send('info@wts-group.com', $message, 'Newsletter Sign Up', COMPANY_NAME);
	return redirect( 'contact', 'Thank you, you have been added to our mailing list' );

    }


    public static function emailHeader()
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
    public static function emailFooter()
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
