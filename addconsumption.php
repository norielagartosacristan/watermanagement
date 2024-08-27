<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grswatermanagement";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountNumber = $_POST['AccountNumber'];
    $currentReading = $_POST['CurrentReading'];

    // Fetch the customer ID based on the account number
    $consumersQuery = "SELECT ConsumersID FROM Consumers WHERE AccountNumber = '$accountNumber' LIMIT 1";
    $consumersResult = $conn->query($consumersQuery);

    if ($consumersResult->num_rows > 0) {
        $consumersRow = $consumersResult->fetch_assoc();
        $consumersID = $consumersRow['ConsumersID'];
    } else {
        echo "Account number not found.";
        exit;
    }

    // Fetch the previous reading from the last consumption entry
    $prevReadingQuery = "SELECT CurrentReading FROM WaterConsumption WHERE AccountNumber = '$accountNumber' ORDER BY ReadingDate DESC LIMIT 1";
    $prevReadingResult = $conn->query($prevReadingQuery);

    if ($prevReadingResult->num_rows > 0) {
        $row = $prevReadingResult->fetch_assoc();
        $previousReading = $row['CurrentReading'];
    } else {
        // If no previous reading, set it to 0 or handle accordingly
        $previousReading = 0;
    }

    // Calculate consumption amount
    $consumptionAmount = $currentReading - $previousReading;

    // Insert the new consumption record
    $readingDate = date('Y-m-d'); // Use the current date as ReadingDate
    $insertConsumptionQuery = "INSERT INTO WaterConsumption (AccountNumber, ConsumersID, CurrentReading, PreviousReading, ReadingDate)
                               VALUES ('$accountNumber', '$consumersID', '$currentReading', '$previousReading', '$readingDate')";

    if ($conn->query($insertConsumptionQuery) === TRUE) {
        // Get the last inserted ConsumptionID
        $consumptionID = $conn->insert_id;

        // Calculate total amount and penalty
        $pricingQuery = "SELECT PricePerCubicMeter, PenaltyRatePercentage FROM Pricing LIMIT 1";
        $pricingResult = $conn->query($pricingQuery);
        $pricingRow = $pricingResult->fetch_assoc();

        $totalAmount = $consumptionAmount * $pricingRow['PricePerCubicMeter'];
        $penaltyAmount = 0; // No penalty when billing is generated

        // Set billing status to unpaid
        $status = "Unpaid";

        // Generate billing reference number with month in the format
        $referenceNumber = "BILL-" . date('Ym') . "-" . strtoupper(uniqid());

        // Calculate the due date (e.g., 30 days from the billing date)
        $billingDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime($billingDate . ' +30 days'));

        // Insert the new billing record
        $insertBillingQuery = "INSERT INTO Billing (AccountNumber, ConsumptionID, BillingDate, DueDate, TotalAmount, PenaltyAmount, Status, ReferenceNumber)
                               VALUES ('$accountNumber', '$consumptionID', '$billingDate', '$dueDate', '$totalAmount', '$penaltyAmount', '$status', '$referenceNumber')";

        if ($conn->query($insertBillingQuery) === TRUE) {
            echo "Billing generated successfully.";
        } else {
            echo "Error: " . $insertBillingQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $insertConsumptionQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>

