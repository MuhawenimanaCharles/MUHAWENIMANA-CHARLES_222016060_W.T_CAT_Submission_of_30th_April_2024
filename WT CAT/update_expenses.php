<?php
// Connection details
include('connection.php');

// Check if asset id is set
if (isset($_REQUEST['expense_id'])) {
    $accid = $_REQUEST['expense_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM expenses WHERE expense_id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['expense_id'];
        $a = $row['account_id'];
        $c = $row['amount'];
        $d = $row['expense_date'];
    } else {
        echo "expense not found.";
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

        <label for="expense_date">value:</label>
        <input type="date" name="expense_date" value="<?php echo isset($d) ? htmlspecialchars($d, ENT_QUOTES) : ''; ?>" required>
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
    $expense_date = htmlspecialchars($_POST['expense_date'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE expenses SET account_id = ?, amount= ?,expense_date = ? WHERE expense_id = ?");
    $stmt->bind_param("sssi", $account_id, $amount, $expense_date, $accid);
    
    if ($stmt->execute()) {
        // Redirect to accounts.php on successful update
        header('Location: expenses.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update asset form. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>