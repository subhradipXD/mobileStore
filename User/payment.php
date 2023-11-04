<?php
include("../_dbConnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["payment_method"])) {
    $payment_method = $_POST["payment_method"];
    
    // Retrieve the total cart price from the hidden input
    // $total_price = isset($_POST["total_price"]) ? floatval($_POST["total_price"]) : 0;

    // Initialize user_id (You may retrieve it from the session as in your original code)
    $user_id = $_SESSION['user_id'];

    if ($payment_method === "credit_card") {
        // Process credit card payment
        // Add your credit card payment processing code here

        // Check if payment is successful
        $credit_card_payment_successful = true; // Replace with your actual payment check

        if ($credit_card_payment_successful) {
            echo "Credit Card payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "Cart items have been cleared.";
            } else {
                echo "Error clearing cart items.";
            }
        } else {
            echo "Credit Card payment failed. Cart items were not cleared.";
        }
    } elseif ($payment_method === "paypal") {
        // Process PayPal payment
        // Add your PayPal payment processing code here

        // Check if payment is successful
        $paypal_payment_successful = true; // Replace with your actual payment check

        if ($paypal_payment_successful) {
            echo "PayPal payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "Cart items have been cleared.";
            } else {
                echo "Error clearing cart items.";
            }
        } else {
            echo "PayPal payment failed. Cart items were not cleared.";
        }
    } elseif ($payment_method === "bank_transfer") {
        // Process bank transfer payment
        // Add your bank transfer payment processing code here

        // Check if payment is successful
        $bank_transfer_payment_successful = true; // Replace with your actual payment check

        if ($bank_transfer_payment_successful) {
            echo "Bank Transfer payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "Cart items have been cleared.";
            } else {
                echo "Error clearing cart items.";
            }
        } else {
            echo "Bank Transfer payment failed. Cart items were not cleared.";
        }
    } elseif ($payment_method === "cash_on_delivery") {
        // Process bank transfer payment
        // Add your bank transfer payment processing code here

        // Check if payment is successful
        $cash_on_delivery_payment_successful = true; // Replace with your actual payment check

        if ($cash_on_delivery_payment_successful) {
            echo "cash on delivery payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "Cart items have been cleared.";
            } else {
                echo "Error clearing cart items.";
            }
        } else {
            echo "cash on delivery payment failed. Cart items were not cleared.";
        }
    }elseif ($payment_method === "google_pay") {
        // Process bank transfer payment
        // Add your bank transfer payment processing code here

        // Check if payment is successful
        $google_pay_payment_successful = true; // Replace with your actual payment check

        if ($google_pay_payment_successful) {
            echo "google pay payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "Cart items have been cleared.";
            } else {
                echo "Error clearing cart items.";
            }
        } else {
            echo "google pay payment failed. Cart items were not cleared.";
        }
    }elseif ($payment_method === "apple_pay") {
        // Process bank transfer payment
        // Add your bank transfer payment processing code here

        // Check if payment is successful
        $apple_pay_payment_successful = true; // Replace with your actual payment check

        if ($apple_pay_payment_successful) {
            echo "apple pay payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "Cart items have been cleared.";
            } else {
                echo "Error clearing cart items.";
            }
        } else {
            echo "apple pay payment failed. Cart items were not cleared.";
        }
    }else {
        echo "Invalid payment method selected.";
    }
    
    // Redirect to the home page after a brief delay (e.g., 2 seconds)
    header("refresh:2;url=home.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="payment.css"> <!-- Make sure your CSS file is correctly linked -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="../WSPage/contact.php">Contact</a></li>
                <li><a href="../WSPage/about.php">About Us</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="cartitems.php">Cart</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="payment-options">
        <h3>Select Payment Method:</h3>
        <form action="" method="post">
            <label for="credit_card">Credit Card</label>
            <input type="radio" id="credit_card" name="payment_method" value="credit_card">

            <label for="paypal">PayPal</label>
            <input type="radio" id="paypal" name="payment_method" value="paypal">

            <label for="bank_transfer">Bank Transfer</label>
            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer">

            <label for="cash_on_delivery">Cash on Delivery</label>
            <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery">

            <label for="google_pay">Google Pay</label>
            <input type="radio" id="google_pay" name="payment_method" value="google_pay">

            <label for="apple_pay">Apple Pay</label>
            <input type="radio" id="apple_pay" name="payment_method" value="apple_pay">
            
            <button type="submit">Proceed to Payment</button>
        </form>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
    </footer>
</body>
</html>
