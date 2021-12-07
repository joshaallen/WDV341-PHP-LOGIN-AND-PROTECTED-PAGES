<?php 
//session start
session_start();

include('connection.php');

//set Data Model
$eventID = $_GET['eventID'];

//Not a valid user
print_r($_SESSION["valid"]);
var_dump($_SESSION["valid"]);
 if(isset($_SESSION["valid"])) {
  header("Location: login.php");
  return;
}  
//checking to see if post array contains delete and row id keys
if(isset($_POST['delete'])) {
  //
  try{
    
    $connection = new Connection();
    $conn = $connection->open();
     $sql = "DELETE FROM wdv341_events WHERE id=:eventID;";
     $conn->prepare($sql);
     $query = $conn->prepare($sql);
     $query->bindparam(':eventID', $eventID, PDO::PARAM_INT);  
     $query->execute();
     //Success or Error Flash Message
     if ($query->execute()) {
      echo 'eventID ' . $eventID . ' was deleted successfully.';
      $_SESSION['success'] = "Record deleted";
    }
     //Close Connection
     /* $conn->close();  */
     //Redirect
     header("Location: login.php");
      return; 
  }
  catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
   }
}
try{
  $connection = new Connection();
  $conn = $connection->open();
  $sql = "SELECT * FROM wdv341_events WHERE id=:eventID;";
  $conn->prepare($sql);
  $query = $conn->prepare($sql);
  $query->bindparam(':eventID', $eventID);
  //execute query
  $query->execute();
  /**fetch results
   * Note**
   *  Key diff between fetchAll() and fetch() is fetchAll returnd each record as a index array whose values are assoiciate arrays with the column names and keys and the values as values while fetch returns an associative array for each record making indexing with $row['value'] possible
   * */
  $row = $query->fetch(PDO::FETCH_ASSOC);
  if($row===false) {
    $_SESSION['error'] = "Invalid Event ID";
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
          <input type="submit" name="delete" value="delete" id="delete">
          <a href="login.php">Cancel</a>
        </form>
      </div>
    </section>
  </div>
</body>

</html>