<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=account">{LANG_MY_ACCOUNT}</a>
</div>

<!-- OK_MAIL -->
  {LANG_MAIL_OK}<br />
<!-- /OK_MAIL -->

<!-- OK_PASS -->
  {LANG_PASS_OK}<br />
<!-- /OK_PASS -->

<!-- FORM -->
  <table id="table_center">
    <tr>
      <td>
        <fieldset id="field0">
          <legend>{LANG_CHANGE_MAIL_ADDR} :</legend>
          <form method="post" action="./?p=account">
            <table>
              <tr><td>{LANG_MAIL_ADDR} :</td> <td><input type="text" name="mail" value="{mail}" size="20"/></td></tr>
              <tr><td>{LANG_PASS} :</td> <td><input type="password" name="passwd" value="" size="20"/></td></tr>
              <tr><td colspan="2" class="submit"><input type="submit" value="{LANG_SAVE}"/></td></tr>
            </table>
          </form>
        </fieldset>
      </td>

      <td>
        <fieldset id="field1">
          <legend>{LANG_CHANGE_PASS} :</legend>
          <form method="post" action="./?p=account">
            <table>
              <tr><td>{LANG_OLD_PASS} :</td> <td><input type="password" name="passwd_old" value="" size="20"/></td></tr>
              <tr><td>{LANG_NEW_PASS} :</td> <td><input type="password" name="passwd_new0" value="" size="20"/></td></tr>
              <tr><td>{LANG_PASS_CONFIRM} :</td> <td><input type="password" name="passwd_new1" value="" size="20"/></td></tr>
              <tr><td colspan="2" class="submit"><input type="submit" value="{LANG_SAVE}"/></td></tr>
            </table>
          </form>
        </fieldset>
      </td>
    </tr>
  </table>
<!-- /FORM -->