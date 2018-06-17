<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=maintenance">{LANG_MAINTENANCE}</a>
</div>

<!-- OPTIMIZE_OK -->
  <div id="success">{LANG_MAINTENANCE2}</div>
<!-- /OPTIMIZE_OK -->

<h4>{LANG_MAINTENANCE0}</h4>

<form method="post" action="./?p=maintenance&amp;optimize">
  <div>
    <input type="submit" value="{LANG_MAINTENANCE1}"/>
  </div>
</form>
<br /><br />

<h4>{LANG_MAINTENANCE3}</h4>
<form method="post" action="./gestion/export_db.php">
  <div>
    <input type="submit" value="{LANG_MAINTENANCE4}">
  </div>
</form>