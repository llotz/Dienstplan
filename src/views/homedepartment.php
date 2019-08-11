<?
  include_once(getViewModel("homedepartment"));
?>

<h3>Heimatwehr ändern</h3>
<p>Wird automatisch beim Planen von Diensten vorausgewählt. Nützlich, wenn du mehrere Feuerwehren verwaltest</p>
<br>
<form method="POST">
  <?=GetHtmlSelector("department", $departments, "Id", "Name", $departmentId)?> <br><br>
  <input type="submit" value="Übernehmen">
</form>