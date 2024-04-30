<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Form</title>
</head>
<body style="background-color: chocolate;">
    <h1>Transaction Form</h1>
    <form method="post" action="transactions.php">
        <label for="transaction_id">Transaction ID:</label>
        <input type="number" id="transaction_id" name="transaction_id" required><br><br>

        <label for="account_id">Account ID:</label>
        <input type="number" id="account_id" name="account_id" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="transaction_date">Transaction Date:</label>
        <input type="date" id="transaction_date" name="transaction_date" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    // Connection details
    $host = "localhost";
    $user = "222016060";
    $pass = "222016060";
    $database = "financial_position";

    // Creating connection
    $connection = new mysqli($host, $user, $pass, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $transaction_id = $_POST['transaction_id'];
        $account_id = $_POST['account_id'];
        $amount = $_POST['amount'];
        $transaction_date = $_POST['transaction_date'];

        $fp = $connection->prepare("INSERT INTO transactions (transaction_id, account_id, amount, transaction_date) VALUES (?, ?, ?, ?)");
        $fp->bind_param("iiss", $transaction_id, $account_id, $amount, $transaction_date);

        if ($fp->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $fp->error;
        }

        $fp->close();
    } 
    ?>

    <h2>transaction Data form</h2>
    <table border="1">
        <tr>
            <th>transaction ID</th>
            <th>Account ID</th>
            <th>Amount</th>
            <th>transaction Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the incomes table
        $sql = "SELECT * FROM transactions";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["transaction_id"] . "</td>
                    <td>" . $row["account_id"] . "</td>
                    <td>" . $row["amount"] . "</td>
                    <td>" . $row["transaction_date"] . "</td> 
                    <td><a style='padding:4px' href='delete_transactions.php?transaction_id=" . $row["transaction_id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_transactions.php?transaction_id=" . $row["transaction_id"] . "'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close connection
        $connection->close();
        ?>
    </table>

    <footer>
        <center> 
            <b><h2>UR CBE BIT &copy; 2024 &reg; Designed by: Muhawenimana Charles</h2></b>
        </center>
    </footer>
</body>
</html>
