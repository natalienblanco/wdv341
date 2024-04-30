<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validation function

function requiredField($inValue)
{
    if (empty($inValue)) {
        global $validForm; // Use the global version of the variable
        // Fields are empty
        $validForm = false;
    }
}

// 4695033



// Example of "switches"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //form was submitted!
    $validForm = true;
    // get data from the POST variable that came from the form
    $eventName = isset($_POST['eventName']) ? $_POST['eventName'] : '';
    $eventDescription = isset($_POST['eventDescription']) ? $_POST['eventDescription'] : '';
    $eventPresenter = isset($_POST['eventsPresenter']) ? $_POST['eventsPresenter'] : '';
    $eventDate = isset($_POST['eventDate']) ? $_POST['eventDate'] : '';
    $eventTime = isset($_POST['eventTime']) ? $_POST['eventTime'] : '';
    $eventDateInserted = isset($_POST['eventDateInsert']) ? $_POST['eventDateInsert'] : '';
    $eventDateUpdated = isset($_POST['eventDateUpdated']) ? $_POST['eventDateUpdated'] : '';
    //echo $eventName;
    //echo $eventDescription;
    //echo $eventPresenter;
    //echo $eventDate;
    //echo $eventTime;
    //echo $eventDateInserted;
    //echo $eventDateUpdated;

    // Server side data validation
    // If any field fails a validation - set $validForm to false

    // Validation - event name and description are required

    requiredField($eventName);
    requiredField($eventDescription);

    if ($validForm) {
        //all form data is valid continue to add form data to database



        require 'dbConnect.php';

        $sql = "INSERT INTO wdv341_events (events_name, events_description, events_presenter, events_date, events_time, events_date_inserted, events_date_updated) VALUES (:eventsName, :eventsDesc, :eventsPresenter, :eventDate, :eventTime, :eventDateInsert, :eventDateUpdated)";

        $stmt = $conn->prepare($sql);                       //prepare your PDO Prepared Statement

        $stmt->bindParam(':eventsName', $eventName);
        $stmt->bindParam(':eventsDesc', $eventDescription);
        $stmt->bindParam(':eventsPresenter', $eventPresenter);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':eventTime', $eventTime);
        $stmt->bindParam(':eventDateInsert', $eventDateInserted);
        $stmt->bindParam(':eventDateUpdated', $eventDateUpdated);

        $stmt->execute();
        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] !== '00000') {
            echo "PDO Error: " . $errorInfo[0] . "<br>";
            echo "Driver Error Code: " . $errorInfo[1] . "<br>";
            echo "Driver Error Message: " . $errorInfo[2] . "<br>";
        }
    }
} else {
    // if form was not submitted, display form
    $validForm = false;
};


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>WDV341 Unit 10-1</title>
</head>

<body>
    <h1>WDV341 Intro to PHP</h1>
    <h2>Input Event Data Into the Database</h2>

    <?php
    /*
    if(submitted the form){
        you should display confirmation msg
    }
    else{
        i need to see the form to get the event data
        display the form html
    }

*/

    if ($validForm) {
        //echo "Thank you, everything worked!";
    ?>
        <h3>Thank you, everything worked.</h3>
    <?php
    } else {
    ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>
                <label for="eventName">Event Name:</label>
                <input type="text" name="eventName" id="eventName">
            </p>

            <p>
                <label for="eventDescription">Event Description:</label>
                <textarea type="text" name="eventDescription" id="eventDescription"></textarea>
            </p>

            <p>
                <label for="eventsPresenter">Event Presenter:</label>
                <input type="text" name="eventsPresenter" id="eventsPresenter">
            </p>

            <p>
                <label for="eventDescription">Event Date:</label>
                <input type="text" name="eventDate" id="eventDate">
            </p>

            <p>
                <label for="eventDescription">Event Time:</label>
                <input type="text" name="eventTime" id="eventTime">
            </p>

            <p>
                <label for="eventDescription">Event Date Inserted:</label>
                <input type="text" name="eventDateInsert" id="eventDateInsert">
            </p>

            <p>
                <label for="eventDateUpdated">Event Date Updated:</label>
                <input type="text" name="eventDateUpdated" id="eventDateUpdated">
            </p>

            <p>
                <input type="submit" value="Submit" name="submit">
                <input type="reset">
            </p>
        </form>

    <?php
    }
    ?>

    <a href="login.php">
        Return to Dashboard
    </a>
</body>

</html>