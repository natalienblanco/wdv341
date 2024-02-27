<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV341 HTML Form Submission Confirmation</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
	<style>
		h1,
		h2 {
			text-align: center;
			padding: 10px;
		}

		body {

			margin: auto;

			padding-left: 20px;
		}
	</style>
</head>

<body>
	<h1>WDV341 Intro to PHP</h1>
	<h2>Unit 4-1 HTML Form Processor</h2>

	<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$firstName = $_POST["first_name"];
		$lastName = $_POST["last_name"];
		$email = $_POST["email"];
		$academicStanding = $_POST["academic_standing"];
		$selectedMajor = $_POST["selected_major"];
		$checkbox1 = isset($_POST["checkbox1"]) ? "Program Information" : "";
		$checkbox2 = isset($_POST["checkbox2"]) ? "Contact with Program Advisor" : "";
		$comments = $_POST["freeForm"];

		echo "<p>Dear $firstName,</p>";
		echo "<p>Thank you for your interest in DMACC.</p>";
		echo "<p>We have listed you as $academicStanding starting this fall.</p>";
		echo "<p>You have declared $selectedMajor as your major.</p>";

		echo "<p>Based upon your responses we will provide the following information in our confirmation email to you at $email.</p>";
		echo "<p><ul><li>$checkbox1</li></ul></p>";
		echo "<p><ul><li>$checkbox2</li></ul></p>";

		echo "<p>You have shared the following comments which we will review:</p>";
		echo "<p>$comments</p>";
	}

	?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>