<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
?>

<form action="<?php echo Application::$baseUrl ?>/register" method='post'>
    <table>
        <tr>
            <td>Username</td>
            <td><input type='text' name='username' required minlength='1'></td>
            <?php if($user->getFirstError("username") != "") echo "<td>". $user->getFirstError("username") ."</td>" ?>
        </tr>
        <tr>
            <td>Firstname</td>
            <td><input type='text' name='firstname'></td>
            <?php if($user->getFirstError("firstname") != "") echo "<td>". $user->getFirstError("firstname") ."</td>" ?>
        </tr>
        <tr>
            <td>Lastname</td>
            <td><input type='text' name='lastname'></td>
            <?php if($user->getFirstError("lastname") != "") echo "<td>". $user->getFirstError("lastname") ."</td>" ?>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='text' name='email' required minlength='1'></td>
            <?php if($user->getFirstError("email") != "") echo "<td>". $user->getFirstError("email") ."</td>" ?>
        </tr>
        <tr>
            <td>Date of birth</td>
            <td><input type='date' name='date_of_birth' required minlength='1'></td>
            <?php if($user->getFirstError("date_of_birth") != "") echo "<td>". $user->getFirstError("date_of_birth") ."</td>" ?>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='password' name='password' required minlength='8'></td>
            <?php if($user->getFirstError("password") != "") echo "<td>". $user->getFirstError("password") ."</td>" ?>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type='password' name='passwordConfirm' required minlength='1'></td>
            <?php if($user->getFirstError("passwordConfirm") != "") echo "<td>". $user->getFirstError("passwordConfirm") ."</td>" ?>
        </tr>
    </table>
    <input type='submit'/>
</form>