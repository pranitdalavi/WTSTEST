<?php

use App\Order;
use App\Product;
use App\ProductImage;
use App\PromoCode;
use App\ProductsFromOrder;
use App\Helpers\Tools;
use Dompdf\Dompdf;
use Dompdf\Options;


$orderObj = new Order;
$promoObj = new PromoCode;
$productsFromOrderObj = new ProductsFromOrder;
$productObj = new Product;
$productImageObj = new ProductImage;


$adminUserId = ($user->auth()->id);


require_once __DIR__.'/../../vendor/autoload.php';

if( !$orderObj->canView($id) && !$user->isAdmin() ){

	return redirect( 'account.php?page=home', 'You are not authourised to view that page!', 'e' );

}
	
	$row = $orderObj->find($id);
	$user_row = $user->find($row->user_id);
	$query = $productsFromOrderObj->getAll($id);

    // if( isset($action) && $action == 'send-dispatched' && $user->isAdmin() & isset($id) ){
    //     $orderObj->updateStatusDispatched($id);
    //     $orderObj->sendDispatchedEmail($id);
    //     return redirect(DOMAIN . "/console/account?page=order&id=" . $id, 'The dispatched email has been sent.' );
    // }
    // if( isset($action) && $action == 'send-cancelled' && $user->isAdmin() & isset($id) ){
    //     $orderObj->updateStatusCancelled($id);
    //     $orderObj->sendCancelledEmail($id);
    // }


if( isset($_POST['dispatchedEmail']) && $_POST['dispatchedEmail'] == 'yes'){

    $orderObj->updateStatusDispatched($_GET["id"], $adminUserId);
    $orderObj->sendDispatchedEmail($_GET["id"]);

}
if( isset($_POST['cancelledEmail']) && $_POST['cancelledEmail'] == 'yes' && $user->isAdmin()){
    $orderObj->updateStatusCancelled($id);
    $orderObj->sendCancelledEmail($id);
}



if( isset($_POST['status']) && $user->isAdmin() & isset($id) ){

    $orderObj->updateStatus($id);

}

    function mime_types($ext = '') {
    $mimes = array(
      'hqx'   =>  'application/mac-binhex40',
      'cpt'   =>  'application/mac-compactpro',
      'doc'   =>  'application/msword',
      'bin'   =>  'application/macbinary',
      'dms'   =>  'application/octet-stream',
      'lha'   =>  'application/octet-stream',
      'lzh'   =>  'application/octet-stream',
      'exe'   =>  'application/octet-stream',
      'class' =>  'application/octet-stream',
      'psd'   =>  'application/octet-stream',
      'so'    =>  'application/octet-stream',
      'sea'   =>  'application/octet-stream',
      'dll'   =>  'application/octet-stream',
      'oda'   =>  'application/oda',
      'pdf'   =>  'application/pdf',
      'ai'    =>  'application/postscript',
      'eps'   =>  'application/postscript',
      'ps'    =>  'application/postscript',
      'smi'   =>  'application/smil',
      'smil'  =>  'application/smil',
      'mif'   =>  'application/vnd.mif',
      'xls'   =>  'application/vnd.ms-excel',
      'ppt'   =>  'application/vnd.ms-powerpoint',
      'wbxml' =>  'application/vnd.wap.wbxml',
      'wmlc'  =>  'application/vnd.wap.wmlc',
      'dcr'   =>  'application/x-director',
      'dir'   =>  'application/x-director',
      'dxr'   =>  'application/x-director',
      'dvi'   =>  'application/x-dvi',
      'gtar'  =>  'application/x-gtar',
      'php'   =>  'application/x-httpd-php',
      'php4'  =>  'application/x-httpd-php',
      'php3'  =>  'application/x-httpd-php',
      'phtml' =>  'application/x-httpd-php',
      'phps'  =>  'application/x-httpd-php-source',
      'js'    =>  'application/x-javascript',
      'swf'   =>  'application/x-shockwave-flash',
      'sit'   =>  'application/x-stuffit',
      'tar'   =>  'application/x-tar',
      'tgz'   =>  'application/x-tar',
      'xhtml' =>  'application/xhtml+xml',
      'xht'   =>  'application/xhtml+xml',
      'zip'   =>  'application/zip',
      'mid'   =>  'audio/midi',
      'midi'  =>  'audio/midi',
      'mpga'  =>  'audio/mpeg',
      'mp2'   =>  'audio/mpeg',
      'mp3'   =>  'audio/mpeg',
      'aif'   =>  'audio/x-aiff',
      'aiff'  =>  'audio/x-aiff',
      'aifc'  =>  'audio/x-aiff',
      'ram'   =>  'audio/x-pn-realaudio',
      'rm'    =>  'audio/x-pn-realaudio',
      'rpm'   =>  'audio/x-pn-realaudio-plugin',
      'ra'    =>  'audio/x-realaudio',
      'rv'    =>  'video/vnd.rn-realvideo',
      'wav'   =>  'audio/x-wav',
      'bmp'   =>  'image/bmp',
      'gif'   =>  'image/gif',
      'jpeg'  =>  'image/jpeg',
      'jpg'   =>  'image/jpeg',
      'jpe'   =>  'image/jpeg',
      'png'   =>  'image/png',
      'tiff'  =>  'image/tiff',
      'tif'   =>  'image/tiff',
      'css'   =>  'text/css',
      'html'  =>  'text/html',
      'htm'   =>  'text/html',
      'shtml' =>  'text/html',
      'txt'   =>  'text/plain',
      'text'  =>  'text/plain',
      'log'   =>  'text/plain',
      'rtx'   =>  'text/richtext',
      'rtf'   =>  'text/rtf',
      'xml'   =>  'text/xml',
      'xsl'   =>  'text/xml',
      'mpeg'  =>  'video/mpeg',
      'mpg'   =>  'video/mpeg',
      'mpe'   =>  'video/mpeg',
      'qt'    =>  'video/quicktime',
      'mov'   =>  'video/quicktime',
      'avi'   =>  'video/x-msvideo',
      'movie' =>  'video/x-sgi-movie',
      'doc'   =>  'application/msword',
      'word'  =>  'application/msword',
      'xl'    =>  'application/excel',
      'eml'   =>  'message/rfc822'
    );
    return (!isset($mimes[strtolower($ext)])) ? 'application/octet-stream' : $mimes[strtolower($ext)];
  }


