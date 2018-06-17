<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; {LANG_CAT_LIST}<br />
</div>

<table id="cat0">
  <tr>
    <!-- CAT -->
      <td>
        <table class="cat1">
          <tr><td colspan="2" class="title"><a href="./?p=cat&amp;id={id}">{name}</a></td></tr>
          <tr>
            <td><a href="./?p=cat&amp;id={id}"><img src="{tn_link}" alt="{name}"/></a></td>
            <td class="description">
              {description}<br />
              <br />
              <span class="nb_img_souscat">{nb_img} {LANG_IMG} - {nb_souscat} {LANG_SOUSCAT}</span><br />
            </td>
          </tr>
        </table>
      </td>
      <!-- LINE --></tr><tr><!-- /LINE -->
    <!-- /CAT -->
    <!-- EMPTY_CAT --><td></td><!-- /EMPTY_CAT -->
    <!-- NO_CAT --><td>{LANG_NO_CAT}</td><!-- /NO_CAT -->
  </tr>
</table>