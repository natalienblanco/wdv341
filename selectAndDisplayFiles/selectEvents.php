<?php
//  1. Connect to the database
//  2. Create your SQL query
//  3. Prepare your PDO Statement
//  4. Bind Variables to the PDO Statement, if any
//  5. Execute the PDO Statement - run your SQL against the database
//  6. Process the results from the query

try {
    require 'dbConnect.php';

    $sql = "SELECT events_name, events_description, events_presenter, DATE_FORMAT(events_date, '%W %M %e %Y' ) as eventsFormatDate, events_time, events_date_inserted, events_date_updated FROM wdv341_events";

    $stmt = $conn->prepare($sql);                       //prepare your PDO Prepared Statement

    $stmt->execute();           //result of the query, is stored in the $stmt variable/object
    //the result looks and acts like a database

    $stmt->setFetchMode(PDO::FETCH_ASSOC);    //return values as an ASSOC array
} catch (PDOException $e) {
    $message = "There has been a problem. The system administrator has been contacted. Please try again later.";

    error_log($e->getMessage());            //Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
    error_log($e->getLine());
    error_log(print_r(debug_backtrace(), true));


    //Clean up any variables or connections that have been left hanging by this error.		

    //header('Location: files/505_error_response_page.php');	//sends control to a User friendly page
    echo "<h1>$message</h1>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Intro to PHP</h1>
    <h2>SELECT Demonstration Page</h2>
    <h2>SelectEvents from the WDV341 Database</h2>

    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Event Description</th>
                <th>Event Presenter</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Events Date Inserted</th>
                <th>Events Date Updated</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch()) {
            ?>
                <tr>
                    <td><?php echo $row["events_name"]; ?></td>
                    <td><?php echo $row["events_description"]; ?></td>
                    <td><?php echo $row["events_presenter"]; ?></td>
                    <td><?php echo $row["eventsFormatDate"]; ?></td>
                    <td><?php echo $row["events_time"]; ?></td>
                    <td><?php echo $row["events_date_inserted"]; ?></td>
                    <td><?php echo $row["events_date_updated"]; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>