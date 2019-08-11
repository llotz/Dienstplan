<?
    include_once(getViewModel("menu"));
?>

<div class="nav">
  <label for="toggle">&#9776;</label>
  <input type="checkbox" id=toggle>
  <div class="menu">
    <ul>
        <?
            for($i=0; $i<count($menuLinks); $i++)
            {
        ?>
            <li><a href="<?=$menuLinks[$i][1]?>"><?=strtoupper($menuLinks[$i][0])?></a></li>
        <?
            }
        ?>
    </ul>
  </div>
</div>