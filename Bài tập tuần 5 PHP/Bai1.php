<?php
$name = $email = $comment = "";
$name_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $name_err = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!ctype_alpha(str_replace(' ', '', $name)) || trim($name) === '') {
            $name_err = "Only letters and spaces are allowed, cannot be all spaces";
        }
    }

    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Email is not in the correct format";
        }
    }

    if (!empty($_POST["comment"])) {
        $comment = test_input($_POST["comment"]);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {color: #FF0000;}
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
        input[type="text"], textarea {
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
    </style>
</head>
<body>

<div id="container">
    <h2>Enter information</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="text" name="name" placeholder="Enter your name" value="<?php echo $name;?>">
        <span class="error">* <?php echo $name_err;?></span>
        <br>
        <input type="text" name="email" placeholder="Enter your email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $email_err;?></span>
        <br>
        <textarea name="comment" rows="5" cols="40" placeholder="Enter your comment here!"><?php echo $comment;?></textarea>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if ($name_err == "" && $email_err == "" && $_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<h2>Your comment has been recorded</h2>";
        echo "<p>Name: " . $name . "</p>";
        echo "<p>Email: " . $email . "</p>";
        echo "<p>Comment: " . $comment . "</p>";
    }
    ?>
</div>
</body>
</html>
