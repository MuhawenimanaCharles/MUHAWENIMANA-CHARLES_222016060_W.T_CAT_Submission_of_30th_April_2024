<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loans Form</title>
</head>
<body style="background-color: chocolate;">
    <h1>Loans Form</h1>
    <form method="post" action="loans.php">
        <label for="loan_id">Loan ID:</label>
        <input type="number" id="loan_id" name="loan_id" required><br><br>

        <label for="account_id">Account ID:</label>
        <input type="number" id="account_id" name="account_id" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="interest_rate">Interest Rate:</label>
        <input type="number" id="interest_rate" name="interest_rate" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    // Connection details
    include('connection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $loan_id = $_POST['loan_id'];
        $account_id = $_POST['account_id'];
        $amount = $_POST['amount'];
        $interest_rate = $_POST['interest_rate'];

        $stmt = $connection->prepare("INSERT INTO loans (loan_id, account_id, amount, interest_rate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $loan_id, $account_id, $amount, $interest_rate);

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    } 
    ?>

    <h2>Loan Data Form</h2>
    <table border="1">
        <tr>
            <th>Loan ID</th>
            <th>Account ID</th>
            <th>Amount</th>
            <th>Interest Rate</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the loans table
        $sql = "SELECT * FROM loans";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["loan_id"] . "</td>
                    <td>" . $row["account_id"] . "</td>
                    <td>" . $row["amount"] . "</td>
                    <td>" . $row["interest_rate"] . "</td> 
                    <td><a style='padding:4px' href='delete_loans.php?loan_id=" . $row["loan_id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_loans.php?loan_id=" . $row["loan_id"] . "'>Update</a></td> 
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
