<?
// Load Data Dependencies
include_once(getViewModel("main"));
?>

<h3>Übersicht</h3>
<div class="main-filter">
    <form method='GET' class="filter">
        <div class="filter-box">
            <!--<div class="filter-item">Nächste <?= GetHtmlSelector("interval", $intervalList, "Value", "Output", $interval, false) ?> Tage</div>-->
            <div class="filter-item"><?= GetHtmlSelector("department", $departments, "Id", "Name", $departmentId, true, "Organisator") ?></div>
            <div class="filter-item"><?= GetHtmlSelector("sector", $sectors, "Id", "Name", $sectorId, true, "Abteilung") ?></div>
            <div class="filter-item"><input class="flex-box-button" type="submit" value="Filter anwenden" /></div>

            <? if ($departmentId != 0 || $sectorId != 0) { ?>
                <div class="delete-filter"></div>
                <a href="/">
                    <div class="filter-item"><button class="button-red" type="button">Filter löschen</button></div>
                </a>
            <? } ?>
        </div>
    </form>
</div>


<?= $grid ?>