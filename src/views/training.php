<?php
include_once(getViewModel("training"));
?>
<!--<h3><?=$trainingType?></h3>-->

<p class=tall><?=$training["Thema"]?></p>

<p><b><?=$training["Beginn"];?></b></p>
<p><?=$training["Sector"]?> 
<?=$training["Department"]?> </p>
<p>Standort: <?=$training["City"]?></p>
<p>Erwartete Dauer: <?=$training["Duration"]?></p><br>
<?if($training["Comment"] != ""){?>
	<p><?=$training["Comment"]?></p>
	<br>
<?}?>
<p><a href="/appointment/<?=$trainingId?>" style = "font-size: xx-large;">📅</a></p>
<tt>(Klicken, um deinem Kalender hinzuzufügen)</tt>
<br><br>
<?=$menu;?>