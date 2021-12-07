<?php
//start session
session_start();

include('connection.php');

$pswdErrorMessage="";
$userErrorMessage="";
  if(isset($_POST['login']) && (empty($_POST['user']) || empty($_POST['pswd']))) {
   $userErrorMessage = empty($_POST['user']) ? "Please fill in!" : ""; 
   $pswdErrorMessage = empty($_POST['pswd']) ? "Please fill in!" : ""; 
  }
  elseif(isset($_POST['login'])) {
    $user = $_POST['user'];
    $pswd = $_POST['pswd'];
   ////We neeed to make call to database to verify entry
   try{
    
    //PHP object assigned to an instance of the connection class
    $connection = new Connection();
    //open connection 
    $conn = $connection->open();
     //SQL query 
    $sql = "SELECT event_user_name, event_user_password FROM event_user WHERE event_user_name=:user AND event_user_password=:pswd;";
    //pepare query string
    $conn->prepare($sql);
    $query = $conn->prepare($sql);
    //bind values to query
    $query->bindparam(':user', $user);
    $query->bindparam(':pswd', $pswd);
    //execute query
    $query->execute();
    //Fetch results
    $row = $query->fetch(PDO::FETCH_ASSOC);
    //cast to int bc $row to compare against 1 for validdation
    $rowCount = (int)$row;
    if($rowCount==1) {
      //set Session variable to true
      $_SESSION['validUser'] = true;
      print_r($_SESSION['validUser']);
      var_dump($_SESSION['validUser']);
      echo $_SESSION['validUser'];
    }
    else {
      //set Session variable to false
      $_SESSION['validUser'] = false;
      //implementing flash messaging to inform user of login results
      $_SESSION['loginErrorMessage'] = "Incorrect Username or Password!!!";
      header("Location: login.php");
      return;
    }

   }
   catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
   }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="This webpage will implement PHP to build a login page that will grant admin priviliges upon validation">
  <meta name="keywords" content="PHP Admin Login SQL">
  <meta name="author" content="Joshua Allen">
  <title>Login Page</title>
  <style>
    *, ::after, ::before{
      margin:0;
      padding:0;
      box-sizing: border-box;
    }
    html {
      font-size: 62.5%;
    }
    body {
      font: 1.8rem Tahoma, Geneva,  sans-serif;
    }
    main{
      border: 5px dashed rgba(255,0,255,1);
     
      margin: 0 auto;
      
    }
    form {
      border: 3px solid rgba(255,0,0,0);
      background: rgba(255,0,0,0.3);
    }
    input, label {
      width: 150px;
      padding: 1.2rem;
    }
    input[type="text"] {
      background: none;
      font: inherit;
      border: none;
      border-bottom: 3px solid #FFFFFF;
    }
    input[type="text"], button {
      font: inherit;
   }
   button {
     margin-left: 1.2rem;
   }
   section {
     border: 3px solid #000000;
     border-radius: 12px;
   }
   section:nth-of-type(1) {
     align-self: end;
   }
   section:nth-last-of-type(1) {
     justify-self: end;
   }
  table a {
    color: red;
  }
  </style>
</head>
<body>
  <div class="container">
    <header>WDV341</header>
    <main>
      <div><h1>Login and Protected Page</h1></div>
      <!--Admin Section once user authenticated-->
     <?php
     //Another implementation  
     $validUser = isset($_SESSION['validUser']) ? $_SESSION['validUser'] : ""; 
     if($validUser) {
       if(isset($_SESSION['error'])) {
         echo "<p>".$_SESSION['error']."</p>";
         unset($_SESSION['error']);
       }
       if(isset($_SESSION['success'])) {
        echo "<p>".$_SESSION['success']."</p>";
        unset($_SESSION['success']);
      }
    ?>
      <section>
        <h3>Admin Console</h3>
        <div><a href="#">Add</a></div>
        <div><a href="#">List</a></div>
        <div><a href="logout.php">Logout</a></div>
      </section>
      <section>
        <table>
          <caption>Events Table</caption>
          <thead>
            <tr><th>Name</th>
            <th>Description</th>
            <th>Presenter</th>
            <th>Date</th>
            <th>Time</th>
          <th>Update</th>
        <th>Delete</th></tr>
          </thead>
          <tbody>
          <?php
          try{
            //PHP object assigned to an instance of the connection class
            $connection = new Connection();
            //open connection 
            $conn = $connection->open();
            //build query
            $sql = "SELECT * FROM wdv341_events LIMIT 5;"; 
            $conn->prepare($sql);
            $query = $conn->prepare($sql);
            $query->execute();
            //fetch query
            foreach($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
              echo '<tr>';
              echo '<td>',htmlentities($row['name']),'</td>';
              echo '<td>',htmlentities($row['description']),'</td>';
              echo '<td>',htmlentities($row['presenter']),'</td>';
              echo '<td>',htmlentities($row['date']),'</td>';
              echo '<td>',htmlentities($row['time']),'</td>';
              echo "<td><a href='updateEvent.php?eventID=".htmlentities($row['id'])."'>Update</a></td>";
              echo "<td><a href='delete-event.php?eventID=".htmlentities($row['id'])."'>Delete</a></td>";
              echo "</tr>";
            }
           
          }
          catch(PDOException $e){
            echo "Errors: " . $e->getMessage();
          } 
          ?>
          </tbody>
        </table>
      </section>
    <?php
    return;
     } //using flash messaging to send user Authenitcation error messaging
     $authMessage = isset($_SESSION['loginErrorMessage']) ? $_SESSION['loginErrorMessage'] : null;
     
     ?>
      <h2><?php echo $authMessage; ?></h2>
      <form action="login.php" method="post" id="login_form">
        <div>
        <label for="user">Username:</label>
        <input type="text" name="user" id="user" autofocus placeholder="John Smith">
        <span><?php echo htmlentities($userErrorMessage); ?></span>
        </div>
        <div>
        <label for="pswd">Password:</label>
        <input type="text" name="pswd" id="pswd">
        <span><?php echo htmlentities($pswdErrorMessage); ?></span>
        </div>
        <div>
          <button type="submit" name="login" value="login">Login</button>
        </div>
      </form>
    </main>
    <footer>WDV341</footer>
  </div>  
</body>
</html>