if($row->payment_method == "credit"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-visa.png");
}
if($row->payment_method == "card"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-stripe.png");
}
if($row->payment_method == "paypal"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-paypal.png");
}
if($row->payment_method == "klarna"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-klarna.png");
}
if($row->payment_method == "clearpay"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-clearpay.png");
}
if($row->payment_method == "googlepay"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-google.png");
}
if($row->payment_method == "applepay"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-apple.png");
}
if($row->payment_method == "cash"){
    $imagePayment = file_get_contents(DOMAIN . "/images/payment-cash.png");
}

$logoExt = explode(".",$imagePayment)[1];

$paymentLogo = "data:". mime_types($logoExt) .";base64," . base64_encode($imagePayment);

    if(isset($_POST["invoice"]) and $_POST["invoice"] == "invoice"){

        $logo = file_get_contents(DOMAIN . "/images/pdf-logo.png");
        $scanner = file_get_contents(DOMAIN . "/images/adobe_express.png");

        $facebookLogo = file_get_contents(DOMAIN . "/images/facebook-logo.png");
        $facebookLogoExt = explode(".",$facebookLogo)[1];

        $instagramLogo = file_get_contents(DOMAIN . "/images/instagram-logo.png");
        $instagramLogoExt = explode(".",$instagramLogo)[1];

        $paymentLogo = "";


        if($row->payment_method == "credit"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-visa.png");
        }
        if($row->payment_method == "card"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-stripe.png");
        }
        if($row->payment_method == "paypal"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-paypal.png");
        }
        if($row->payment_method == "klarna"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-klarna.png");
        }
        if($row->payment_method == "clearpay"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-clearpay.png");
        }
        if($row->payment_method == "googlepay"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-google.png");
        }
        if($row->payment_method == "applepay"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-apple.png");
        }
        if($row->payment_method == "cash"){
            $imagePayment = file_get_contents(DOMAIN . "/images/payment-cash.png");
        }

        $logoExt = explode(".",$imagePayment)[1];
        $scannerExt = explode(".",$scanner)[1];

        $paymentLogo = "data:". mime_types($logoExt) .";base64," . base64_encode($imagePayment);

        $options = new Options();

        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);

        $html = "



