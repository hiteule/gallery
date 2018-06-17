<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=comments">{LANG_COMMENTS}</a>
</div>

<form method="post" action="./?p=comments">
  <table id="table">
    <tr><th></th> <th>{LANG_COMMENT}</th> <th>{LANG_AUTHOR}</th> <th>{LANG_PHOTO}</th> <th>{LANG_DATE}</th></tr>
    <!-- COMMENT -->
    <tr>
      <td><input type="checkbox" name="comm[{id_comm}]" id="comm[{id_comm}]"/></td>
      <td><label for="comm[{id_comm}]">{content}</label></td>
      <td class="center"><a href="./?p=comments&amp;author={auteur}">{auteur}</a></td>
      <td class="center"><a href="../?p=img&amp;id={id_img}#comm">{name}</a></td>
      <td class="center">{date_date} {LANG_AT} {date_hour}</td>
    </tr>
    <!-- /COMMENT -->
  </table>
  <div class="center"><input type="submit" value="{LANG_DEL_SELECT_COMM}"/></div>
</form>

<table id="page">
  <tr>
    <td class="back"><!-- PAGE_BACK_NOK --> <!-- /PAGE_BACK_NOK --> <!-- PAGE_BACK --><a href="./?p=comments&amp;author={author}&amp;page={page}">{LANG_PAGE_BACK}</a><!-- /PAGE_BACK --></td>
    <td class="roll"><!-- PAGEROLL --><!-- PAGE --><a href="./?p=comments&amp;author={author}&amp;page={page}">{page}</a> <!-- /PAGE --><!-- PAGE_CUR --><strong>{page}</strong> <!-- /PAGE_CUR --><!-- /PAGEROLL --></td>
    <td class="next"><!-- PAGE_NEXT_NOK --> <!-- /PAGE_NEXT_NOK --> <!-- PAGE_NEXT --><a href="./?p=comments&amp;author={author}&amp;page={page}">{LANG_PAGE_NEXT}</a><!-- /PAGE_NEXT --></td>
  </tr>
</table>