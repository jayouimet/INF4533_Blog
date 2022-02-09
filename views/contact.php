<?php
  if(isset($_SESSION["test"])) {
    var_dump($_SESSION["test"]);
  }
?>

<h1>Contact us</h1>

<form method="post" action="">
  <label for="fname">First name:</label>
  <input type="text" id="fname" name="fname"><br><br>
  <label for="lname">Last name:</label>
  <input type="text" id="lname" name="lname"><br><br>
  <input type="submit" value="Submit">
</form>