<?php
    require_once dirname(__FILE__) . '/../../../../src/Application.php';
    require dirname(__FILE__) . '/../../../components/common/navbar.php';
?>

<div class="content-container">
    <div class="content-header-container">
        <h1><?php echo $user->username ?></h1>
    </div>
    <div class="information-container">
        <form>
            <div class="label-input-container">
                <label for="email">Email</label>
                <input id="emailInput" name="email" type="text" value="<?php echo $user->email ?>" />
            </div>
            <div class="label-input-container">
                <label for="firstname">First name</label>
                <input id="firstNameInput" name="firstname" type="text" value="<?php echo $user->firstname ?>" />
            </div>
            <div class="label-input-container">
                <label for="lastname">Last name</label>
                <input id="lastNameInput" name="lastname" type="text" value="<?php echo $user->lastname ?>" />
            </div>
            <div class="label-input-container">
                <label for="status_message">Status message</label>
                <input id="statusMessageInput" name="status_message" type="text" value="<?php echo $user->status_message ?>" />
            </div>
            <div class="button-container">
                <button id="updateButton" onclick="updateProfile(event)">Update profile</button>
            </div>
        </form>
    </div>
    <div class="followage-container">

    </div>
    <div class="user-posts-container">

    </div>
    <div class="liked-posts-container">

    </div>
</div>