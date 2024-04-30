<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>assets form<title>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>	farm</title>
</head>
<body bgcolor="chocolate">
		<h1>assets Form</h1>
<form method="post" action="assets.php">

<label for="asset_id">asset id:</label>
<input type="number" id="	asset_id" name="asset_id" required><br><br>

<label for="account_id">accounts_id:</label>
<input type="number" id="account_id" name="account_id" required><br><br>

<label for="asset_name">assets name:</label>
<input type="text" id="asset_name" name="assets_name" required><br><br>

<label for="value">value:</label>
<input type="number" id="value" name="value" required><br><br>

<input type="submit" name="add" value="Insert"><br><br>

<a href="./home.html">Go Back to Home</a>

</form>
<?php
 include('connection.php');

    // Check if the form is submitted for insert
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Insert section
        $fp = $connection->prepare("INSERT INTO assets (asset_id, account_id, asset_name,value) VALUES (?, ?, ?,?)");
        $fp->bind_param("ssss",  $asset_id, $account_id, $asset_name, $value);

        // Set parameters from POST and execute
        $asset_id = $_POST['asset_id'];
        $account_id = $_POST['account_id'];
        $asset_name = $_POST['assets_name'];
        $value = $_POST['value'];

        if ($fp->execute()) {
            echo "New record has been added successfully.<br><br>
                 <a href='home.html'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $fp->error;
        }

        $fp->close();
    } 
    ?>

    <h2>Data for asset Form</h2>
    <table border="1">
        <tr>
            <th>Asset ID</th>
            <th>Account ID</th>
            <th>Asset Name</th>
            <th>value</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>

        <?php
        // SQL query to fetch data from the accounts table
        $sql = "SELECT * FROM assets";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["asset_id"] . "</td>
                    <td>" . $row["account_id"] . "</td>
                    <td>" . $row["asset_name"] . "</td>
                    <td>" . $row["value"] . "</td>
                    <td><a style='padding:4px' href='delete_assets.php?asset_id=" . $row["asset_id"] . "'>Delete</a></td>
                    <td><a style='padding:4px' href='update_assets.php?asset_id=" . $row["asset_id"] . "'>Update</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }
        // Close connection
        $connection->close();
        ?>
    </table></center><hr>

    <footer>
       <center> <b><h2>UR CBE BIT &copy; 2024 &reg; Designed by: Muhawenimana Charles</h2></b></center>
    </footer>
</body>
</html>
</body>
</html></title>
</head>
</body>