<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=cat">{LANG_CATS}</a>
</div>

<!-- LIST -->
  <table id="table">
    <tr><th>{LANG_NAME}</th> <th class="nb_img">{LANG_NB_PHOTO}</th> <th class="edit">{LANG_EDIT}</th> <th>{LANG_DEL}</th></tr>
    <!-- CAT -->
      <tr><td><!-- CAT_N --><span class="dash">--</span><!-- /CAT_N --> {name}</td> <td class="nb_img">{nb_img}</td> <td class="edit"><a href="./?p=cat&amp;id={id}"><img src="./themes/default/img/folder_edit.png" alt="{LANG_EDIT}" title="{LANG_EDIT}"/></a></td> <td class="del"><a href="./?p=cat&amp;del={id}"><img src="./themes/default/img/cancel.png" alt="{LANG_DEL}" title="{LANG_DEL}"/></a></td></tr>
    <!-- /CAT -->
  </table>
<!-- /LIST -->

<!-- FORM -->
  <form method="post" action="./?p=cat">
  <table>
    <tr><td>{LANG_NAME} :</td> <td><input type="text" name="name" value="{name}" size="20"/> <input type="hidden" name="id_edit" value="{id}"/></td></tr>
    <tr><td>{LANG_DESC} :</td> <td><textarea name="description" rows="3" cols="40">{description}</textarea></td></tr>
    <tr><td colspan="2" class="center"><input type="submit" value="{LANG_SAVE}"/></td></tr>
  </table>
<!-- /FORM -->