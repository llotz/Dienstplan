<?
    // Load Data Dependencies
    include_once(getViewModel("main"));
?>

<h3>Übersicht</h3>
    <form method='GET' class="filter">
        <div class="filter-box">
			<!--<div class="filter-item">Nächste <?=GetHtmlSelector("interval", $intervalList, "Value", "Output", $interval, false)?> Tage</div>-->
            <div class="filter-item"><?=GetHtmlSelector("department", $departments, "Id", "Name", $departmentId, true, "Organisator")?></div>
            <div class="filter-item"><?=GetHtmlSelector("sector", $sectors, "Id", "Name", $sectorId, true, "Abteilung")?></div>
            <div class="filter-item"><input class="flex-box-button" type="submit" value="Filter Anwenden"/></div>
        </div>
    </form>
        
<?=$grid?>
