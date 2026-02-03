<form action="index.php?controller=author&action=regformsubmit" method="post">
    <label for="name">Your name</label>
    <input name="author[name]" id="name" type="text">

    <label for="email">Your email</label>
    <input name="author[email]" id="email" type="text">

    <label for="password">Your password</label>
    <input name="author[password]" id="password" type="password">

    <input type="submit" name="submit" value="Register account">
</form>