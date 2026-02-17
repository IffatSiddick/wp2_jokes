<?php if (isset($errorMessage)) :
    echo '<div class="errors">Sorry your username and/or password could not be found.</div>'; 
endif;
?>

<form action="index.php?controller=login&action=loginsubmit" method="post">
    <label for="email">Your email</label>
    <input name="email" id="email" type="text">

    <label for="password">Your password</label>
    <input name="password" id="password" type="password">

    <input type="submit" name="login" value="Log in">
</form>

<p>Don't have an account? <a href="index.php?controller=author&amp;action=registrationform">Sign up here</a></p>