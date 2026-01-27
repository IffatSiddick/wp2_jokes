<p><?=$totalJokes?> jokes have been submitted to Matt's Internet Joke Database</p>
<?php
foreach($jokes as $joke): ?>
        <blockquote>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES,'UTF-8')?>

        (by <a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8' );?>">
        <?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8'); ?></a> on <?=$joke['jokedate'];?>)

        <a href="editjoke.php?action=edit&id=<?=$joke['id']?>">Edit</a>

        <form action="deletejoke.php?action=delete" method="post">
                <input type="hidden" name="id" value="<?=$joke['id']?>">
                <input type="submit" value="Delete">
        </form>
        </blockquote>
        <?php endforeach;?>

        