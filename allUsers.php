<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	 <?php
	 		error_reporting(E_ALL);
            $servername = "localhost";
            $username = "root";
            $password = "t3cht0n!c";
            $db = "myDatabase";

			// Create connection
			//mysqli_connect($servername, $username, $password, $db) or die(mysqli_err);
			$conn = new mysqli($servername, $username, $password, $db);
			// Check connection
			if (!$conn) {
			    die("Connection failed: " . mysqli_connect_error());
			}

			$sql = "SELECT FirstName, LastName, Email FROM users";
			
			$result = mysqli_query($conn, $sql);

			while($row = $result->fetch_assoc()) {
			    echo "Name: " . $row["FirstName"]. " " . $row["LastName"]. " email: " . $row["Email"]. "<br>";
			}
			 

			$conn->close();
	?> 
</body>
</html>