<style>
  
    body, *{
   margin-left: 0px;
    margin-right: 0px;

    }
    thead {
  display: table-header-group;
}

tfoot {
  display: table-row-group;
}

tr {
  page-break-inside: avoid;
}
    h1{
    font-weight: 400 !important;
    font-size: 40px;
    margin-bottom: 0 !important;
    margin-top: 15px;
    font-family: 'Maven Pro', sans-serif;
    }
    h4{
    margin-top: 0 !important;
    font-size: 14px;
    font-family: 'Maven Pro', sans-serif;
    }
    @page { 
    margin-left: 0px;
    margin-right: 0px;
    margin-top: 10px;
    margin-bottom: 10px;
     }
     
     .description *{
        margin-top: 2px !important;
     }
     
</style>
            <table style='width: 100%;padding: 20px;padding-top: 10px !important;padding-bottom: 12px !important;'>
                <tr>
                    <td style='text-align: center;' colspan='20'>
             
                        <img src='data:image/svg;base64,".base64_encode($logo). "' style='max-width: 250px;width: 100%;margin: auto;'>
                    </td>
                </tr>
            </table>
             <table style='width: 100%;'>
                <tr>
                    <td style='text-align: center;background: #f5e1fa;' colspan='20'>
                        <h1 style='color:#3a004a;'>Thank you for your order!</h1>
                        <p style='margin-top: 5px;color:#3a004a;font-size: 20px;margin-bottom: 12px;'>Please find your order summary below</p>
                    </td>
                </tr>
            </table>
            <table style='width: 100%;padding-left: 45px;padding-right: 45px; padding-bottom:0px; margin-bottom:0px;'>
                <tr style='margin-top:0px; padding-top: 0px;bottom-top:0px; bottom-top: 0px;'>
                    <td style='text-align: left;margin-top:0px; padding-top: 0px;bottom-top:0px; bottom-top: 0px;'>
                        <p>
                            <span style='color:#3a004a;font-weight: 600 !important;font-size: 16px'>ORDER NUMBER:</span> 
                            <span style='color:#3a004a;font-weight: 400 !important;font-size: 16px'>#". $row->order_number . "</span>
                        </p>
                        <p>
                            <span style='color:#3a004a;font-weight: 600 !important;font-size: 16px'>PAYMENT TYPE:</span>
                            <!-- <span><img src='" . $row->payment_method . "' style='max-width: 80px;margin-top:50px;'></span> -->
                            <span style='color:#3a004a;font-weight: 400 !important;font-size: 16px'>" . strtoupper($row->payment_method) . "</span>

                        </p>
                    </td>

                    <td style='text-align: right;margin-top:0px; padding-top: 0px;bottom-top:0px; bottom-top: 0px;'>
                        <p >
                            <span style='color:#3a004a;font-weight: 600 !important;font-size: 16px'>ORDER DATE:</span>
                            <span style='color:#3a004a;font-weight: 400 !important;font-size: 16px'>" . date_format(date_create($row->created_at), "d/m/Y") . "</span>
                        </p>
                        <p >
                            <span style='color:#3a004a;font-weight: 600 !important;font-size: 16px'>CONTACT:</span>
                            <span style='color:#3a004a;font-weight: 400 !important;font-size: 16px'>" . $user_row->first_name . " " . $user_row->last_name . "</span>
                        </p>
                    </td>
                </tr>
            </table>";
            
            
             if(isset($row->notes)){
                $html .= "<table style='width: 100%;padding-left: 45px;padding-right: 45px; padding-top:0px; margin-top:0px;'>
                <tr>
                    <td style='text-align: left;'>
                        <p style='color:#3a004a;font-weight: 400 !important;font-size: 12px'>Order Notes: " . $row->notes . "</p> 
                    </td>
                </tr>
            </table>";
             } 

            $html .= "
            <div style='page-break-inside: avoid'>
            <table style='width: 100%;'>
                <tr>
                    <td style='text-align: center;background: #f5e1fa;margin-top: 0px !important;' colspan='20'>
                        <h4 style='margin-top: 8px !important;color:#3a004a;font-size: 20px;margin-bottom: 8px !important;font-weight: 400 !important;''>Billing and Shipping</h4>
                    </td>
                </tr>
            </table>
            
             <table style='width: 100%;padding-left: 40px;padding-right: 40px;padding-top: 20px;padding-bottom: 20px;'>
                <tr>

                    <!--<td style='width: 30%;vertical-align: top'>
                         
                               <h4 style='margin-top:0px !important;color: #3a004a;font-weight: 600 !important;font-size: 16px;margin-bottom: 10px !important;'>PAYMENT TYPE</h4>
                               <img src='" . $paymentLogo . "' style='max-width: 100px;'>
                    </td> -->
                    <td style='width: 47.5%;vertical-align: top'>
                           <h4 style='margin-bottom:20px !important;color: #3a004a;font-weight: 600 !important;font-size: 16px;'>BILLING</h4>
                           
                          
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 500 !important;font-size: 14px;'>". $user_row->first_name . " ". $user_row->last_name ."</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 500 !important;font-size: 14px;'>". $user_row->phone ."</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->address_1 ."</h4>
                           ";
                            if($user_row->address_2 != "" and $user_row->address_2 != null){
                                $html .= "     <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->address_2 ."</h4>";
                            }
                            $html .= "
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->town ."</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->postcode ."</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->country . "</h4>
                    </td>
                    <td style='width: 5%;'></td>

                    

                    <td style='width: 47.5%;text-align: right;vertical-align: top'>
                         <h4 style='margin-bottom:20px !important;color: #3a004a;font-weight: 600 !important;font-size: 16px;'>SHIPPING</h4>
                         
                         
                            <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 500 !important;font-size: 14px;'>". $user_row->first_name . " ". $user_row->last_name ."</h4>
                                    <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 500 !important;font-size: 14px;'>". $user_row->phone ."</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->billing_address_1 ."</h4>";

                        if($user_row->billing_address_2 != "" and $user_row->billing_address_2 != null){
                            $html .= "     <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->billing_address_2 ."</h4>";
                        }

                    $html .= "
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->billing_town . "</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->billing_postcode . "</h4>
                           <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>". $user_row->billing_country . "</h4>
                    </td>
                </tr>
            </table>
            </div>
            
            <table style='width: 100%;padding-left: 45px;padding-right: 45px;margin-top: 25px;'>
                <tr>
                    <td style='color: #3a004a;font-weight:600; font-size:16px;'>DESCRIPTION</td>
                    <td style='text-align: right;color: #3a004a;margin-right: 20px;font-weight:600; font-size:16px;'>QTY</td>
                    <td style='text-align: right;color: #3a004a;width: 100px;font-weight:600; font-size:16px;'>PRICE</td>
                </tr>
                ";

