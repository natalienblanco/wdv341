<?php

// Initialzes all the error variables into an empty string to ensure they're defined with an initial value prior to validation
$errorEventName = $errorEventDescription = $errorEventPresenter = $errorEventDate = $errorEventTime = "";
$recId = $_GET['eventID'] ?? ''; // Get the event ID from the URL

// If the form has been submitted:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Display the user a confirmation message.
    $display = "confirmation";

    $validForm = true;

    // Get form data into PHP
    $eventName = $_POST['eventName'] ?? '';
    $eventDescription = $_POST['eventDescription'] ?? '';
    $eventPresenter = $_POST['eventPresenter'] ?? '';
    $eventDate = $_POST['eventDate'] ?? '';
    $eventTime = $_POST['eventTime'] ?? '';
    $eventDateInserted = date('Y-m-d'); // Set current date as inserted date
    $eventDateUpdated = date('Y-m-d'); // Set current date as updated date

    // Validations
    // Validate eventName - cannot be blank
    if (empty(trim($eventName))) {
        $validForm = false;
        $errorEventName = "Event Name is required.";
    }

    // Validate eventDescription - cannot be blank
    if (empty(trim($eventDescription))) {
        $validForm = false;
        $errorEventDescription = "Event Description is required.";
    }

    // Validate eventPresenter - cannot be blank
    if (empty(trim($eventPresenter))) {
        $validForm = false;
        $errorEventPresenter = "Event Presenter is required.";
    }

    // Validate eventDate - cannot be blank
    if (empty(trim($eventDate))) {
        $validForm = false;
        $errorEventDate = "Event Date is required.";
    }

    // Validate eventTime - cannot be blank
    if (empty(trim($eventTime))) {
        $validForm = false;
        $errorEventTime = "Event Time is required.";
    }

    // If the form data is valid then update the database
    if ($validForm) {
        try {
            // Update DB
            require 'dbConnect.php';

            $sql = "UPDATE wdv341_events 
                        SET events_name = :eventName, 
                            events_description = :eventDescription, 
                            events_presenter = :eventPresenter, 
                            events_date = :eventDate, 
                            events_time = :eventTime,
                            events_date_inserted = :eventDateInserted,
                            events_date_updated = :eventDateUpdated
                        WHERE events_id = :eventID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":eventName", $eventName);
            $stmt->bindParam(":eventDescription", $eventDescription);
            $stmt->bindParam(":eventPresenter", $eventPresenter);
            $stmt->bindParam(":eventDate", $eventDate);
            $stmt->bindParam(":eventTime", $eventTime);
            $stmt->bindParam(":eventDateInserted", $eventDateInserted);
            $stmt->bindParam(":eventDateUpdated", $eventDateUpdated);
            $stmt->bindParam(":eventID", $recId);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Connection failed:" . $e->getMessage();
        }
    }
} else {
    // SELECT the data from DB & show content on form
    $display = "form";

    try {
        require 'dbConnect.php';

        $sql = "SELECT events_id, events_name, events_description, events_presenter, events_date, events_time FROM wdv341_events WHERE events_id = :eventID";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":eventID", $recId);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();

        // Set the value of $eventDateInserted to the original value from the database
        $eventDateInserted = $row['events_date_inserted'] ?? '';
    } catch (PDOException $e) {
        echo "Connection failed:" . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE Event Information</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif;">
    <h1>WDV341 Intro PHP</h1>
    <h2>16-1: Create Update Form for an Event</h2>

    <hr>

    <?php

    if ($display == "form") {
        // Display form
    ?>
        <div class="updateForm">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?eventID=' . $recId; ?>">

                <p>
                    <label for="eventName">Event Name: </label>
                    <input type="text" name="eventName" id="eventName" size="40" value="<?php echo htmlspecialchars($row['events_name'] ?? ''); ?>">
                    <br><span class="errorMsg" style="color: red;"><?php echo $errorEventName; ?></span>
                </p>

                <p>
                    <label for="eventDescription">Event Description: </label>
                    <textarea name="eventDescription" id="eventDescription" cols="40" rows="5"><?php echo htmlspecialchars($row['events_description'] ?? ''); ?></textarea>
                    <br><span class="errorMsg" style="color: red;"><?php echo $errorEventDescription; ?></span>
                </p>

                <p>
                    <label for="eventPresenter">Event Presenter: </label>
                    <input type="text" name="eventPresenter" id="eventPresenter" size="40" value="<?php echo htmlspecialchars($row['events_presenter'] ?? ''); ?>">
                    <br><span class="errorMsg" style="color: red;"><?php echo $errorEventPresenter; ?></span>
                </p>

                <p>
                    <label for="eventDate">Event Date: </label>
                    <input type="date" name="eventDate" id="eventDate" value="<?php echo htmlspecialchars($row['events_date'] ?? ''); ?>">
                    <br><span class="errorMsg" style="color: red;"><?php echo $errorEventDate; ?></span>
                </p>

                <p>
                    <label for="eventTime">Event Time: </label>
                    <input type="text" name="eventTime" id="eventTime" size="40" value="<?php echo htmlspecialchars($row['events_time'] ?? ''); ?>">
                    <br><span class="errorMsg" style="color: red;"><?php echo $errorEventTime; ?></span>
                </p>

                <input type="hidden" name="eventDateUpdated" value="<?php echo date('Y-m-d'); ?>">

                <p>
                    <input type="submit" name="submit" id="submit" value="Update Event">
                    <input type="reset">
                </p>
            </form>
        </div>
    <?php
    } else {
        // Display confirmation
    ?>
        <div class="confirmationMsg">
            <h3 style="color: #03C03C;">Update successful!</h3>
        </div>
    <?php
    }
    ?>

    <a href="login.php">Return to Dashboard</a>
    <a href="selectEvents.php">Return to Events Table </a>

</body>

</html>