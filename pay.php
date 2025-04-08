<?php
session_start();
include("admin/dbconnection.php");

if (isset($_SESSION['total_payable']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $amount = $_SESSION['total_payable'];
} else {
    echo "<p>No payment data found. <a href='index.php'>Go back</a></p>";
    exit();
}
?>

<h2>Pay Now: ₹<?= number_format($amount, 2) ?></h2>

<form>
    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>" />
    <input type="hidden" name="amount" id="amount" value="<?= $amount ?>" />
    <input type="button" id="rzp-button1" style="display: none;" value="Pay Now" onclick="pay_now()" />
</form>

<!-- jQuery & Razorpay JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
function pay_now() {
    var user_id = $('#user_id').val();
    var amount = $('#amount').val();

    $.ajax({
        type: 'POST',
        url: 'payment_process.php',
        data: {
            user_id: user_id,
            amount: amount
        },
        success: function(response) {
            var options = {
                "key": "rzp_test_oUZ1MJGSbmLQUO", // Replace with your live key in production
                "amount": amount * 100, // Amount in paisa
                "currency": "INR",
                "name": "ISCON",
                "description": "Test Transaction",
                "image": "assets/img/logo.jpg",
                "handler": function(paymentResponse) {
                    $.ajax({
                        type: 'POST',
                        url: 'payment_process.php',
                        data: {
                            payment_id: paymentResponse.razorpay_payment_id
                        },
                        success: function(confirmResult) {
                            window.location.href = "index.php";
                        }
                    });
                },
                "modal": {
                    "ondismiss": function() {
                        alert("Payment was cancelled.");
                        window.location.href = "index.php";
                    }
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }
    });
}

// Automatically trigger Razorpay button
window.onload = function() {
    document.getElementById('rzp-button1').click();
};
</script>