foreach($query as $prod){


$image = $productImageObj->getRowByFieldNotDeleted('product_id', $prod->product_id);



$baseImage = file_get_contents(__DIR__."/../../product-images/".$image->id.'.'.$image->ext);


$html .= '
<tr>

<td style="vertical-align: top;padding-top: 10px;padding-bottom: 10px;">

<h4 style="margin-bottom: 2px !important;margin-top: 2px !important;font-size: 14px !important;color: #3a004a;font-weight: 400 !important;"><div style="margin-bottom: 2px !important;margin-top: 2px !important;" class="description">' . $prod->title .'</div></h4>';



$singleProduct = $productObj->getById($prod->product_id)[0];

if($singleProduct->service == 1 and $prod->product_id != 2 and $prod->product_id != 3){
    $html .= "<h4 style='margin-bottom: 2px !important;margin-top: 2px !important;font-size: 14px !important;color: #3a004a;font-weight: 400 !important;'><div style='margin-bottom: 2px !important;margin-top: 2px !important;' class='description'>". $singleProduct->description ."</div></h4>";

}
if(isset($prod->extra) and $prod->extra != "" and $prod->extra != null and $prod->product_id != "2" and $prod->product_id != "3"){
    foreach (explode(",",$prod->extra) as $item){
        $html .= "<h4 style='margin-bottom: 2px;margin-top: 2px;font-size: 14px !important;color: #3a004a;font-weight: 400 !important;'>". $item ."</h4>";
    }
}
$html .= '
</td>
<td  style="vertical-align: top;padding-top: 10px;padding-bottom: 1px;text-align: right">
<h4 style="color: #3a004a;font-weight: 400 !important;margin-bottom: 0px;">'.$prod->quantity. '</h4>
</td>
<td  style="vertical-align: top;padding-top: 10px;padding-bottom:10px;text-align: right">
<h4 style="color: #3a004a;font-weight: 400 !important;margin-bottom: 0px;">£'.$prod->price.'</h4>
</td>
</tr>
<tr class="border">
<td colspan="4" style="border-bottom: 2px solid #eeeeee;"></td>
</tr>

   ';


}

    $html .="</table>";

    $html .= "<div style='page-break-inside: avoid'> <table style='width: 100%;padding-left: 45px;padding-right: 45px;'>
                <tr>
                    <td style='width: 60%;'></td>
                    <td style='width: 20%;'>
                        <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 600 !important;font-size: 14px;margin-top: 12px !important;'>SUB TOTAL:</h4>
                        <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 600 !important;font-size: 14px;'>VAT (20%):</h4>
                        <h4 style='margin-bottom: 12px !important;color: #3a004a;font-weight: 600 !important;font-size: 14px;'>SHIPPING:</h4>
                        
                    </td>
                    <td style='text-align: right !important;width: 20%;'>
                        <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;margin-top: 12px !important;'>£". $row->cost . "</h4>
                        <h4 style='margin-bottom: 5px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>£". number_format($row->cost * 0.2,2) . "</h4>
                        <h4 style='margin-bottom: 12px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;'>FREE SHIPPING</h4>
                        
                    </td>
                </tr>
                <tr>
                    <td style='width: 60%;'></td>
                    <td colspan='3' style='border-bottom: 2px solid #eeeeee'></td>
                </tr>
                <tr>
                    <td style='width: 60%;'></td>
                    <td>
                     
                        <h4 style='margin-bottom: 12px !important;color: #3a004a;font-weight: 600 !important;font-size: 14px;margin-top: 12px !important;'>TOTAL PRICE:</h4>
                    </td>
                    <td style='text-align: right'>
                   
                        
                        <h4 style='margin-bottom: 12px !important;color: #3a004a;font-weight: 400 !important;font-size: 14px;margin-top: 12px !important;text-align: right !important;'>£". $row->cost ."</h4>
                    </td>
                </tr>
            </table></div>";







        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        ob_end_clean();
        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

    }

