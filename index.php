<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php
        //validate field data here
        $firstName = $lastName = $email = "";
        $validForm = false;

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(empty($_POST["firstName"])){
                $firstName = "A name is required";
            } else {
                $firstName = $_POST["firstName"];
                $validForm = true;
            }

            if(empty($_POST["lastName"]) && $validForm){
                $lastName = "A name is required";
                $validForm = false;
            } else {
                $lastName = $_POST["lastName"];
            }

            if(empty($_POST["email"]) && $validForm){
                $email = "An email address is required. Yeah we're going to spam you.";
                $validForm = false;
            } else {
                $email = $_POST["email"];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $email = "Did you think you'd get away with a fake e-mail?";
                    $validForm = false;
                }
            }
        }

        //do something if form is valid
        if($validForm)
        {
            addUser($firstName, $lastName, $email);

        }

        function addUser($firstName, $lastName, $email)
        {
            $servername = "localhost";
            $username = "root";
            $password = "t3cht0n!c";
            $db = "myDatabase";

            $conn = new mysqli($servername, $username, $password, $db);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            $sql = "INSERT INTO users (FirstName,LastName, Email)
            VALUES ('$firstName', '$lastName', '$email')";

            if($conn->query($sql) === TRUE){
                echo "New record created";
            } else{
                echo "Error: " . $sql . "<br />" . $conn->error;
            }

            $conn->close();

        }


    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        First Name: <input type="text" name="firstName" value = "<?php echo $firstName ?>"><br>
        Last Name: <input type="text" name="lastName" value = "<?php echo $lastName ?>"><br>
        E-mail: <input type="text" name="email" value = "<?php echo $email ?>"><br>
        <input type="submit" value="Create New User">
    </form>
</body>
</html>