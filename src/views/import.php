<?php
include_once(getViewModel('import'));
?>
<h3>Import</h3>
<p class="page-link"><a href="/import_example">[Download: Import Vorlage]</a></p>
<form method="POST" enctype="multipart/form-data">
	Wähle eine Datei aus: 
	<input type="file" name="importFile" value="importFile" id="importFile"/>
	<input type="submit" value="Datei hochladen!" />
</form>