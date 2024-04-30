<?php
// Connection details
include('connection.php');

// Check if account_id is set
if (isset($_REQUEST['account_id'])) {
    $accid = $_REQUEST['account_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM accounts WHERE account_id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['account_id'];
        $c = $row['account_name'];
        $d = $row['balance'];
    } else {
        echo "Account not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
        <label for="account_name">Account Name:</label>
        <input type="text" name="account_name" value="<?php echo isset($c) ? htmlspecialchars($c, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="balance">Balance:</label>
        <input type="number" name="balance" value="<?php echo isset($d) ? htmlspecialchars($d, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $account_name = htmlspecialchars($_POST['account_name'], ENT_QUOTES);
    $balance = htmlspecialchars($_POST['balance'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE accounts SET account_name = ?, balance = ? WHERE account_id = ?");
    $stmt->bind_param("ssi", $account_name, $balance, $accid);
    
    if ($stmt->execute()) {
        // Redirect to accounts.php on successful update
        header('Location: accounts.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update account. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>