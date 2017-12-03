<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        include('php/DatabaseConnection.php');
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $name = $_POST['fullName'];
        $sql = "insert into UserAuthentication values('$user','$name','$pass')";
        $result = $connection->query($sql);
        
        if($result == TRUE)
        {
            header('location: index.php');
        }
        else{
            echo "<script> alert('User registration failed or username exists')</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Online Banking
        </title>
        <link rel='stylesheet' href='css/templateStyle.css'>
    </head>    
    
    <body id='body'>
        <header class='headerDiv'>
            <center><h1>Online Banking</h1></center>
        </header>
        <center>
            <div class='loginDiv'>
                <form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
                    <table>
                        <tr>
                            <td>
                                <font>Name:</font>
                            </td>
                            <td>
                                <input type='text' value='' name='fullName'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font>Username:</font>
                            </td>
                            <td>
                                <input type='text' value='' name='username'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font>Password:</font>
                            </td>
                            <td>
                                <input type='password' value='' name='password'>
                            </td>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type='submit' value='Submit'>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </body>
</html>