?>

<?php  if( $user->isAdmin() ){  ?>
<script>
$(function(){
	$('.print-address').click(function(){

			var data = {"first_name":"<?= strtoupper($user_row->first_name) ?>", "last_name":"<?= strtoupper($user_row->last_name) ?>", "address_1":"<?= strtoupper($user_row->address_1) ?>", "address_2":"<?= strtoupper($user_row->address_2) ?>", "town":"<?= strtoupper($user_row->town) ?>", "postcode":"<?= strtoupper($user_row->postcode) ?>", "country":"<?= strtoupper($user_row->country) ?>" };
			var popUp = window.open('', 'Print', 'width=500,height=500');
			popUp.document.write('<p style="font-size:20px;font-family:arial;margin-left:50px;margin-top:50px">'+ data.first_name.toUpperCase() +' '+ data.last_name.toUpperCase() +'<br /> '+ data.address_1.toUpperCase() +' <br /> '+ data.address_2.toUpperCase() +'  <br /> '+ data.town.toUpperCase() +'  <br /> '+ data.postcode.toUpperCase() +'  <br /> '+ data.country.toUpperCase() +' </p>');
	
			popUp.document.close();
			popUp.focus();
			popUp.print();

	})
});
</script>
<?php } ?>


					<form class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?php if(!$user->isAdmin()){ ?><a href="account?page=orders"><i class="fa fa-chevron-left"></i> BACK</a> | <?php } ?>VIEW ORDER</div>
						<div class="panel-body">
						
						<?php  if( $user->isAdmin() ){  ?>
						

								

								<div class="form-group">
									<label class="col-md-4 control-label">Status</label>
									<div class="col-md-6">
									<select class="form-control" name="status">
									<option value="New" <?php if(isset($row) && $row->status == 'New'){ print 'selected'; } ?>>New</option>
									<option value="Completed" <?php if(isset($row) && $row->status == 'Completed'){ print 'selected'; } ?>>Completed</option>
									<option value="Dispatched" <?php if(isset($row) && $row->status == 'Dispatched'){ print 'selected'; } ?>>Dispatched</option>
									<option value="Pending" <?php if(isset($row) && $row->status == 'Pending'){ print 'selected'; } ?>>Pending</option>
									<option value="Cancelled" <?php if(isset($row) && $row->status == 'Cancelled'){ print 'selected'; } ?>>Cancelled</option>
									</select>
									</div>
								</div>
								

						
						<?php } else { ?>
						
								<div class="form-group">
									<label class="col-md-4 control-label">Status</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->status; } ?>
									</div>
								</div>
						
						<?php }  ?>


								<div class="form-group">
									<label class="col-md-4 control-label">Send Dispatched Email?</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="dispatchedEmail" id="dispatchedEmail">
                                            <option value="no">Please Select</option>

                                            <option value="yes">Send Email</option>

                                        </select>
                                    </div>
								</div>

								<div class="form-group">

                                    <label class="col-md-4 control-label">Send Cancelled Email?</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="cancelledEmail" id="cancelledEmail">
                                            <option value="no">Please Select</option>

                                            <option value="yes">Send Email</option>

                                        </select>
                                    </div>
                                
								</div>
						
						
								<div class="form-group">
									<label class="col-md-4 control-label">Order Number</label>
									<div class="col-md-6 pt-7">
										<?php 
                                        
                                            if(isset($row)){ print $row->order_number; } 

                                        ?>
									</div>
								</div>

						
								<div class="form-group">
									<label class="col-md-4 control-label">Order Date</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print date('d/m/Y H:i', strtotime($row->created_at)); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Order Notes</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->notes; } ?>
									</div>
								</div>								
								
								<?php if(isset($row->status) && $row->status == 'Dispatched'){ ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Dispatched Date</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print date('d/m/Y H:i', strtotime($row->dispatched_date)); } ?>
									</div>
								</div>

								<?php } ?>


                            <?php if(isset($row->status) && $row->status == 'Cancelled'){ ?>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Cancellation Date</label>
                                    <div class="col-md-6 pt-7">
                                        <?php if(isset($row)){ print date('d/m/Y H:i', strtotime($row->cancellation_date)); } ?>
                                    </div>
                                </div>

                            <?php } ?>
								

								
								<div class="form-group">
									<label class="col-md-4 control-label">Total Cost</label>
									<div class="col-md-6 pt-7">
										£<?php
										
	$cost = $row->cost + $row->shipping;
	
	if($row->promo_code_id){
		
		$cost = Tools::showDiscountPrice($row->cost, $row->discount_amount, $row->discount_type);
		
		$cost = $cost + $row->shipping;
	
	}										
	
		print number_format($cost, 2);
										
										?>
                                        <br>
                                        <br>

                                        <img src='<?= $paymentLogo ?>' style='max-width: 100px;'>
									</div>
								</div>
								



								<?php if($user->isAdmin()){ ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary mb-10"> UPDATE STATUS <i class="fa fa-edit"></i></button>

										<button onclick="window.print()" type="button" class="btn btn-default mb-10"> PRINT PAGE <i class="fa fa-print"></i></button>

										<!-- <a href="account?page=order&id=<?= $id ?>&action=send-dispatched" class="btn btn-default mb-10">MARK DISPATCHED ANDEMAIL <i class="fa fa-envelope"></i></a>

										<a href="account?page=order&id=<?= $id ?>&action=send-cancelled" class="btn btn-default mb-10">SEND CANCELLED EMAIL <i class="fa fa-envelope"></i></a> -->

                                        <button type="button" class="btn btn-primary mb-10" onclick="$('#download-submit').click();"> DOWNLOAD INVOICE </button>
									</div>
								</div>

								
								<?php } ?>
							
						</div>
					</div>
		
		
				</form>
