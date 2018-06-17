<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=cat_add">{LANG_ADD_CATS}</a>
</div>

<!-- OK -->
  {LANG_CAT_ADDED}<br />
<!-- /OK -->

<!-- FORM -->
  <form method="post" action="./?p=cat_add">
    <table>
      <tr>
        <td><label for="cat">{LANG_PARENT_CAT}</label> :</td>
        <td>
          <select name="cat" id="cat">
            <option value=""></option>
            <!-- CAT -->
              <option value="{id}"><!-- CAT_N -->--<!-- /CAT_N --> {name}</option>
            <!-- /CAT -->
          </select>
        </td>
      </tr>
      <tr><td>{LANG_NAME} :</td> <td><input type="text" name="name" size="20" value=""/></td></tr>
      <tr><td>{LANG_DESC} :</td> <td><textarea name="description" rows="3" cols="40">{description}</textarea></td></tr>
      <tr><td colspan="2" class="submit"><input type="submit" value="{LANG_SAVE}"/></td></tr>
    </table>
  </form>
<!-- /FORM -->