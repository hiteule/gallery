<div class="navbar">
  <a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=last_comm">{LANG_LAST_COMM}</a>
</div>

<form method="post" action="./?p=last_comm">
  <table>
    <tr><td><label for="sort">{LANG_SORT_BY} :</label></td> <td><label for="order">{LANG_ORDER} :</label></td> <td colspan="2"><label for="since">{LANG_SINCE} :</label></td></tr>
    <tr>
      <td><select name="sort" id="sort"><option value="date">{LANG_PUBLISH_DATE}</option><option value="name_img">{LANG_PHOTO}</option></select></td>
      <td><select name="order" id="order"><option value="DESC">{LANG_DESC}</option><option value="ASC">{LANG_ASC}</option></select></td>
      <td><select name="since" id="since"><option value="begin">{LANG_BEGIN}</option><option value="last30day">{LANG_LAST30DAY}</option><option value="last7day">{LANG_LAST7DAY}</option><option value="today">{LANG_TODAY}</option></select></td>
      <td><input type="submit" value="{LANG_FILTER}" accesskey="s"/></td>
    </tr>
  </table>
</form>
<br /><br />

<table id="last_comm">
  <tr><td colspan="2"></td></tr>
  <!-- COMM -->
    <tr>
      <td class="td_img"><a href="./?p=img&amp;id={id_img}#img"><img src="{tn_link}" alt="{name_img}" title="{name_img}"/></a></td>
      <td class="td_comm"><fieldset><legend>{LANG_BY} {name_comm} {LANG_THE} {date_date} {LANG_AT} {date_hour} :</legend>{comment}</fieldset></td>
    </tr>
  <!-- /COMM -->
</table>

<table id="page">
  <tr>
    <td class="back"><!-- PAGE_BACK_NOK --> <!-- /PAGE_BACK_NOK --> <!-- PAGE_BACK --><a href="./?p=last_comm&amp;page={page}">{LANG_PAGE_BACK}</a><!-- /PAGE_BACK --></td>
    <td class="roll"><!-- PAGEROLL --><!-- PAGE_CUR --><span class="cur">{page}</span><!-- /PAGE_CUR --><!-- PAGE --><span class="no_cur"><a href="./?p=last_comm&amp;page={page}">{page}</a></span><!-- /PAGE --><!-- /PAGEROLL --></td>
    <td class="next"><!-- PAGE_NEXT_NOK --> <!-- /PAGE_NEXT_NOK --> <!-- PAGE_NEXT --><a href="./?p=last_comm&amp;page={page}">{LANG_PAGE_NEXT}</a><!-- /PAGE_NEXT --></td>
  </tr>
</table>