<?php if($user->isAdmin()){ ?>

            <form action="" method="POST" style="display: none">
                <input name="invoice" value="invoice" type="hidden">
                <button type="submit" class="btn btn-primary mb-10" id="download-submit">download</button>
            </form>



<?php } ?>

<?php

	$row = $user->find($row->user_id);

?>


						<div class="panel panel-default form-horizontal">
						<div class="panel-heading">SHIPPING INFORMATION</div>
						<div class="panel-body">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Customer Name</label>
									<div class="col-md-6 pt-7">
										<?php 

                                            $UserUniName = ucwords($row->first_name).' '.ucwords($row->last_name);

                                            if(isset($row)){ print ucwords($row->first_name).' '.ucwords($row->last_name); } 
                                        
                                        ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address</label>
									<div class="col-md-6 pt-7">
<?php if(isset($row)){ print ucwords($row->address_1); } if(isset($row->address_2) && $row->address_2 != ''){ print ', '.ucwords($row->address_2); } print ', '.ucwords($row->town).', '.strtoupper($row->postcode); if(isset($row->country)){ print ', '.strtoupper($row->country); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email</label>
									<div class="col-md-6 pt-7">
                                        <?php 

                                            if(isset($row)){ print strtolower($row->email); } 
                                        
                                        ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Phone</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->phone; } ?>
									</div>
								</div>
							
						</div>
						</div>


                    <div class="panel panel-default form-horizontal">
    <div class="panel-heading">BILLING INFORMATION</div>
    <div class="panel-body">

        <div class="form-group">
            <label class="col-md-4 control-label">Customer Name</label>
            <div class="col-md-6 pt-7">
                <?php if(isset($row)){ print ucwords($row->first_name).' '.ucwords($row->last_name); } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Address</label>
            <div class="col-md-6 pt-7">
                <?php if(isset($row)){ print ucwords($row->billing_address_1); } if(isset($row->billing_address_2) && $row->billing_address_2 != ''){ print ', '.ucwords($row->billing_address_2); } print ', '.ucwords($row->billing_town).', '.strtoupper($row->billing_postcode); if(isset($row->billing_country)){ print ', '.strtoupper($row->billing_country); } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Email</label>
            <div class="col-md-6 pt-7">
                <?php if(isset($row)){ print strtolower($row->email); } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Phone</label>
            <div class="col-md-6 pt-7">
                <?php if(isset($row)){ print $row->phone; } ?>
            </div>
        </div>

    </div>
