<?php
include ("db.php"); // Include db.php file to connect to DB
$pagename="Make your home smart"; // Create and populate variable called $pagename

// Set page metadata and include header
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>".$pagename."</title>";
echo "<body>";
include ("headfile.html");
echo "<h4>".$pagename."</h4>";

// Create a $SQL variable to retrieve product details, including description and price
$SQL="SELECT prodId, prodName, prodPicNameSmall, prodDescripShort, prodPrice FROM Product";

// Run SQL query for connected DB or exit and display error message
$exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error($conn));

echo "<table style='border: 0px'>";

// Iterate through the array of records retrieved by the query
while ($arrayp=mysqli_fetch_array($exeSQL))
{
    echo "<tr>";
    echo "<td style='border: 0px'>";
    
    // Display clickable product image
    echo "<a href='prodbuy.php?u_prod_id=".$arrayp['prodId']."'>";
    echo "<img src='images/".$arrayp['prodPicNameSmall']."' height='200' width='200'>";
    echo "</a>";

    echo "</td>";
    echo "<td style='border: 0px'>";
    
    // Display product details: name, short description, and price
    echo "<p><h5>".$arrayp['prodName']."</h5>"; // Product name
    echo "<p>".$arrayp['prodDescripShort']."</p>"; // Short description
    echo "<p><b>Price: $".number_format($arrayp['prodPrice'], 2)."</b></p>"; // Product price

    echo "</td>";
    echo "</tr>";
}

echo "</table>";

include ("footfile.html");
echo "</body>";
?>
