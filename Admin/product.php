<?php
include("../_dbConnect.php");

// Initialize variables
$message = "";
$randomNumber = (string)mt_rand(100, 999);
// Add product
if (isset($_POST['addProduct'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];
    $productBrand = $_POST['productBrand'];

    $proID = substr($productName, 0, 4) . $randomNumber;

    // Insert product into the database
    $insertQuery = "INSERT INTO product (proId, name, price, quan, brand) 
                    VALUES ('$proID', '$productName', '$productPrice', '$productQuantity', '$productBrand')";

    if (mysqli_query($conn, $insertQuery)) {
        $message = "Product added successfully";
    } else {
        $message = "Error adding product: " . mysqli_error($conn);
    }
}

// Update product
if (isset($_POST['updateProduct'])) {
    $productID = $_POST['updateProductID'];
    $newPrice = $_POST['newPrice'];
    $newQuantity = $_POST['newQuantity'];

    // Update product price and quantity in the database
    $updateQuery = "UPDATE product SET price = '$newPrice', quan = '$newQuantity' WHERE proid = '$productID'";

    if (mysqli_query($conn, $updateQuery)) {
        $message = "Product updated successfully";
    } else {
        $message = "Error updating product: " . mysqli_error($conn);
    }
}

// Delete product
if (isset($_POST['deleteProduct'])) {
    $productID = $_POST['deleteProductID'];

    // Delete product from the database
    $deleteQuery = "DELETE FROM product WHERE proid = '$productID'";

    if (mysqli_query($conn, $deleteQuery)) {
        $message = "Product deleted successfully";
    } else {
        $message = "Error deleting product: " . mysqli_error($conn);
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Add your CSS styles here -->
</head>
<body>

<h1>Welcome to the Admin Panel</h1>

<!-- Add Product Form -->
<form method="post">
    <h2>Add Product</h2>
    <label for="productName">Product Name:</label>
    <input type="text" name="productName" required><br>

    <label for="productPrice">Product Price:</label>
    <input type="number" name="productPrice" required><br>

    <label for="productQuantity">Product Quantity:</label>
    <input type="number" name="productQuantity" required><br>

    <label for="productBrand">Product Brand:</label>
    <input type="text" name="productBrand" required><br>

    <button type="submit" name="addProduct">Add Product</button>
</form>

<!-- Update Product Form -->
<form method="post">
    <h2>Update Product</h2>
    <label for="updateProductID">Product ID:</label>
    <input type="number" name="updateProductID" required><br>

    <label for="newPrice">New Price:</label>
    <input type="number" name="newPrice" required><br>

    <label for="newQuantity">New Quantity:</label>
    <input type="number" name="newQuantity" required><br>

    <button type="submit" name="updateProduct">Update Product</button>
</form>

<!-- Delete Product Form -->
<form method="post">
    <h2>Delete Product</h2>
    <label for="deleteProductID">Product ID:</label>
    <input type="number" name="deleteProductID" required><br>

    <button type="submit" name="deleteProduct">Delete Product</button>
</form>

<p><?php echo $message; ?></p>

</body>
</html>