</div>


						<div class="panel panel-default form-horizontal">
						<div class="panel-heading">ORDER DETAILS</div>
						<div class="panel-body">
						
						<?php $i = 0; foreach($query as $row){ ?>
						
							<?php if($i > 0){ print "<hr />"; } ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Product</label>
									<div class="col-md-6 pt-7">
										<?= $row->title ?>
									</div>
								</div>

                                <div class="form-group">
									<label class="col-md-4 control-label">Customer Source</label>
									<div class="col-md-6 pt-7">
										<?= $row->customerSourceOrder ?>
									</div>
								</div>
								

								
								<div class="form-group">
									<label class="col-md-4 control-label">Options</label>
									<div class="col-md-6 pt-7">
										<?php
										    if($row->extra != "" and $row->extra != null and $row->product_id != "2" and $row->product_id != "3"){
                                                foreach (explode(",",$row->extra) as $extra){ ?>
                                                    <span>- <?= $extra ?></span><br>
                                                <?php }
                                            }
										?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label">Quantity</label>
									<div class="col-md-6 pt-7">
										<?= $row->quantity ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Individual Price</label>
									<div class="col-md-6 pt-7">
										<?= $row->price ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image</label>
									<div class="col-md-6 pt-7">
										<?php
										
										$image = $productImageObj->getRowByFieldNotDeleted('product_id', $row->product_id);
										
										?>


										<img alt="" class="img-responsive thumbnail" src="<?= DOMAIN ?>/product-images/<?= $image->id ?>.<?= $image->ext ?>" style="max-width: 300px;">
										
									</div>
								</div>								

								
							<?php $i++; } ?>

                            <style>
                                @media(max-width: 500px){
                                    .img-responsive{
                                        width: 100%;
                                    }
                                }
                            </style>
						</div>
						</div>