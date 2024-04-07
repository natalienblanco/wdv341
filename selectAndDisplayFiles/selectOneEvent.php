<?php

//this page will SELECT data from our wdv341 database.

// 1. Connect to the database
// 2. Create your SQL query
// 3. Prepare your PDO statement
// 4. Bind variables to the PDO statement, if any
// 5. Execute the PDO statement - run your SQL against the database
// 6. Process the results from the query

// Include dbConnect.php to establish a database connection
require 'dbConnect.php';

// Define event number to be retrieved
$eventNumber = 1; // Can be changed to the desired event number

// Define SQL query with a WHERE clause to select a specific event
$sql = "SELECT events_name, events_description, events_presenter, DATE_FORMAT(events_date, '%W %M %e %Y' ) as eventsFormatDate, events_time, events_date_inserted, events_date_updated FROM wdv341_events WHERE events_id = :eventNumber";

try {
    // Prepare PDO statement
    $stmt = $conn->prepare($sql);

    // Bind the event number parameter
    $stmt->bindParam(':eventNumber', $eventNumber, PDO::PARAM_INT);

    // Execute PDO statement
    $stmt->execute();

    // Set the fetch mode to associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Fetch the data from the result sewt
    $row = $stmt->fetch();

    // Check if there's a result
    if ($row) {
        //Display the event details im a table format
        echo "<table border='1'>";
        echo "<tr><th>Name</th><th>Description</th><th>Presenter</th><th>Date</th><th>Time</th><th>Date Inserted</th><th>Date Uploaded</th></tr>";
        echo "<tr>";
        echo "<td>" . $row['events_name'] . "</td>";
        echo "<td>" . $row['events_description'] . "</td>";
        echo "<td>" . $row['events_presenter'] . "</td>";
        echo "<td>" . $row['eventsFormatDate'] . "</td>";
        echo "<td>" . $row['events_time'] . "</td>";
        echo "<td>" . $row['events_date_inserted'] . "</td>";
        echo "<td>" . $row['events_date_updated'] . "</td>";
        echo "</table>";
    } else {
        // If no result, display message for client
        echo "No events found.";
    }
} catch (PDOException $e) {
    //Display error if the SELECT fails
    echo "Error: " . $e->getMessage();
};
