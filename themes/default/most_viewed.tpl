<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=most_viewed">{LANG_MOST_VIEWED}</a>
</div>

<form method="post" action="./?p=most_viewed">
  <table>
    <tr><td colspan="2"><label for="cat">{LANG_CAT} :</label></td></tr>
    <tr>
      <td><select id="cat" name="cat"><option value="all">{LANG_ALL}</option><!-- CAT --><option value="{id}">{name}</option><!-- /CAT --></select></td>
      <td><input type="submit" value="{LANG_FILTER}" accesskey="s"/></td>
    </tr>
  </table>
</form>

<table id="img0">
  <tr>
    <!-- IMG -->
      <td>
        <table class="img1">
          <tr><td class="img"><a href="./?p=img&amp;id={id_img}#img"><img src="{tn_link}" alt="{name} - {nb_view} {LANG_VISIT}" title="{name} - {nb_view} {LANG_VISIT}"/></a></td></tr>
          <tr><td class="name"><a href="./?p=img&amp;id={id_img}#img">{name} - {nb_view} {LANG_VISIT}</a></td></tr>
        </table>
      </td>
      <!-- LINE --></tr><tr><!-- /LINE -->
    <!-- /IMG -->
    <!-- EMPTY_IMG --><td></td><!-- /EMPTY_IMG -->
  </tr>
</table>