<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=user">{LANG_USERS}</a>
</div>

<!-- LIST -->
  <table id="table_user">
    <tr><th>{LANG_NAME}</th> <th>{LANG_STATUT}</th> <th>{LANG_EDIT}</th></tr>
    <!-- USER_LIST -->
      <!-- BAN --><tr class="ban"><td>{login}</td> <td>{LANG_BANNED}</td> <td><a href="./?p=user&amp;id={id}"><img src="./themes/default/img/page_edit.png" alt="{LANG_EDIT}" title="{LANG_EDIT}"/></a></td></tr><!-- /BAN -->
      <!-- ADMIN --><tr class="admin"><td>{login}</td> <td>{LANG_ADMIN}</td> <td><a href="./?p=user&amp;id={id}"><img src="./themes/default/img/page_edit.png" alt="{LANG_EDIT}" title="{LANG_EDIT}"/></a></td></tr><!-- /ADMIN -->
      <!-- USER --><tr><td>{login}</td> <td>{LANG_USER}</td> <td><a href="./?p=user&amp;id={id}"><img src="./themes/default/img/page_edit.png" alt="{LANG_EDIT}" title="{LANG_EDIT}"/></a></td></tr><!-- /USER -->
    <!-- /USER_LIST -->
  </table>
<!-- /LIST -->

<!-- FORM -->
  <table>
    <tr>
      <td>
        <fieldset>
          <legend>{LANG_INFOS_PERSO}</legend>
          <form method="post" action="./?p=user">
            <table>
              <tr><td>{LANG_LOGIN} :</td> <td><input type="text" name="login" value="{login}" size="20"/></td></tr>
              <tr><td>{LANG_MAILADDR} :</td> <td><input type="text" name="mailaddr" value="{mail}" size="20"/></td></tr>
              <tr>
                <td><label for="statut">{LANG_STATUT}</label> :</td>
                <td>
                  <select name="statut" id="statut">
                    <option value="user" {selected_user}>{LANG_USER}</option>
                    <option value="admin" {selected_admin}>{LANG_ADMIN}</option>
                    <option value="ban" {selected_ban}>{LANG_BANNED}</option>
                  </select>
                </td>
              </tr>
              <tr><td colspan="2" class="submit"><input type="hidden" name="id_edit" value="{id}"/><input type="submit" value="{LANG_SAVE}"/></td></tr>
            </table>
          </form>
        </fieldset>
      </td>

      <td>
        <fieldset>
          <legend>{LANG_CHANGE_PASS}</legend>
          <form method="post" action="./?p=user">
            <table>
              <tr><td>{LANG_PASS} :</td> <td><input type="password" name="pass0" value="" size="20"/></td></tr>
              <tr><td>{LANG_PASS_CONFIRM} :</td> <td><input type="password" name="pass1" value="" size="20"/></td></tr>
              <tr><td colspan="2" class="submit"><input type="hidden" name="id_edit" value="{id}"/><input type="submit" value="{LANG_SAVE}"/></td></tr>
            </table>
          </form>
        </fieldset>
      </td>
    </tr>
  </table>
<!-- /FORM -->