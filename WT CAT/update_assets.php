<?php
// Connection details
include('connection.php');

// Check if asset id is set
if (isset($_REQUEST['asset_id'])) {
    $accid = $_REQUEST['asset_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM assets WHERE asset_id = ?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['asset_id'];
        $a = $row['account_id'];
        $c = $row['asset_name'];
        $d = $row['value'];
    } else {
        echo "Asset not found.";
    }

    // Close statement
    $stmt->close();
}
?>

<html>
<body>
    <form method="POST">
        <label for="account_id">Account id:</label>
        <input type="text" name="account_id" value="<?php echo isset($a) ? htmlspecialchars($a, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="asset_name">Asset Name:</label>
        <input type="text" name="asset_name" value="<?php echo isset($c) ? htmlspecialchars($c, ENT_QUOTES) : ''; ?>" required>
        <br><br>

        <label for="value">value:</label>
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
    $account_id = htmlspecialchars($_POST['account_id'], ENT_QUOTES);
    $asset_name = htmlspecialchars($_POST['asset_name'], ENT_QUOTES);
    $value = htmlspecialchars($_POST['value'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE assets SET account_id = ?, asset_name= ?,value = ? WHERE asset_id = ?");
    $stmt->bind_param("sssi", $account_id, $asset_name, $value, $accid);
    
    if ($stmt->execute()) {
        // Redirect to accounts.php on successful update
        header('Location: assets.php');
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