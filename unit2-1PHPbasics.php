<!DOCTYPE html>
<html lang="en">
<!--Natalie Blanco
    WDV341
    01/23/2024-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV341 Intro to PHP</title>
</head>

<body>
    <h1>2-1: PHP Basics</h1>
    <h2>
        <?php $yourName = "Natalie Blanco";
        echo $yourName; ?>
    </h2>

    <?php
    $number1 = 7;
    $number2 = 4;
    $total = $number1 + $number2;
    ?>

    <p>Number 1: <?php echo $number1; ?></p>
    <p>Number 2: <?php echo $number2; ?></p>
    <p>Total: <?php echo $total; ?></p>

    <?php
    $programmingLanguages = array('PHP', 'HTML', 'JavaScript');
    ?>

    <script>
        let jsArray = [];
        <?php
        foreach ($programmingLanguages as $language) {
            echo 'jsArray.push("' . $language . '");';
        }
        ?>
    </script>
    <script>
        document.write("<p>Programming Languages: " + jsArray.join(', ') + "</p>");
    </script>
</body>

</html>