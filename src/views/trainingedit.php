<?php
include_once(getViewModel("trainingedit"));

?>
<h3><?=$titleText?></h3>
<div class="InputForm">
    <form action="" method="POST" <?=(($showPageContent)?"":"style='visibility: hidden'");?>">
        <input type="hidden" name="id" value="<?=$id?>" size=5>

        <div class="input-field">
          <div class="input-description">Organisator</div> 
          <div class="input-value"><?=GetHtmlSelector("department", $departments, "Id", "Name", $departmentId)?></div>
        </div>
        <div class="input-field">
          <div class="input-description">Ort</div> 
          <div class="input-value"><?=GetHtmlSelector("city", $cities, "Id", "Name", $cityId)?></div>
        </div>
        <!--<div class="input-field">
          <div class="input-description">Kategorie</div> 
          <div class="input-value"><?=GetHtmlSelector("category", $categories, "Id", "Description", $categoryId)?></div>
        </div>-->
        <input type="hidden" name="category" value="1" size=5>

        <div class="input-field">
          <div class="input-description">Abteilung</div> 
          <div class="input-value"><?=GetHtmlSelector("sector", $sectors, "Id", "Name", $sectorId)?></div>
        </div>
        <div class="input-field">
          <div class="input-description">Ereignis</div> 
          <div class="input-value"><input type="checkbox" name="isEvent" <?=((!$isNew && $training["IsEvent"] === 1)?"checked":"")?>></div>
        </div>
        <div class="input-field">
          <div class="input-description">Datum</div> 
          <div class="input-value"><input type="date" name="startdate" value="<?=date('Y-m-d',$start)?>"></div>
        </div>
        <div class="input-field">
            von  <input type="time" name="starttime" value="<?=date('H:i', $start)?>" size=5>
            bis <input type="time" name="endtime" value="<?=date('H:i',$end)?>" size=5></div>

          <!--<p>Von: <input type="date" name="startdate" value="<?=date('Y-m-d',$start)?>">
              <input type="text" name="starttime" value="<?=date('H:i', $start)?>" size=5>Uhr</p>
          <p>Bis: <input type="date" name="enddate" value="<?=date('Y-m-d',$end)?>">
              <input type="text" name="endtime" value="<?=date('H:i',$end)?>" size=5>Uhr</p>-->
          <!--<p>Art: <?=GetHtmlSelector($trainingTypes, "Id", "Name", $trainingTypeId)?>-->
          <!--<p>Thema/Beschreibung:<br><input type="text" name="desctiption" size="50" value="<?=$description?>"></p>-->
        <p>Thema<br><textarea rows="2" cols="30" name="topic" placeholder="Kurz und knackig"><?=$description?></textarea></p>
        <p>Beschreibung<br><textarea rows="4" cols="30" name="description" placeholder="Eine kurze Beschreibung der Inhalte (kann leer bleiben)"><?=$comment?></textarea></p>
        <p><input onClick="window.history.go(-1); return false;" type="button" value="Zurück">
			<?if($id != "" && $id != 0){?><a href="/training/<?=$id?>"><input type="button" value="Ansicht"></a><?}?>
        <input type="submit" name="<?=$saveButtonName?>" value="<?=$saveButtonText?>"></p><br>
        <?
            if($deleteButtonVisible)
            {?>
                <input type="submit" name="delete" value="Löschen!!" onclick="return confirm('Sicher, dass du den Dienst löschen willst?')"/>
            <?}
        ?>
    </form>
</div>