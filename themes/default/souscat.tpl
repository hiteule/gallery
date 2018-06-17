<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=cat">{LANG_CAT_LIST}</a><!-- NAVBAR_CAT --> &raquo; <a href="./?p=cat&amp;id={id}">{name}</a><!-- /NAVBAR_CAT -->
</div>

<!-- CATOK -->
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
    </tr>
  </table>
  <br />
<!-- /CATOK -->

<table id="img0">
  <tr>
    <!-- IMG -->
      <td>
        <table class="img1">
          <tr><td class="img"><a href="./?p=img&amp;id={id_img}#img"><img src="{tn_link}" alt="{name}" title="{name}"/></a></td></tr>
          <tr><td class="name"><a href="./?p=img&amp;id={id_img}#img">{name}</a></td></tr>
        </table>
      </td>
      <!-- LINE --></tr><tr><!-- /LINE -->
    <!-- /IMG -->
    <!-- EMPTY_IMG --><td></td><!-- /EMPTY_IMG -->
  </tr>
</table>
<br />

<table id="page">
  <tr>
    <td class="back"><!-- PAGE_BACK_NOK --> <!-- /PAGE_BACK_NOK --> <!-- PAGE_BACK --><a href="./?p=cat&amp;id={id}&amp;page={page}">{LANG_PAGE_BACK}</a><br /><!-- /PAGE_BACK --></td>
    <td class="roll"><!-- PAGEROLL --><!-- PAGE_CUR --><span class="cur">{page}</span><!-- /PAGE_CUR --><!-- PAGE --><span class="no_cur"><a href="./?p=cat&amp;id={id}&amp;page={page}">{page}</a></span><!-- /PAGE --><!-- /PAGEROLL --></td>
    <td class="next"><!-- PAGE_NEXT_NOK --> <!-- /PAGE_NEXT_NOK --> <!-- PAGE_NEXT --><a href="./?p=cat&amp;id={id}&amp;page={page}">{LANG_PAGE_NEXT}</a><br /><!-- /PAGE_NEXT --></td>
  </tr>
</table>