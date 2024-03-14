<?php

// include_once 'dbConfig.php';


// Load the database configuration file 
include_once 'dbConfig.php';

// Fetch records from database 
$query = $db->query("SELECT *, products.id AS products_id, product_images.id AS product_images_id FROM products LEFT JOIN product_images ON product_images.product_id = products.id WHERE products.deleted_at IS NULL AND product_images.deleted_at IS NULL AND products.id != '2' AND products.id != '3' ORDER BY products.id ASC" );

if ($query->num_rows > 0) {
    $delimiter = ",";
    $filename = "product-data_" . date('Y-m-d') . ".csv";

    // Create a file pointer 
    $f = fopen('php://memory', 'w');

    // Set column headers 
    $fields = array('id', 'title', 'description', 'availability', 'condition', 'price', 'link', 'image_link', 'brand');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer 
    while ($row = $query->fetch_assoc()) {
        // $status = ($row['status'] == 1) ? 'Active' : 'Inactive';

        $title = strip_tags($row['title']);
        $long_description = strip_tags($row['long_description']);
        $status = 'in stock';
        $condition = 'new';
        $url = 'https://www.comfortbedsltd.co.uk/product/'. $row['seo_url'];
        $image = 'https://www.comfortbedsltd.co.uk/product-images/'.$row['product_images_id'] . '.' . $row['ext'];
        

        if(isset($row['special_offer_price']) && $row['special_offer_price'] != ''){
            $price = $row['special_offer_price'];
        } else {
            $price = $row['price'];
        }

        $brand = 'COMFORT BEDS (YORKSHIRE) LTD';

        $lineData = array($row['id'], $title, $long_description, $status, $condition, $price, $url, $image, $brand);
        fputcsv($f, $lineData, $delimiter);
    } 

    // Move back to beginning of file 
    fseek($f, 0);

    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer 
    fpassthru($f);
}
exit;
