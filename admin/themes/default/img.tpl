<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=img">{LANG_PHOTOS}</a>
</div>

<!-- LIST -->
  {LANG_IMG0}<br />
  <br />

  <table id="table">
    <tr><th>{LANG_NAME}</th> <th class="nb_img">{LANG_NB_PHOTO}</th></tr>
    <!-- CAT -->
      <tr><td><!-- CAT_N --><span class="dash">--</span><!-- /CAT_N --> <a href="./?p=img&amp;id={id}">{name}</a></td> <td class="nb_img">{nb_img}</td></tr>
    <!-- /CAT -->
  </table>
<!-- /LIST -->

<!-- FORM -->
  <form method="post" action="./?p=img">
    <table id="table_img">
      <tr>
      <!-- IMG -->
        <!-- IMG_LINE -->
          </tr><tr>
        <!-- /IMG_LINE -->
        <td>
            <a href="../?p=img&amp;id={id}"><img src="{tn_url}" alt="{name}"/></a><br />
            <input type="checkbox" name="img_check[{id}]"/> <input type="text" name="img_name[{id}]" value="{name}" size="20"/>
        </td>
      <!-- /IMG -->
      <!-- IMG_EMPTY --><td class="empty"></td><!-- /IMG_EMPTY -->
      </tr>
      <tr>
        <td colspan="{img_per_line}" class="transfert_cat">
          <input type="radio" name="transfert_del" value="transfert" id="transfert"/>
          <label for="transfert">{LANG_IMG1}</label> :
          <select name="transfert_cat">
            <option name="none">{LANG_CHOOSE_CAT}</option>
            <!-- CAT -->
              <option value="{id}"><!-- CAT_N -->--<!-- /CAT_N --> {name}</option>
            <!-- /CAT -->
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="{img_per_line}" class="del_img">
          <input type="radio" name="transfert_del" value="del" id="del"/>
          <label for="del">{LANG_IMG2}</label>
        </td>
      </tr>
      <tr><td colspan="{img_per_line}" class="submit"><input type="hidden" name="cur_cat" value="{id_cat}"/><input type="submit" value="{LANG_SAVE}"/></td></tr>
  </table>
  </form>
<!-- /FORM -->