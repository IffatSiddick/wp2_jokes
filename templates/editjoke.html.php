<form action="" method="post">
    <input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
    <label for='joketext'>Type your joke here;</label>
    <textarea name="joke[joketext]" rows="3" cols="40"><?=htmlspecialchars($joke['joketext']?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
    <input type="submit" value="Save">
</form>
