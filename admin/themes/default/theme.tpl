<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=theme">{LANG_THEMES}</a>
</div>

<form method="post" action="./?p=theme">
  <table id="table_theme">
    <tr><th>{LANG_NAME}</th> <th>{LANG_PREVIEW}</th> <th>{LANG_VERSION}</th> <th>{LANG_AUTHOR}</th> <th></th></tr>
    <!-- THEME -->
      <tr><td>{name}</td> <td><img src="../themes/{dir}/{preview}" alt="{name}"/></td> <td>{version}</td> <td>{author}</td> <td><input type="radio" name="dir_theme" value="{dir}" {checked}/></td></tr>
    <!-- /THEME -->
    <tr><td colspan="5" class="submit"><input type="submit" value="{LANG_SAVE}"/></td></tr>
  </table>
</form>