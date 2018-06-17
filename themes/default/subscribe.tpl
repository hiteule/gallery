<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=subscribe">{LANG_SUBSCRIBE}</a>
</div>

<!-- FORM -->
  <form method="post" action="./?p=subscribe">
    <table id="table_center">
      <tr><td>{LANG_LOGIN} :</td> <td><input type="text" name="login" value="" size="20"/></td></tr>
      <tr><td>{LANG_PASS} :</td> <td><input type="password" name="passwd" value="" size="20"/></td></tr>
      <tr><td>{LANG_PASS_CONFIRM} :</td> <td><input type="password" name="passwd_confirm" value="" size="20"/></td></tr>
      <tr><td>{LANG_MAIL_ADDR} :</td> <td><input type="text" name="mail" value="" size="20"/></td></tr>
      <tr><td>{LANG_RECOP_CODE} :<br /><img src="./gestion/captcha.php" alt=""/></td> <td><input type="text" name="code" value="" size="20"/></td></tr>
      <tr><td colspan="2" class="submit"><input type="submit" value="{LANG_SUBSCRIBE}" accesskey="s"/></td></tr>
    </table>
  </form>
<!-- /FORM -->

<!-- VALID -->
  {LANG_SUBSCRIBE_OK}<br />
<!-- /VALID -->