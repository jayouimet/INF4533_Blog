<?php
echo "<form action='/INF4533_Blog/adduser' method='post'>";
echo "Username : <input type='text' name='username'><br>" ;
echo "First name : <input type='text' name='firstname'><br>" ;
echo "Last name : <input type='text' name='lastname'><br>" ;
echo "Email : <input type='text' name='email'><br>" ;
echo "Date of birth : <input type='text' name='date_of_birth'><br>" ;
echo "Password : <input type='text' name='passworld'><br>" ;
echo "<input type='submit'>";
echo "</form>";

if (isset($isInserted)) {
if ($isInserted) {
    echo "Account created successfully";
} else {
    echo "Account could not be created, try again later.";
}
}

?>