<?php 
//session start
session_start();
require('connection.php');
//set Data Model


//Not a valid user
 if(!isset($_SESSION["validUser"])) {
  header("Location: login.php");
  return;
}    
//Honey Pot Validation
elseif(isset($_POST['delete']) && !empty($_POST['comments'])) {
       /**storing ip address of visitor. will need away to transport the data with ip adddress
         **/
        $ip = getenv("REMOTE_ADDR");
        header("Location: form-handler-homework-honeyPot.php?ip=" . $ip);
    return;
}
//checking to see if post array contains delete and row id keys
elseif(isset($_POST['delete'])) {
  
  try{
    
    ini_set('log_errors',1);
    ini_set('error_log','php_error_log.txt');
    
    $eventID = $_POST['eventID'];
    $connection = new Connection();
    $conn = $connection->open();

     $sql = "DELETE FROM wdv341_events WHERE id=:eventID"; 
     $query = $conn->prepare($sql);
     $query->bindparam(':eventID',$eventID); 
     $query->execute();
     echo "<h1>Number of rows deleted: ". $query->rowCount(). "</h1>";
     //Success or Error Flash Message
     if ($query->execute()) {
      $_SESSION['success'] = "Record deleted";
    }
    else {
      $_SESSION['error'] = "Record Not deleted";
    }    
       
     //close connection
    $conn = $connection->close();
    //Redirect 
     header("Location: login.php");
      return;
    
  }
  catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
   }
}//On page load with successful validation block
try{
  
  ini_set('log_errors',1);
  ini_set('error_log','php_error_log.txt');
 
  $connection = new Connection();
  $conn = $connection->open();
  $sql = "SELECT * FROM wdv341_events WHERE id=:eventID;";
  $conn->prepare($sql);
  $query = $conn->prepare($sql);
  $query->bindparam(':eventID', $_GET['eventID']);
  //execute query
  $query->execute();
  /**fetch results
   * Note**
   *  Key diff between fetchAll() and fetch() is fetchAll returnd each record as a index array whose values are assoiciate arrays with the column names and keys and the values as values while fetch returns an associative array for each record making indexing with $row['value'] possible
   * */
  $row = $query->fetch(PDO::FETCH_ASSOC);
  if($row===false) {
    $_SESSION['error'] = "Invalid Event ID";
    //close connection
    $conn = $connection->close(); 
     //redirect
     header("Location: login.php");
     return; 
  }  
}
catch(PDOException $exception) {
  echo "Error-Message: ". $exception->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Delete</title>
</head>
<body>
  <div class="container">
    <section>
      <div><h3>Are Your Sure your Want to Delete Event: <?php echo htmlentities($row['name']); ?>?</h3></div>
      <div>
        <form action="delete-event.php" method="post" id="delete_form">
          <input type="hidden" name="eventID" value="<?php echo htmlentities($row['id']); ?>">
          <!--Honey Pot-->
          <label for="comments" display="none"></label>
          <input type="text" name="comments" id="comments" display="none" autocomplete="off" style="border-bottom:none;">
          <!--end of Honey Pot-->
          <input type="submit" name="delete" value="delete" id="delete">
          <a href="login.php">Cancel</a>
        </form>
      </div>
    </section>
  </div>
</body>
<!--Javascrpt-->  
<script>
     document.getElementById("comments").style.display='none';
</script> 
</html>