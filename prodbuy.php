<?php
include("db.php");
$pagename = "A smart buy for a smart home"; // Create and populate a variable called $pagename

echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; // Call in stylesheet
echo "<title>" . $pagename . "</title>"; // Display name of the page as window title
echo "<body>";
include("headfile.html"); // Include header layout file
echo "<h4>" . $pagename . "</h4>"; // Display name of the page on the web page

// Retrieve the product id passed from the previous page using the GET method
$prodid = $_GET['u_prod_id'];

// Display the value of the product id for debugging purposes
echo "<p>Selected product Id: " . $prodid . "</p>";

// Modify the SQL query to retrieve the required product details
$SQL = "SELECT prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity FROM Product WHERE prodId = '$prodid'";

// Run SQL query for connected DB or exit and display error message
$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

// Check if product exists
if ($arrayp = mysqli_fetch_array($exeSQL)) {
    echo "<table style='border: 0px'>";
    echo "<tr>";
    echo "<td style='border: 0px'>";
    
    // Display large product image
    echo "<img src='images/" . $arrayp['prodPicNameLarge'] . "' height='400' width='400'>";
    
    echo "</td>";
    echo "<td style='border: 0px'>";
    
    // Display product details: name, long description, price, and quantity in stock
    echo "<p><h2>" . $arrayp['prodName'] . "</h2></p>"; // Product name
    echo "<p>" . $arrayp['prodDescripLong'] . "</p>"; // Long description
    echo "<p><b>Price: $" . number_format($arrayp['prodPrice'], 2) . "</b></p>"; // Product price
    echo "<p><b>Stock Available: " . $arrayp['prodQuantity'] . "</b></p><br><br>"; // Stock quantity
    echo "<p>Number to be purchased: <br>";
    //create form made of one text field and one button for user to enter quantity
    //the value entered in the form will be posted to the basket.php to be processed
    echo "<form action='basket.php' method=post>";
    echo "<select name='prodQuantity'>";
    // Loop to generate <option> tags based on stock level
    for ($i = 1; $i <= $arrayp['prodQuantity']; $i++) {
        echo "<option value='$i'>$i</option>";
    }

    echo "</select>";
    echo "<input type=submit name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
    //pass the product id to the next page basket.php as a hidden value
    echo "<input type=hidden name=h_prodid value=".$prodid.">";
    echo "</form>";
    echo "</p>";

    echo "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<p>Product not found.</p>";
}

include("footfile.html"); // Include footer layout
echo "</body>";
?>