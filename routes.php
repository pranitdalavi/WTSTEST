<?php

require __DIR__.'/includes/config.php';

if( strstr($url, 'blog/') ){

	include('blog-page.php');
	exit;

} elseif(strstr($url, "divan-beds/" )){
	include('product-details-page.php');
	exit;

}
elseif(strstr($url, 'ottoman-beds/')){

    include('product-details-page.php');
    exit;

}
elseif(strstr($url, 'bed-frames/')){
    include('product-details-page.php');
    exit;

}
elseif(strstr($url, 'headboards/')){

    include('product-details-page.php');
    exit;

}
elseif(strstr($url, 'mattresses/')){

    include('product-details-page.php');
    exit;

}
elseif(strstr($url, 'product/')){

    include('product-details-page.php');
    exit;

}
// elseif(strstr($url, 'product/')){

//     include('product-details-page.php');
//     exit;

// }
$COUNTURL = 0;

foreach( $categoryObj->getAll() as $category ){
    if (strpos($slug, $category->seo_url) !== false) {

        $COUNTURL ++;
        $row = $categoryObj->getRowByField('seo_url', $slug);


        $category_id = $category->id;
        $category_title = $category->title;
        include('product-list.php');
    }

}
if($COUNTURL > 0){

}
else{


		include('404.php');


	exit;

}
?>

