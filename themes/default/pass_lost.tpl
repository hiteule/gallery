<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=login">{LANG_CONNECTION}</a> &raquo; <a href="./?p=pass_lost">{LANG_PASS_LOST}</a>
</div>

<!-- FORM -->
  {LANG_PASS_LOST0}<br />
  {LANG_PASS_LOST1}<br />
  <br />

  <form method="post" action="./?p=pass_lost">
    <table id="table_center">
      <tr><td>{LANG_LOGIN} :</td> <td><input type="text" name="login" value="" size="20"/></td></tr>
      <tr><td>{LANG_MAIL_ADDR} :</td> <td><input type="text" name="mail" value="" size="20"/></td></tr>
      <tr><td>{LANG_RECOP_CODE} :<br /><img src="./gestion/captcha.php" alt=""/></td> <td><input type="text" name="code" value="" size="20"/></td></tr>
      <tr><td colspan="2" class="submit"><input type="submit" value="{LANG_GET_PASSWD}"/></td></tr>
    </table>
  </form>
<!-- /FORM -->

<!-- VALID -->
  {LANG_PASS_LOST_OK}<br />
<!-- /VALID -->