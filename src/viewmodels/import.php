<?php
include_once("includes/importMassData.php");


if($_FILES['importFile']['tmp_name'] != ""){
	$importMassData = new ImportMassData($_FILES['importFile']['tmp_name']);
	$importStructures=$importMassData->GetContentAsImportStructure();
	// TODO create array of training, handle $_POST[departmentid]
	// push array to database after sanitizing inputs
	// fix warning on import page
	print_r($importStructures);
}

?>