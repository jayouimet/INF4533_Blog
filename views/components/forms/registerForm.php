<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';

echo "<form action='". Application::$baseUrl ."/register' method='post'>";
echo "Username : <input type='text' name='username' required minlength='1'><br>" ;
echo "First name : <input type='text' name='firstname'><br>" ;
echo "Last name : <input type='text' name='lastname'><br>" ;
echo "<span>Email : <input type='text' name='email' required minlength='1'>" ;
if($user->getFirstError("email") != "")
    echo "<span class='error'>" . $user->getFirstError("email") . "</span>";
echo "</span><br>";
echo "Date of birth : <input type='text' name='date_of_birth' required minlength='1'><br>" ;
echo "<span>Password : <input type='password' name='password' required minlength='8'>" ;
if($user->getFirstError("password") != "")
    echo "<span class='error'>" . $user->getFirstError("password") . "</span>";
echo "</span><br>";
echo "<span>Confirm password : <input type='password' name='passwordConfirm' required minlength='1'>" ;
if($user->getFirstError("passwordConfirm") != "")
    echo "<span class='error'>" . $user->getFirstError("passwordConfirm") . "</span>";
echo "</span><br>";
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