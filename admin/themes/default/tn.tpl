<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=tn">{LANG_THUMBNAILS}</a>
</div>

<!-- TN_LOST -->
  {LANG_TN0} {nb_tn} {LANG_TN1} :<br />
  <form method="post" action="./?p=tn">
    <ul>
    <!-- TN -->
      <li>{name_cat} &raquo; {name_img} <input type="hidden" name="list[]" value="{id_img}"/></li>
    <!-- /TN -->
    </ul>
    <div class="center"><input type="submit" value="{LANG_TN2}"/></div>
  </form>
  
<!-- /TN_LOST -->

<!-- TN_NOLOST -->
  {LANG_TN3}<br />
<!-- /TN_NOLOST -->