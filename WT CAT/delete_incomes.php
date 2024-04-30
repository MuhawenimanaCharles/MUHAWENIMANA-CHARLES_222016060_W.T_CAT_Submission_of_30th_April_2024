
<?php
include('connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['income_id'])) {
    $income_id = $_REQUEST['income_id'];
    
    // Prepare and execute the DELETE statement
    $fp = $connection->prepare("DELETE FROM incomes WHERE income_id=?");
    $fp->bind_param("i", $income_id);
    if ($fp->execute()) {
        header('Location:incomes.php');
    } else {
        echo "Error deleting data: " . $fp->error;
    }

    $fp->close();
} else {
    echo "income_id is not set.";
}

$connection->close();
?>

