<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #container {
            text-align: center;
            margin: 50px auto;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            color: #333;
            margin-top: 10px;
        }

        #error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div id="container">
    <h2>Create your QR code</h2>
    <?php
    $fullName = $studentID = $errorMessage = "";
    $qrCode = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = test_input($_POST["full_name"]);
        $studentID = test_input($_POST["student_id"]);

        if (empty($fullName) || empty($studentID)) {
            $errorMessage = "Please enter your full name and student ID.";
        } else {
            $errorMessage = "";

            $data = "Full Name: " . $fullName . "\nStudent ID: " . $studentID;
            $url = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode($data);

            $qrCode = '<img src="' . $url . '" alt="QR Code" />';
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required value="<?php echo $fullName; ?>">
        <input type="number" id="student_id" name="student_id" placeholder="Enter your student ID" required value="<?php echo $studentID; ?>">
        <input type="submit" value="Generate QR Code">
    </form>
    <p id="error-message"><?php echo $errorMessage; ?></p>
    <div id="qrcode"><?php echo $qrCode; ?></div>
    <p id="qr-message" <?php if (empty($qrCode)) echo 'style="display: none;"'; ?>>Here's your information QR code!</p>
</div>
</body>
</html>
