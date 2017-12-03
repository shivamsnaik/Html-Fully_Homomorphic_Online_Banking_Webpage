<?php
    session_start();
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
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        include 'php/DatabaseConnection.php';
                        $user = $_POST['userName'];
                        $pass = $_POST['userPass'];
                        
                        $sql_query = "select * from UserAuthentication where username='$user' and password='$pass'";
                        $result = $connection->query($sql_query);
                        
                        if($result->num_rows > 0)
                        {
                            
                            $_SESSION['username'] = $user;
                            echo "<script> window.location = 'bankTransaction.php'</script>";
                        }
                        else{
                            echo "<b> User authentication failed</b>";
                        }
                    }
                ?>
                <h2>Login</h2>
                <form method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                    <table>
                        <tr>
                            <td><p>Username:</p></td>
                            <td><input type='text' value='' name='userName' required></td>
                        </tr>
                        <tr>
                            <td><p>Password:</p></td>
                            <td><input type='password' name='userPass' required></td>
                        </tr>
                        <tr>
                            <td><input type='submit' value='Submit'></td>
                        </tr>
                    
                    </table>
                </form>
                
            </div>
            
        </center>
        
        
    </body>
</html>