<?
    include_once(getViewModel("login"));
?>

<form method=post>
    e-mail:<br>
    <input type="text" name="email"><br>
    password:<br>
    <input type="password" name="password"><br>
    <br>
    <input type="submit" value="Login"><br><br>
    <a href="<?=getHtmlLink('register')?>">Registrieren</a><br>
    <a href="<?=getHtmlLink('main')?>">zurück zur Startseite</a>
</form>