<?php
if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['Gender']) && isset($_POST['email']) && isset($_POST['phone']))
        {
            $username = $_POST['name'];
            $password = $_POST['password'];
            $Gender = $_POST['Gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $host = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbName = "test";
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
            if ($conn->connect_error) 
            {
                die('Could not connect to the database.');
            }
            else 
            {
                $Select = "SELECT email FROM regisform WHERE email = ? LIMIT 1";
                $Insert = "INSERT INTO regisform(	name,password,gender,email,	phonenumber) values(?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($Select);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($resultEmail);
                $stmt->store_result();
                $stmt->fetch();
                $rnum = $stmt->num_rows;
                if ($rnum == 0)
                {
                    $stmt->close();
                    $stmt = $conn->prepare($Insert);
                    $stmt->bind_param("ssssi",$username, $password, $Gender, $email, $phone);
                    if ($stmt->execute()) 
                    {
                        echo "New record inserted sucessfully.";
                    }
                    else 
                    {
                        echo $stmt->error;
                    }
                }
                else 
                {
                    echo "Someone already registers using this email.";
                }
                $stmt->close();
                $conn->close();
            }
        }
        else 
        {
            echo "All field are required.";
            die();
        }
    
?>
