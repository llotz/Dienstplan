<?php
include_once(getViewModel("pwgen"));

?>

<form method=post>
    password:<br>
    <input type="text" size="80" value="<?=$password?>" name="password" autocomplete="off"><br>
    <br>
    hash:<br>
    <input type="text" size="80" value="<?=$pwHash?>"><br>
    <br>
    <input type="submit" value="Get Hash"><br><br>
</form>