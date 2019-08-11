<?
    include_once(getViewModel("usersettings"));
?>

<p>Passwort ändern</p>
<form method="POST">
    <p>Aktuelles Passwort:</p>
    <p><input name="oldpw" type="password"></p>
    <p>Neues Passwort:</p>
    <p><input name="newpw" type="password"></p>
    <p>Passwort wiederholen:</p>
    <p><input name="repeatpw" type="password"></p><br>
    <input type="submit" value="Ändern">
</form>