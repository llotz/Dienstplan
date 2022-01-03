<?php
include_once(getViewModel("calendar"));
?>
<h3>Kalender</h3>

<form class="top-page-filter-form" method="GET">
	Monat
	<select name="month">
		<?= $monthOptionsArray ?>
	</select>
	<input type=submit value=Anzeigen></input>
</form>

<?= $calendar ?>

<p class="cal-legend">D - Dienst / E - Ereignis</p>