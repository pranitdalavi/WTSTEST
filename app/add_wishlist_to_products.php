<?php 
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "comfortbedsdatabase";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$seoUrl = $_POST['seo_url'];
$value = $_POST['value'];

// SQL query to update values in a specific column
$sql = "UPDATE products SET wishlist = '$value' WHERE seo_url='$seoUrl'";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "Wishlist updated successfully";
} else {
    echo "Error updating wishlist: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>