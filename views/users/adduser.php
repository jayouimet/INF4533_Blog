<?php
echo "<form action='/INF4533_Blog/register' method='post'>";
echo "Username : <input type='text' name='username' required minlength='1'><br>" ;
echo "First name : <input type='text' name='firstname'><br>" ;
echo "Last name : <input type='text' name='lastname'><br>" ;
echo "Email : <input type='text' name='email' required minlength='1'><br>" ;
echo "Date of birth : <input type='text' name='date_of_birth' required minlength='1'><br>" ;
echo "Password : <input type='text' name='password' required minlength='8'><br>" ;
echo "Confirm password : <input type='text' name='passwordConfirm' required minlength='1'><br>" ;
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