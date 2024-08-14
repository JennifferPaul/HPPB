<?php
$property_id = $_GET['property_id'];
// Process payment with the payment gateway
// On success:
header('Location: confirmation.php?property_id=' . $property_id . '&status=success');
exit();
// On failure:
// header('Location: confirmation.php?property_id=' . $property_id . '&status=failure');
// exit();
?>
