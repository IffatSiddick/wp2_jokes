<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="jokes.css">
        <title><?=$title?></title>
    </head>
    <body>
        <header><h1>Internet Joke Database</h1></header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?controller=joke&amp;action=list">Jokes List</a></li>
                <li><a href="index.php?controller=joke&amp;action=edit">Add a new joke</a></li>
                <li><a href="index.php?controller=author&amp;action=registrationform">Register</a></li>
                <?php if ($loggedin): ?>
                    <li><a href="index.php?controller=login&amp;action=logout">Log out</a></li>
                <?php else: ?>
                    <li><a href="index.php?controller=login&amp;action=login">Log in</a></li>
                <?php endif;?>
                </ul>
        </nav>
        <main>
            <?=$output?>
        </main>
    </body>
</html>