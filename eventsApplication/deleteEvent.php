<?php
// Get the eventID for the selected event
require 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['eventID'])) {
    try {
        $eventID = $_GET['eventID'];

        // Perform the deletion
        $sql = "DELETE FROM wdv341_events WHERE events_id = :eventID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();

        $message = "Event with ID $eventID has been deleted successfully.";
    } catch (PDOException $e) {
        $message = "There was an error deleting the event.";
        error_log($e->getMessage());
    }
} else {
    $message = "Invalid request.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Delete Event</title>
</head>

<body>
    <h1>Delete Event</h1>
    <p><?php echo $message; ?></p>
    <p><a href="selectEvents.php">Return to Event List</a></p>
    <p><a href="login.php">Return to Dashboard</a></p>
</body>

</html>