<html>
<head>
<title>SQL Injection DemoFix</title>
<link rel="stylesheet" href="style.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

<!--https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php-->

</head>
    <body>
        
        <?php
              // define variables and set to empty values
              $password = $email =$theresult= "";
              
              if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['someaction'])) {
                $email = $_POST["email"];
                $password =$_POST["password"];
             
                
                // $email="'or '1'='1";
                // $password="'or '1'='1";
  
                $servername = "0.0.0.0";
                $username = "";
                $dbpassword = "";
                $dbname = "demoDB";
                $conn = new mysqli($servername, $username, $dbpassword,$dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                echo "Connected to ". $dbname." successfully";
                
                // $testq="SELECT * FROM Users where email= '$email'and password='$password'";
                // $result = $conn->query($testq);
                $testq=$conn->prepare("SELECT * FROM Users where email= ? and password= ?");
                $testq->bind_param('ss',$email,$password);
                $testq->execute();
                $result = $testq->get_result();
                while($row = $result->fetch_assoc()){
                  
                            $theresult=$theresult.'<br />Your Email is:' . $row['email'] . '<br/>Your Password is: ' . $row['password'] .'<br />';
                            
                }
                
                if ( $result=== TRUE) {
                      echo "Execution Worked";
                  }
                  // else {
                  //     echo "Error creating table,etc: " . $conn->error;
                  // }
                $conn->close();
    
              }
             
        ?>
    
        <div class="row">
          <h1 class="col-md-4">SQL Injection DemoFix:</I></h1>
          <p>Try to use :  <code>hack'or '1'='1</code> as the password to perform SQL Injection</p>
        </div>
        <div class="container-fluid jumbotron" id=outer>
            <div class="well col-md-4"><h5>Use prepared statements and parameterized queries. These are SQL statements that are sent to and parsed by the database server separately from any parameters. This way it is impossible for an attacker to inject malicious SQL.<a href="http://php.net/manual/en/mysqli-stmt.bind-param.php#refsect1-mysqli-stmt.bind-param-examples" target=newtab>Example Here</a></a></h5></div>
           
            <form class="col-md-2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="text" name="email" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" name="password" class="form-control" id="pwd">
              </div>
              <button type="submit" name="someaction" class="btn btn-primary">Submit</button></br>
              <a href="https://sqlinjection-ice-wolf.c9users.io/netsecprojectQ6/demo.php">BROKEN DEMO HERE</a>
            </form>
            
             <code class="well col-md-6">
              //BEFORE</br></br>
              $testq="SELECT * FROM Users where email= '$email'and password='$password'";</br>
              $result = $conn->query($testq);
              </br></br>
              //AFTER </br></br>
              
              $testq=$conn->prepare("SELECT * FROM Users where email= ? and password= ?");</br>
              $testq->bind_param('ss',$email,$password);</br>
              $testq->execute();</br>
              $result = $testq->get_result();
            </code>
        </div>
        <div class="container">
          <?php
            echo "<h2>Results of Form Sumission:</h2>";
            echo "<p>Your Input:-</p>";
            echo $email;
            echo "<br>";
            echo $password;
            if(isset($_POST['someaction'])){
              if($theresult==='')
                echo "<br/>Invalid Username or Password";
              else
                echo "<br/>Welcome ". $theresult;
            }
            ?>
        </div>
    </body>
</html>
