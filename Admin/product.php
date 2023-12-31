<?php
include("../_dbConnect.php");

if (!isset($_SESSION['admin_id'])) {
    header("location: admin.php"); // Replace 'admin.php' with the actual login page URL
    exit();
}

// Initialize variables
$message = "";
$pid = "";
$randomNumber = (string)mt_rand(100, 999);

// Add product
if (isset($_POST['addProduct'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];
    $productBrand = $_POST['productBrand'];

    // Handle image upload
    $targetDirectory = "../uploadImage/"; // Directory to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["productImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the image file is a valid type (you can add more image formats if needed)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    } else {
        // Generate a unique product ID
        $proID = substr($productName, 0, 4) . $randomNumber;

        // Insert product into the database
        $insertQuery = "INSERT INTO product (proid, name, price, quan, brand, proimage) 
                        VALUES ('$proID', '$productName', '$productPrice', '$productQuantity', '$productBrand', '$targetFile')";

        if (mysqli_query($conn, $insertQuery)) {
            // Move the uploaded image to the target directory
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
                $message = "Product added successfully";
                $pid = "Product Id is $proID";
            } else {
                $message = "Error moving uploaded file.";
            }
        } else {
            $message = "Error adding product: " . mysqli_error($conn);
        }
    }
}

// Update product
if (isset($_POST['updateProduct'])) {
    $updateProductID = $_POST['updateProductID'];
    $newPrice = $_POST['newPrice'];
    $newQuantity = $_POST['newQuantity'];

    $rowCount = "SELECT * from product where proid = '$updateProductID' ";

    $query = mysqli_query($conn, $rowCount);
    $row = mysqli_num_rows($query);

    if($row == 0){
        echo "error";
    }else{
        // Perform the update query
    $updateQuery = "UPDATE product SET price = '$newPrice', quan = '$newQuantity' WHERE proid = '$updateProductID'";
    
    if (mysqli_query($conn, $updateQuery)) {
        $message = "Product updated successfully";
    } 
    }
    
}

// Delete product
if (isset($_POST['deleteProduct'])) {
    $deleteProductID = $_POST['deleteProductID'];

    $rowCount = "SELECT * from product where proid = '$deleteProductID' ";

    $query = mysqli_query($conn, $rowCount);
    $row = mysqli_num_rows($query);

    if($row == 0){
        echo "no product exist";
    }else{
        $deleteQuery = "DELETE FROM product WHERE proid = '$deleteProductID'";
    
    if (mysqli_query($conn, $deleteQuery)) {
        $message = "Product deleted successfully";
    } 
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="product.css">
</head>
<body>

<h1>Welcome to the Admin Panel</h1>

<p>
    <?php echo $message ."<br>".$pid; 

?>
</p>


<!-- Add Product Form -->
<form method="post" enctype="multipart/form-data">
    <h2>Add Product</h2>
    <label for="productName">Product Name:</label>
    <input type="text" name="productName" required><br>

    <label for="productPrice">Product Price:</label>
    <input type="number" name="productPrice" required><br>

    <label for="productQuantity">Product Quantity:</label>
    <input type="number" name="productQuantity" required><br>

    <label for="productBrand">Product Brand:</label>
    <input type="text" name="productBrand" required><br>

    <label for="productImage">Product Image:</label>
    <input type="file" name="productImage" accept="image/*" required><br>

    <button type="submit" name="addProduct">Add Product</button>
</form>

<!-- Update Product Form -->
<form method="post">
    <h2>Update Product</h2>
    <label for="updateProductID">Product ID:</label>
    <input type="text" name="updateProductID" required><br>

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
    <input type="text" name="deleteProductID" required><br>

    <button type="submit" name="deleteProduct">Delete Product</button>
</form>


<!-- Other code for updating and deleting products -->
<button><a href="logout.php">Log Out</a></button>
<?php


?>

</body>
</html>
