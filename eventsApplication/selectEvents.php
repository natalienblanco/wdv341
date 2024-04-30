<?php

try {
    require 'dbConnect.php';

    $sql = "SELECT events_id, events_name, events_description, events_presenter, DATE_FORMAT(events_date, '%m-%d-%Y') as events_date, TIME_FORMAT(events_time, '%h:%i %p') as events_time, DATE_FORMAT(events_date_inserted, '%m-%d-%Y') as events_date_inserted, DATE_FORMAT(events_date_updated, '%m-%d-%Y') as events_date_updated FROM wdv341_events";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    $message = "There has been a problem. The system administrator has been contacted. Please try again later.";

    error_log($e->getMessage());
    error_log($e->getLine());
    error_log(print_r(debug_backtrace(), true));

    //header('Location: files/505_error_response_page.php');	//sends control to a User friendly page
    echo "<h1>$message</h1>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>WDV341 SELECT Events</title>
    <style>
        .eventBlock {
            border: 1px solid #dddddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .bg-light {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <h2>Events</h2>
    <a href="login.php">
        Return to Dashboard
    </a>
    <br>
    <br>

    <?php
    $count = 0;
    while ($row = $stmt->fetch()) {
        // add 'bg-light' to every other eventBlock
        $class = ($count % 2 == 0) ? 'bg-light' : '';
    ?>
        <div class="eventBlock <?php echo $class; ?>">
            <p>Event Name: <?php echo $row["events_name"]; ?></p>
            <p>Event Description: <?php echo $row["events_description"]; ?></p>
            <p>Event Presenter: <?php echo $row["events_presenter"]; ?></p>
            <p>Event Date: <?php echo $row["events_date"]; ?></p>
            <p>Event Time: <?php echo $row["events_time"]; ?></p>
            <p>Events Date Inserted: <?php echo $row["events_date_inserted"]; ?></p>
            <p>Events Date Updated: <?php echo $row["events_date_updated"]; ?></p>

            <a href="updateEvents.php?eventID=<?php echo $row['events_id']; ?>"><button>Edit Event</button></a>

            <a href="deleteEvent.php?eventID=<?php echo $row['events_id'] ?>"><button type="submit">Delete Event</button></a>

        </div>
    <?php
        $count++;
    }
    ?>

    <?php
    // Update & delete button operations
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['eventId']) && isset($_POST['action'])) {
            $eventId = $_POST['eventId'];
            $action = $_POST['action'];

            // Handle update operation
            if ($action === 'update') {
                // 'update' button logic

                //header("Location: update_event.php?eventId=$eventId");
                exit();
            }

            // Handle delete operation
            if ($action === 'delete') {
                // Deletion logic
            }
        }
    }
    ?>
    <a href="login.php">
        Return to Dashboard
    </a>
</body>

</html>