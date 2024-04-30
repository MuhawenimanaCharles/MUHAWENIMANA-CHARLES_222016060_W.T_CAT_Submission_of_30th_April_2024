<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Account Form</title>
</head>
<body bgcolor="chocolate">
    <h1>Accounts Form</h1>
    <form method="post" action="accounts.php">

        <label for="account_id">Account ID:</label>
        <input type="number" id="account_id" name="account_id" required><br><br>

        <label for="account_name">Account Name:</label>
        <input type="text" id="account_name" name="account_name" required><br><br>

        <label for="balance">Balance:</label>
        <input type="text" id="balance" name="balance" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>
    </form>

    <a href="./home.html">Go Back to Home</a>

    <?php
    include('connection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $account_id = $_POST['account_id'];
        $account_name = $_POST['account_name'];
        $balance = $_POST['balance'];

        $fp = $connection->prepare("INSERT INTO accounts (account_id, account_name, balance) VALUES (?, ?, ?)");
        $fp->bind_param("iss", $account_id, $account_name, $balance);

        if ($fp->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $fp->error;
        }

        $fp->close();
    } 
    ?>

    <h2>Data for Accounts Form</h2>
    <table border="1">
        <tr>
            <th>Account ID</th>
            <th>Account Name</th>
            <th>Balance</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the accounts table
        $sql = "SELECT * FROM accounts";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["account_id"] . "</td>
                    <td>" . $row["account_name"] . "</td>
                    <td>" . $row["balance"] . "</td>
                    <td><a style='padding:4px' href='delete_accounts.php?account_id=" . $row["account_id"] . "'>Delete</a></td>
                    <td><a style='padding:4px' href='update_account.php?account_id=" . $row["account_id"] . "'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }
        // Close connection
        $connection->close();
        ?>
    </table>

    <footer>
        <h2>UR CBE BIT &copy; 2024 &reg; Designed by: Muhawenimana Charles</h2>
    </footer>
</body>
</html>
