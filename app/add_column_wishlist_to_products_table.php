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

// SQL query to add a new column named 'new_column' to the 'your_table' table
$sql = "ALTER TABLE products ADD wishlist VARCHAR(255)";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "Wishlist column added successfully";
} else {
    echo "Wishlist column already added ";
}

// Close the connection
mysqli_close($conn);
?>