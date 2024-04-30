<?php
// Connection details
include('connection.php');

// Check if asset id is set
if (isset($_REQUEST['transaction_id'])) {
    $accid = $_REQUEST['transaction_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM transactions WHERE transaction_id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['transaction_id'];
        $a = $row['account_id'];
        $c = $row['amount'];
        $d = $row['transaction_date'];
    } else {
        echo "transaction not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
         <label for="account_id">Account id:</label>
        <input type="number" name="account_id" value="<?php echo isset($a) ? htmlspecialchars($a, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="amount"> amount:</label>
        <input type="number" name="amount" value="<?php echo isset($c) ? htmlspecialchars($c, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="transaction_date">transaction date:</label>
        <input type="date" name="transaction_date" value="<?php echo isset($d) ? htmlspecialchars($d, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $account_id = htmlspecialchars($_POST['account_id'], ENT_QUOTES);
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES);
    $transaction_date = htmlspecialchars($_POST['transaction_date'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE transactions SET account_id = ?, amount= ?,transaction_date = ? WHERE transaction_id = ?");
    $stmt->bind_param("sssi", $account_id, $amount, $transaction_date, $accid);
    
    if ($stmt->execute()) {
        // Redirect to accounts.php on successful update
        header('Location:transactions.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update transactins form. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>