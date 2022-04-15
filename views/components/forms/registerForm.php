<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
?>

<div class="register-form-container">
    <form class='register-form' action="<?php echo Application::$baseUrl ?>/register" method='post'>
        <div class="register-form-row">
            <label for="username">Username</label>
            <input type='text' name='username' required minlength='1'>
        </div>
        <?php 
            if($user->getFirstError("username") != "") 
                echo "<div class='error'>". $user->getFirstError("username") ."</div>";
            else if (isset($errors) && $errors["username"]) {
                echo "<div class='error'>". $errors["username"] ."</div>";
            }
        ?>

        <div class="register-form-row">
            <label for="firstname">Firstname</label>
            <input type='text' name='firstname'>
        </div>
        <?php 
            if ($user->getFirstError("firstname") != "") 
                echo "<div class='error'>". $user->getFirstError("firstname") ."</div>";
        ?>

        <div class="register-form-row"> 
            <label for="lastname">Lastname</label>
            <input type='text' name='lastname'>
        </div>
        <?php 
            if ($user->getFirstError("lastname") != "") 
                echo "<div class='error'>". $user->getFirstError("lastname") ."</div>"; 
        ?>

        <div class="register-form-row"> 
            <label for="email">Email</label>
            <input type='text' name='email'>
        </div>
        <?php 
            if ($user->getFirstError("email") != "") 
                echo "<div class='error'>". $user->getFirstError("email") ."</div>"; 
        ?>

        <div class="register-form-row"> 
            <label for="date_of_birth">Date of birth</label>
            <input type='date' name='date_of_birth' required minlength='1'>
        </div>
        <?php 
            if ($user->getFirstError("date_of_birth") != "") 
                echo "<div class='error'>". $user->getFirstError("date_of_birth") ."</div>"; 
        ?>

        <div class="register-form-row"> 
            <label for="password">Password</label>
            <input type='password' name='password' required minlength='8'>
        </div>
        <?php 
            if ($user->getFirstError("password") != "") 
                echo "<div class='error'>". $user->getFirstError("password") ."</div>"; 
        ?>

        <div class="register-form-row"> 
            <label for="passwordConfirm">Confirmation</label>
            <input type='password' name='passwordConfirm' required minlength='8'>
        </div>
        <?php 
            if ($user->getFirstError("passwordConfirm") != "") 
                echo "<div class='error'>". $user->getFirstError("passwordConfirm") ."</div>"; 
        ?>
        <div class="register-form-row">
            <input type='submit'/>
        </div>
        <div class="register-form-row">
            <?php
            echo "<a href='". Application::$baseUrl ."/login'>Already have an account?</a>";
            ?>
        </div>
    </form>
</div>