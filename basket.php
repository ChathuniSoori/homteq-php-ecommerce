<?php
include("db.php");
session_start(); // Start the session to use $_SESSION

$pagename = "Smart Basket"; // Create and populate a variable called $pagename

echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>"; // Call in stylesheet
echo "<title>".$pagename."</title>"; // Display name of the page as window title
echo "<body>";

include("headfile.html"); // Include header layout file

echo "<h4>".$pagename."</h4>"; // Display name of the page on the web page

// Ensure the form is submitted before accessing POST data
if (isset($_POST['h_prodid']) && isset($_POST['prodQuantity'])) {
    $newprodid = $_POST['h_prodid'];
    $reququantity = $_POST['prodQuantity'];

    // Validate quantity (ensure it's a positive integer)
    if (!is_numeric($reququantity) || $reququantity <= 0) {
        echo "<p>Invalid quantity. Please enter a valid number.</p>";
    } else {
        // If the product is already in the basket, update the quantity
        if (isset($_SESSION['basket'][$newprodid])) {
            $_SESSION['basket'][$newprodid] += $reququantity;
            echo "<p>Item quantity updated in basket.</p>";
        } else {
            // Add a new product to the basket
            $_SESSION['basket'][$newprodid] = $reququantity;
            echo "<p>1 item added to the basket.</p>";
        }
    }
} else {
    echo "<p>Basket unchanged.</p>";
}

// Initialize total
$total = 0;

// Display table header
echo "<table border='1'bgcolor='lightgrey'>";
echo "<tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Remove Product</th>
      </tr>";

// Check if the basket is set and not empty
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {

    //loop through the basket session array for each data item inside the session using a foreach loop
    foreach ($_SESSION['basket'] as $index => $value) {
        // Retrieve product details from database
        $sql = "SELECT prodName, prodPrice FROM Product WHERE prodId=$index";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $arrayp = mysqli_fetch_assoc($result);
            $prodName = $arrayp['prodName'];
            $prodPrice = $arrayp['prodPrice'];

            // Calculate subtotal
            $subtotal = $prodPrice * $value;
            $total += $subtotal;

            // Display product details in table row
            echo "<tr>
                    <td>$prodName</td>
                    <td>$. $prodPrice</td>
                    <td>$value</td>
                    <td>$. $subtotal</td>
                    <td><button>Remove</button></td>
                  </tr>";
        }
    }

    // Display total
    echo "<tr>
            <td colspan='3'><strong>Total</strong></td>
            <td><strong>$.$total</strong></td>
          </tr>";
} else {
    echo "<tr><td colspan='4'>Your basket is empty.</td></tr>";
}

echo "</table>";
echo"<br><a href='clearbasket.php'>CLEAR BASKET</a>";

echo"<br><br><p>New homteq customers:<a href='signup.php'>Sign Up</a></p>";
echo"<p>Returruning homteq customers:<a href='login.php'>Log In</a></p>";

include("footfile.html"); // Include footer layout
echo "</body>";
?>
