<?php
/*
Instructions:
- Create a function that will accept a Unix Timestamp as a parameter and format it into mm/dd/yyyy format.
- Create a function that will accept a Unix Timestamp as a parameter and format it into dd/mm/yyyy format to use when working with international dates.
- Create a function that will accept a string parameter.  It will do the following things to the string:
    - Display the number of characters in the string
    - Trim any leading or trailing whitespace
    - Display the string as all lowercase characters
    - Will display whether or not the string contains "DMACC" either upper or lowercase
- Create a function that will accept a number parameter and display it as a formatted phone number.   Use 1234567890 for your testing.
- Create a function that will accept a number parameter and display it as US currency with a dollar sign.  Use 123456 for your testing.
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--Natalie Blanco
        WDV341-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV 341 3-1 PHP Functions</title>
</head>

<body>
    <h1>WDV 341</h1>
    <h2>Unit 3-1 PHP Functions</h2>
    <?php
    // function to format Unix Timestamp to mm/dd/yyy format:
    function formatToMMDDYYYY($timestamp)
    {
        return date('m/d/Y', $timestamp);
    }

    //function to format Unix timestamp to dd/mm/yyyy format for international dates:
    function formatToDDMMYYYY($timestamp)
    {
        return date('d/m/Y', $timestamp);
    }

    //function to process & display info about a string:
    function processString($inputString)
    {
        $length = strlen($inputString);
        $trimmedString = trim($inputString);
        $lowercaseString = strtolower($inputString);
        $containsDMACC = (stripos($inputString, 'DMACC') !== false) ? 'Yes' : 'No';

        echo "Number of characters: $length <br>";
        echo "Trimmed string: $trimmedString <br>";
        echo "Lowercase string: $lowercaseString <br>";
        echo "Contains DMACC: $containsDMACC <br>";
    }

    //function to display a formatted phone number:
    function formatPhoneNumber($number)
    {
        $formattedNumber = sprintf("(%s) %s-%s", substr($number, 0, 3), substr($number, 3, 3), substr($number, 6));
        echo "Formatted Phone Number: $formattedNumber <br>";
    }

    //function to display a number as a US Currency:
    function formatAsUSCurrency($number)
    {
        $formattedCurrency = number_format($number, 2, '.', ',');
        echo "US Currency: $$formattedCurrency <br>";
    }

    //testing functions - 
    $timestamp = time();
    $stringToProcess = '    Hello DMACC   ';
    $phoneNumber = '1234567890';
    $currencyNumber = 123456;

    echo "Formatted Date (mm/dd/yyyy): " . formatToMMDDYYYY($timestamp) . "<br>";
    echo "Formatted Date (dd/mm/yyyy): " . formatToDDMMYYYY($timestamp) . "<br>";

    processString($stringToProcess);
    formatPhoneNumber($phoneNumber);
    formatAsUSCurrency($currencyNumber);
    ?>
</body>

</html>