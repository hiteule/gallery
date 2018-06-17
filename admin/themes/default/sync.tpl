<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=sync">{LANG_SYNC}</a>
</div>

<!-- FORM -->
  {LANG_SYNC0}<br />
  <br />
  {LANG_SYNC1}<br />
  <br />
  <form method="post" action="./?p=sync&amp;sync">
    <div class="center">
      <input type="submit" value="{LANG_SYNC_ELEMENT}"/>
    </div>
  </form>
<!-- /FORM -->

<!-- RESULT -->
  {LANG_SYNC_OK}<br />
  <ul id="result">
    <li style="background-image: url(./themes/default/img/folder_delete.png);">{del_cat} {LANG_SYNC2}</li>
    <li style="background-image: url(./themes/default/img/image_delete.png);">{del_img} {LANG_SYNC3}</li>
    <li style="background-image: url(./themes/default/img/folder_add.png);">{add_cat} {LANG_SYNC4}</li>
    <li style="background-image: url(./themes/default/img/image_add.png);">{add_img} {LANG_SYNC5}</li>
  </ul>
  
  <!-- GO_TN -->
    {LANG_SYNC6}<br />
    <br />
    <form method="post" action="./?p=tn">
    <div class="center">
      <input type="submit" value="{LANG_TN2}"/>
    </div>
  </form>
  <!-- /GO_TN -->
<!-- /RESULT -->