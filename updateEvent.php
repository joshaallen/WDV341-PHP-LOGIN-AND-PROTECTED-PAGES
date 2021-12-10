<?php 
    //start session
    session_start();
    //Database Connection
    require_once("connection.php");
    //set Data Model
    $eventID = $_GET['eventID'];

    //Are you valid user
   if(!isset($_SESSION['validUser'])) {
      //redirect
      header("Location: login.php");
      return;
    }   
    //Honey Pot Check
   elseif(isset($_POST['update']) && !empty($_POST['eventInfo'])) {
       /**storing ip address of visitor. will need away to transport the data with ip adddress
         **/
       $ip = getenv("REMOTE_ADDR");
        
      //redirect
     header("Location: form-handler-homework-honeyPot.php?ip=" . $ip);
     return;
    }
    //form submission
    elseif(isset($_POST['update'])) {
      //Model
      $eventTime = $_POST['eventTime'];
      $eventDate = $_POST['eventDate'];
      $eventPresenter = $_POST['eventPresenter'];
      $eventDescription = $_POST['eventDescription'];
      $eventName = $_POST['eventName'];
      $eventID = $_POST['eventID'];
    try{
      
      ini_set('log_errors',1);
      ini_set('error_log','php_error_log.txt');
     
          //pdo object instansion
          $connection = new Connection();
          //open connection
          $conn = $connection->open();
          //build query
          $sql = "UPDATE wdv341_events SET name=:eventName, description=:eventDescription, presenter=:eventPresenter, date=:eventDate, time=:eventTime WHERE id=:eventID";
          //prepare query
          $query = $conn->prepare($sql);
          //bind query
          $query->bindparam(':eventID', $eventID);
          $query->bindparam(':eventName', $eventName);
          $query->bindparam(':eventDescription', $eventDescription);  
          $query->bindparam(':eventPresenter', $eventPresenter);
          $query->bindparam(':eventDate', $eventDate);
          $query->bindparam(':eventTime', $eventTime);
          //execute query
          $query->execute();
          //capturing the number of row that were inserted
          $count = $query->rowCount();
          //capture id of last row inserted
          $lastInsertID = $conn->lastInsertId();
          //close connection
          $conn = $connection->close();  
        if($count>0) {
             //FLASH Success message
            $_SESSION['success'] = "Record update succesfully";
          } 
           
          else {
           //FLASH Error message
            $_SESSION['error'] = "Update Unsuccessful. Record not found";
          } 
          //redirect
           header("Location: login.php");
           return;   
         }
      catch(PDOException $e) {
        echo "Error message: " . $e->getmessage();
      }
    return;
    }
    else {
      try {

        ini_set('log_errors',1);
        ini_set('error_log','php_error_log.txt'); 
        
            //pdo object creation
          $connection = new Connection();
          //open connection
          $conn = $connection->open();
          //create query
          $sql = "SELECT * FROM wdv341_events WHERE id=:eventID";
          //pepare query
          $query = $conn->prepare($sql);
          //bind value
          $query->bindparam(':eventID', $eventID);
          //excecute
          $query->execute();
          //fetch results
          $row = $query->fetch(PDO::FETCH_ASSOC);
          //validate return value for success
       if($row===false) {
        $_SESSION['error'] = "Invalid Event ID";
             //close connection
             $conn = $connection->close();  
            //redirect
         header("Location: login.php");
        return; 
        } 
        }
        catch(PDOException $e) {
          "Error message: " . $e->getMessage();
        } 
   
    


  ?>  
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="This is PHP page that will perform SQL UPDATE and INSERT to modify existing date">
  <meta name="author" content="Joshua Allen">
  <meta name="keywords" content="Session,PHP,Admin,Login,SQL UPDATE,Logout">
  <title>Event Update</title>
</head>
<body>
  <div class="container">
    <section>
      <?php echo "<h1>EVENT " . $eventID. " found</h1>"; ?>
    <form action="updateEvent.php" method="post" id="update_form">
      <fieldset>
        <legend>Event</legend>
      <!--Honey Pot-->
      <div style="display:none;" id="eventInfo">
        <label for="eventInfo">Event Info: </label>
        <input type="text" name="eventInfo" id="eventInfo" size=25 autocomplete="off">
      </div>
      <!--end of Honey Pot-->
      <div>
      <label for="eventName">Name:</label>
      <input type="text" name="eventName" id="eventName" value="<?php echo htmlentities($row['name']); ?>" required autocomplete="off">
      <input type="hidden" name="eventID" value="<?php echo htmlentities($row['id']); ?>">
      </div>
      <div>
      <label for="eventDescription">Description:</label>
      <input type="text" name="eventDescription" id="eventDescription" value="<?php echo htmlentities($row['description']); ?>" required autocomplete="off">
      </div>
      <div>
      <label for="eventPresenter">Presenter:</label>
      <input type="text" name="eventPresenter" id="eventPresenter" value="<?php echo htmlentities($row['presenter']); ?>" required autocomplete="off">
      </div>
      <div>
      <label for="eventDate">Date:</label>
      <input type="date" name="eventDate" id="eventDate" required value="<?php echo htmlentities($row['date']); ?>">
      </div>      
      <div>
      <label for="eventTime">Time:</label>
      <input type="time" name="eventTime" id="eventTime" step="2" required value="<?php echo htmlentities($row['time']); ?>">
      </div>     
      <input type="submit" name="update" value="Update">
      <a href="login.php">Cancel</a>
      </fieldset>
     </form>
    </section>
  </div>
</body>
<!--Javascript-->
<script>
  document.getElementById("eventInfo").style.display= "none";
<script>
</html>
<?php 
 }
?>