<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Form</title>
</head>
<body style="background-color: chocolate;">
    <h1>Expenses Form</h1>
    <form method="post" action="expenses.php">

        <label for="expense_id">Expense ID:</label>
        <input type="number" id="expense_id" name="expense_id"><br><br>

        <label for="account_id">Account ID:</label>
        <input type="number" id="account_id" name="account_id" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="expense_date">Expense Date:</label>
        <input type="date" id="expense_date" name="expense_date" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>

    </form>

    <?php
    include('connection.php');
    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $ExpenseID = $_POST['expense_id'];
        $AccountID = $_POST['account_id'];
        $ExpenseDate = $_POST['expense_date'];
        $Amount = $_POST['amount'];

        $fp = $connection->prepare("INSERT INTO expenses (expense_id, account_id, expense_date, amount) VALUES (?, ?, ?, ?)");
        $fp->bind_param("iiss", $ExpenseID, $AccountID, $ExpenseDate, $Amount);

        if ($fp->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $fp->error;
        }

        $fp->close();
    } 
    ?>

    <h2>Expenses Data</h2>
    <table border="1">
        <tr>
            <th>Expense ID</th>
            <th>Account ID</th>
            <th>Expense Date</th>
            <th>Amount</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the expenses table
        $sql = "SELECT * FROM expenses";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["expense_id"] . "</td>
                    <td>" . $row["account_id"] . "</td>
                    <td>" . $row["expense_date"] . "</td> 
                    <td>" . $row["amount"] . "</td>
                    <td><a style='padding:4px' href='delete_expenses.php?expense_id=" . $row["expense_id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_expenses.php?expense_id=" . $row["expense_id"] . "'>Update</a></td> 
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
