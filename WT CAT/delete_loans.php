<?php
include('connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['loan_id'])) {
    $loan_id = $_REQUEST['loan_id'];
    
    // Prepare and execute the DELETE statement
    $fp = $connection->prepare("DELETE FROM loans WHERE loan_id=?");
    $fp->bind_param("i", $loan_id);
    if ($fp->execute()) {
        header('Location:loans.php');
    } else {
        echo "Error deleting data: " . $fp->error;
    }

    $fp->close();
} else {
    echo "loan_id is not set.";
}

$connection->close();
?>
