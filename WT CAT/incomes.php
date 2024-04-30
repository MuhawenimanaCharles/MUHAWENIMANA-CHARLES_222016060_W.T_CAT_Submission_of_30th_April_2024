<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Income Form</title>
</head>
<body bgcolor="chocolate">
    <h1>Income Form</h1>
    <form method="post" action="incomes.php">

        <label for="income_id">Income ID:</label>
        <input type="number" id="income_id" name="income_id" required><br><br>

        <label for="account_id">Account ID:</label>
        <input type="number" id="account_id" name="account_id" required><br><br>

        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="income_date">Income Date:</label>
        <input type="date" id="income_date" name="income_date" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a>

    </form>

    <?php
    include('connection.php');
    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $IncomeID = $_POST['income_id'];
        $AccountID = $_POST['account_id'];
        $Amount = $_POST['amount'];
        $IncomeDate = $_POST['income_date'];

        $fp = $connection->prepare("INSERT INTO incomes (income_id, account_id, amount, income_date) VALUES (?, ?, ?, ?)");
        $fp->bind_param("iiss", $IncomeID, $AccountID, $Amount, $IncomeDate);

        if ($fp->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $fp->error;
        }

        $fp->close();
    } 
    ?>

    <h2>Income Data</h2>
    <table border="1">
        <tr>
            <th>Income ID</th>
            <th>Account ID</th>
            <th>Amount</th>
            <th>Income Date</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the incomes table
        $sql = "SELECT * FROM incomes";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["income_id"] . "</td>
                    <td>" . $row["account_id"] . "</td>
                    <td>" . $row["amount"] . "</td>
                    <td>" . $row["income_date"] . "</td> 
                    <td><a style='padding:4px' href='delete_incomes.php?income_id=" . $row["income_id"] . "'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_incomes.php?income_id=" . $row["income_id"] . "'>Update</a></td> 
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
