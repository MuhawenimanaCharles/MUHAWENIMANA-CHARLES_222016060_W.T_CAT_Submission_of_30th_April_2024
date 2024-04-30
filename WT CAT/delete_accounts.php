<?php
include('connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['account_id'])) {
    $account_id = $_REQUEST['account_id'];
    
    // Prepare and execute the DELETE statement
    $fp = $connection->prepare("DELETE FROM accounts WHERE account_id=?");
    $fp->bind_param("i", $account_id);
    if ($fp->execute()) {
        header('Location:accounts.php');
    } else {
        echo "Error deleting data: " . $fp->error;
    }

    $fp->close();
} else {
    echo "account_id is not set.";
}

$connection->close();
?>