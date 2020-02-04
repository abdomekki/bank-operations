<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/home.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
<?php


class connect_db{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    protected $conn;

    
    function __construct()
    {
        $this->servername="localhost";
        $this->username="root";
        $this->password="";
        $this->dbname="bank";
        $this->conn = new mysqli($this->servername, $this->username, $this->password,$this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
    }
}



class validuser extends connect_db{
    function valid($email,$pass){
        $sql="SELECT * FROM `users`";
        $result = $this->conn->query($sql);
        $found=false;

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($email==$row["email"] && $pass==$row["pass"])
                {
                    $found=true;
                    break;
                }
            }
            if($found==true)
            {
                return true;
                
                
            }
            else {
                ?>
                <div class="cong">
                    <form>
                        <h2 style="color: white">Email Or Password are Wrong , Please Try again!!!</h2>
                        <a href="index.php" style="text-decoration: none">Go back to page</a>
                        <br><br>
                    </form>
    
                </div>
            <?php
            header("refresh:2;url=index.php");
            
            }

        } else {
            ?>
            <div class="cong">
                <form>
                    <h2 style="color: white">No Users Data!!!</h2>
                    <a href="index.php" style="text-decoration: none">Go back to page</a>
                    <br><br>
                </form>

            </div>
        <?php
           header("refresh:2;url=index.php");
            
            }
    }


}

class viewData extends connect_db{

    function viewAll()
    {
        $sql="SELECT * FROM `customer` ORDER BY credit DESC";
        $result = $this->conn->query($sql);
        return $result;
    }
}

class getcustomer extends connect_db{
    function getdata($name){
        $sql = "SELECT * FROM `customer` WHERE c_name='$name'";
    }

    function selectcustomer(){
        $query="SELECT c_name FROM customer";
        $result = $this->conn->query($query);
        return $result;
    }

}

class deposit extends connect_db{
    function c_deposit($value,$name)
    {
        if($value>0)
        {
            $sql = "SELECT credit FROM customer where c_name='$name' ";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $total=$value+$row["credit"];
                $this->newDeposit($total,$name);
                

            }
            } else {
            echo "0 results";
            }
        }else {
            ?>
            <div class="cong">
                <form>
                    <h2 style="color: white">Enter Number Greater Than Zero!!!</h2>
                    <a href="index.php" style="text-decoration: none">Go back to page</a>
                    <br><br>
                </form>

            </div>
        <?php
         header("refresh:2;url=deposit.php");
            
        }    
    }


    function newDeposit($total,$name)
    {
        $query2 = "UPDATE customer SET credit='$total' WHERE c_name='$name'";
        
        if ($this->conn->query($query2) === TRUE) {
            header("location:home.php");
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    function idDeposit($id,$value)
    {
        if($value>0)
        {
            $sql = "SELECT credit FROM customer where national_id='$id' ";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $total=$value+$row["credit"];
                $this->newIdDeposit($total,$id);
                

            }
            } else {
                ?>
                    <div class="cong">
                        <form>
                            <h2 style="color: white">There No Id Like This , please try again!!!</h2>
                            <a href="index.php" style="text-decoration: none">Go back to page</a>
                            <br><br>
                        </form>

                    </div>
                <?php
                header("refresh:2;url=iddeposit.php");
            echo "0 results";
            }
        }else {
            ?>
            <div class="cong">
                <form>
                    <h2 style="color: white">Enter Number Greater Than Zero!!!</h2>
                    <a href="index.php" style="text-decoration: none">Go back to page</a>
                    <br><br>
                </form>

            </div>
        <?php
         header("refresh:2;url=iddeposit.php");
        }  
    }

    function newIdDeposit($total,$id)
    {
        $query2 = "UPDATE customer SET credit='$total' WHERE national_id='$id'";
        
        if ($this->conn->query($query2) === TRUE) {
            header("location:home.php");
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}


class withdraw extends connect_db {
    function c_withdraw($name,$value)
    {
        if($value>0)
        {
            $sql = "SELECT credit FROM customer where c_name='$name' ";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["credit"]>=$value){
                    $total=$row["credit"]-$value;
                    $this->newWithdraw($total,$name);
                }else {
                    ?>
                        <div class="cong">
                            <form>
                                <h2 style="color: white">Not Enough Balance !!!</h2>
                                <a href="index.php" style="text-decoration: none">Go back to page</a>
                                <br><br>
                            </form>
            
                        </div>
                    <?php
                    header("refresh:2;url=withdraw_n.php");
                    
                }

            }
            } else {
            echo "0 results";
            }
        }else {
            ?>
            <div class="cong">
                <form>
                    <h2 style="color: white">Enter Number Greater Than Zero!!!</h2>
                    <a href="index.php" style="text-decoration: none">Go back to  page</a>
                    <br><br>
                </form>

            </div>
        <?php
         header("refresh:2;url=withdraw_n.php");
        } 
    }

    function newWithdraw($total,$name)
    {
        $query2 = "UPDATE customer SET credit='$total' WHERE c_name='$name'";
        
        if ($this->conn->query($query2) === TRUE) {
            header("location:home.php");
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    function advanceWithdraw($amount,$num,$pin)
    {   
        $sql = "SELECT * FROM customer where visa_no='$num' and visa_pass='$pin' ";
        $result = $this->conn->query($sql);
        if($amount>0)
        {                
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["credit"]>=$amount)
                {
                    $total=$row["credit"]-$amount;
                    $this->newadvance($total,$num,$pin);
                }else {
                    ?>
                        <div class="cong">
                            <form>
                                <h2 style="color: white">Not Enough Balance!!!</h2>
                                <a href="index.php" style="text-decoration: none">Go back to page</a>
                                <br><br>
                            </form>
            
                        </div>
                    <?php
                    header("refresh:2;url=withdraw.php");
                }

            }
            } else {
                ?>
                    <div class="cong">
                        <form>
                            <h2 style="color: white">Visa Number or Password are Wrong!!!</h2>
                            <a href="index.php" style="text-decoration: none">Go back to page</a>
                            <br><br>
                        </form>
        
                    </div>
                <?php
                header("refresh:2;url=withdraw.php");
            echo "Visa Number Or Pass Are Wrong , Please Try again...";
            }
        }else {
            ?>
                <div class="cong">
                    <form>
                        <h2 style="color: white">Enter Number Greater Than Zero!!!</h2>
                        <a href="index.php" style="text-decoration: none">Go back to page</a>
                        <br><br>
                    </form>
    
                </div>
            <?php
            header("refresh:2;url=withdraw.php");
        } 
        
    }

    function newadvance($total,$num,$pin)
    {
        $query2 = "UPDATE customer SET credit='$total' where visa_no='$num' and visa_pass='$pin'";
        
        if ($this->conn->query($query2) === TRUE) {
            header("location:home.php");
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

}



?>


</body>
</html>