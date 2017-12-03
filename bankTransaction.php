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
                    include 'php/DatabaseConnection.php';
                    
                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    {   global $connection;
                        $user = $_SESSION["username"];
                        $sql = "select `balance` from AccountDetails where username='$user'";
                        //$conn = $GLOBALS["connection"];
                        $result = $connection->query($sql);
                        
                        if($result->num_rows>0)
                        {
                            $row = $result->fetch_assoc();
                            
                            if(isset($_POST["amtCredit"]))
                            {
                                
                                $val1 = $_POST["amtCredit"];
                                
                                if($val1>0)
                                {
                                    creditAmount($row["balance"], $val1);
                                }else{
                                    echo "<script>alert('Negative numbers are not supported')</script>";
                                }
                            }
                            if(isset($_POST["amtDebit"]))
                            {
                                $val2 = $_POST["amtDebit"];
                                if($val2>0)
                                {
                                    DebitAmount($row["balance"], $val2);
                                }else{
                                    echo "<script>alert('Negative numbers are not supported')</script>";
                                } 
                                
                            }
                        }
                        
                        
                    }
                    $user = $_SESSION['username'];
                    #echo "<b>$username</b>";
                    $sql = "select * from AccountDetails where username='$user'";
                    $result = $connection->query($sql);
                    
                    $p = 131;
                    $q = 197;
                    $n = 25807;
                    $n_square = 666001249;
                    $g = 2;
                    $lambda = 12740;
                    
                    $_SESSION['connection'] = $connection;
                    if($result->num_rows > 0)
                    {
                        
                        while($row = $result->fetch_assoc())
                        {
                            
                            echo "
                                <b>
                                    <fieldset id='InfoFieldset'>
                                        <table>
                                            <tr>
                                                <td><h3>Name</h3></td>
                                                <td> <td>
                                                <td><h3>" . $row["name"] . "</h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Account No.</h3></td>
                                                <td> <td>
                                                <td><h3>" . decrypt($row["accNo"]) . "</h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Address</h3></td>
                                                <td> <td>
                                                <td><h3>" . $row["address"] . "</h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Balance</h3></td>
                                                <td> <td>
                                                <td><h3>Rs." . decrypt($row["balance"]) . "</h3></td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </b>";
                            
                        }
                    }
                    else{
                        echo "<b>User details yet to be updated</b>";
                    }
                    
                    
                    function creditAmount($bal, $credit)
                    {
                        
                            echo "<b>BALANCE : $bal</b><br>";
                        #$credit = $_POST["amtCredit"];
                            echo "<br><br><br><b>AMOUNT TO BE CREDITED : $credit</b><br>";
                        $encrypted_bal =  encrypt($credit);
                            echo "<br><br><br><b>AMOUNT TO BE CREDITED[encrypted] : $encrypted_bal</b><br>";
                        $sum = bcmod(bcmul($encrypted_bal,$bal),666001249);
                            echo "<br><br><br><b>TOTAL SUM : $sum</b><br>";
                         $sql = "UPDATE AccountDetails SET  balance='$sum' WHERE username='" . $_SESSION["username"] . "'";
                        $GLOBALS["connection"]->query($sql);
                        
                    }
                    
                    function DebitAmount($bal, $debit)
                    {
                        
                            echo "<b>BALANCE : $bal</b><br>";
                        #$credit = $_POST["amtCredit"];
                            echo "<br><br><br><b>AMOUNT TO BE DEBITED : $debit</b><br>";
                        $encrypted_bal =  encrypt($debit);
                            echo "<br><br><br><b>AMOUNT TO BE DEBITED[encrypted] : $encrypted_bal</b><br>";
                        #$sum = bcmod(bcdiv($encrypted_bal,$bal),666001249);
                        $sum = bcmod(bcmul($encrypted_bal,bcpow($bal,-1),-1),666001249);
                            echo "<br><br><br><b>TOTAL SUM : $sum</b><br>";
                         $sql = "UPDATE AccountDetails SET  balance='$sum' WHERE username='" . $_SESSION["username"] . "'";
                        $GLOBALS["connection"]->query($sql);
                        
                    }
                    
                    function encrypt($plaintext)
                    {
                        #Encrypts plaintext m. ciphertext c = g^m * r^n mod n^2. This function automatically generates random input r (to help with encryption).
                        
                        $r = 46849;
                        $cyphertext = bcmod((bcmod((bcpow(2,$plaintext)),666001249) * bcmod((bcpow($r,25807)),666001249)),666001249);
                        echo "<b>$cyphertext</b>";
                        return $cyphertext;
                        
                    }
                    
                    function decrypt($cyphertext)
                    {
                        #Decrypts ciphertext c. plaintext m = L(c^lambda mod n^2) * u mod n, where u = (L(g^lambda mod n^2))^(-1) mod n.
                        
                        #$temp = ((pow($cyphertext,$GLOBALS['lambda'])%pow($GLOBALS['n'],2))-1)/$GLOBALS['n'];
                        $temp = 13943;
                        #echo "<b>$temp</b><br>";
                        #$u = pow($temp,-1)%$GLOBALS['n'];
                        $u = 23734;
                        #echo "<b>$u</b><br>";
                        $temp1 = (bcmod(bcpow("$cyphertext",12740),666001249)-1)/25807;
                        #echo "<b>$temp1</b><br>";
                        $plaintext = ($temp1 * $u)%25807;
                        echo "<b>$cyphertext</b><br>";
                        return $plaintext;
                    }
                ?>
                <br><br>
                <fieldset>
                    <legend>
                        <b>Credit</b>
                    </legend>
                    <form method='post' action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>'>
                        <table>
                            <tr>
                                <td>
                                    <b>Enter Amount :&emsp;</b>
                                </td>
                                <td>
                                    <input type='text' value='0' name='amtCredit'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type='submit' value='Submit'>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
                
                <fieldset>
                    <legend>
                        <b>Debit</b>
                    </legend>
                    <form method='post' action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>'>
                        <table>
                            <tr>
                                <td>
                                    <b>Enter Amount :&emsp;</b>
                                </td>
                                <td>
                                    <input type='text' value="0" name = 'amtDebit'>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type='submit' value='Submit'>
                                </td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
                
                <br><button onClick="Javascript:window.location.href = 'index.php';">Logout</button>
                
            </div>
            
        </center>
        
        
    </body>
</html>