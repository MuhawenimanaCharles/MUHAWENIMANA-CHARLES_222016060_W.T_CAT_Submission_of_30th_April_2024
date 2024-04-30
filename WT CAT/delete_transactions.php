
<?php
include('connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['transaction_id'])) {
    $transaction_id = $_REQUEST['transaction_id'];
    
    // Prepare and execute the DELETE statement
    $fp = $connection->prepare("DELETE FROM transactions WHERE transaction_id=?");
    $fp->bind_param("i", $transaction_id);
    if ($fp->execute()) {
        header('Location:transactions.php');
    } else {
        echo "Error deleting data: " . $fp->error;
    }

    $fp->close();
} else {
    echo "transaction_id is not set.";
}

$connection->close();
?>

