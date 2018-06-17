<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=login">{LANG_CONNECTION}</a>
</div>

<form method="post" action="./login.php">
  <table id="table_center">
    <tr><td>{LANG_LOGIN} :</td> <td colspan="2"><input type="text" name="login" size="20" value=""/></td></tr>
    <tr><td>{LANG_PASS} :</td> <td><input type="password" name="pass" size="20" value=""/></td> <td><a href="./?p=pass_lost" style="font-size:10px;">{LANG_PASS_LOST}</a></td></tr>
    <tr><td>{LANG_CONNECTIONAUTO} :</td> <td colspan="2"><input name="connec_auto" id="connec_auto" type="checkbox"/></td></tr>
    <tr><td colspan="3" class="submit"><input name="uri" value="{uri}" type="hidden"/><input type="submit" value="{LANG_CONNECTION}" accesskey="s"/></td></tr>
  </table>
</form>