<?php
include_once(getViewModel('import'));
?>
<h3>Import</h3>
<p class="page-link"><a href="/import_example">[Download: Import Vorlage]</a></p>
<form method="POST" enctype="multipart/form-data">
	<div class="input-field">
		<div class="input-description">Plan für</div> 
		<div class="input-value"><?=GetHtmlSelector("department", $departments, "Id", "Name", $departmentId)?></div>
	</div>
	<div class="input-field">
		<div class="input-description">Abteilung</div> 
		<div class="input-value"><?=GetHtmlSelector("sector", $sectors, "Id", "Name", $sectorId)?></div>
	</div>
	Wähle eine Datei aus: 
	<div class="input-field">
		<input type="file" name="importFile" value="importFile" id="importFile"/>
		<input type="submit" value="Datei hochladen!" />
	</div>
</form>