<?php
// Database connection
$mysqli = new mysqli("localhost", "username", "password", "database_name");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $billingReferenceNumber = $_POST['billingReferenceNumber'];
    $paymentAmount = $_POST['paymentAmount'];
    $paymentDate = date('Y-m-d');

    // Fetch billing details using billing reference number
    $billingQuery = "SELECT BillingID, TotalAmountWithPenalty, AccountNumber FROM Billing WHERE ReferenceNumber = ?";
    $stmt = $mysqli->prepare($billingQuery);
    $stmt->bind_param("s", $billingReferenceNumber);
    $stmt->execute();
    $billingResult = $stmt->get_result();

    if ($billingResult->num_rows > 0) {
        $billingRow = $billingResult->fetch_assoc();
        $billingID = $billingRow['BillingID'];
        $totalAmountWithPenalty = $billingRow['TotalAmountWithPenalty'];
        $accountNumber = $billingRow['AccountNumber'];

        // Check if the payment amount is sufficient
        if ($paymentAmount >= $totalAmountWithPenalty) {
            // Calculate Penalty Paid
            $penaltyPaid = ($paymentAmount > $totalAmountWithPenalty) ? ($paymentAmount - $totalAmountWithPenalty) : 0.00;

            // Insert payment into the Payments table
            $paymentReferenceNumber = 'PAY-' . time(); // Simple way to generate a unique reference number
            $paymentQuery = "INSERT INTO Payments (BillingID, BillingReferenceNumber, PaymentAmount, PenaltyPaid, PaymentDate, PaymentReferenceNumber) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($paymentQuery);
            $stmt->bind_param("isdsss", $billingID, $billingReferenceNumber, $paymentAmount, $penaltyPaid, $paymentDate, $paymentReferenceNumber);

            if ($stmt->execute()) {
                // Update billing status to 'Paid'
                $updateBillingQuery = "UPDATE Billing SET Status = 'Paid' WHERE BillingID = ?";
                $stmt = $mysqli->prepare($updateBillingQuery);
                $stmt->bind_param("i", $billingID);
                $stmt->execute();

                echo "Payment recorded successfully!";
            } else {
                echo "Error recording payment: " . $stmt->error;
            }
        } else {
            echo "Payment amount is insufficient to cover the total amount with penalty.";
        }
    } else {
        echo "Billing reference number not found.";
    }

    $stmt->close();
}

$mysqli->close();
?>
