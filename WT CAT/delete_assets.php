<?php
include('connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['asset_id'])) {
    $asset_id = $_REQUEST['asset_id'];
    
    // Prepare and execute the DELETE statement
    $fp = $connection->prepare("DELETE FROM assets WHERE asset_id=?");
    $fp->bind_param("i", $asset_id);
    if ($fp->execute()) {
        header('Location:assets.php');
    } else {
        echo "Error deleting data: " . $fp->error;
    }

    $fp->close();
} else {
    echo "asset_id is not set.";
}

$connection->close();
?>