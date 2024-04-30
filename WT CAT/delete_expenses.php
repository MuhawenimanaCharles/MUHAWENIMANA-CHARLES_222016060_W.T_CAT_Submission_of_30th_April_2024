<?php
include('connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['expense_id'])) {
    $expense_id = $_REQUEST['expense_id'];
    
    // Prepare and execute the DELETE statement
    $fp = $connection->prepare("DELETE FROM expenses WHERE expense_id=?");
    $fp->bind_param("i", $expense_id);
    if ($fp->execute()) {
        header('Location:expenses.php');
    } else {
        echo "Error deleting data: " . $fp->error;
    }

    $fp->close();
} else {
    echo "expense_id is not set.";
}

$connection->close();
?>