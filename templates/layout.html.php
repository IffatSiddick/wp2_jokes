<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="jokes.css">
        <title><?=$title?></title>
    </head>
    <body>
        <header><h1>Internet Joke Database week 9 end</h1></header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?action=list">Jokes List</a></li>
                <li><a href="index.php?action=edit">Add a new joke</a></li>
            </ul>
        </nav>
        <main>
            <?=$output?>
        </main>
    </body>
</html>