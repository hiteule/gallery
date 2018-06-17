<script type="text/javascript" src="./static/js/main.js"></script>
<script type="text/javascript">
  <!--
  document.onkeydown=keyboardNavigation;
  -->
</script>

<div class="navbar">
  <table>
    <tr>
      <td><a href="./index.php">{LANG_HOME}</a> &raquo; <a href="./?p=cat">{LANG_CAT_LIST}</a> &raquo; <!-- NAVBAR_CAT --><a href="./?p=cat&amp;id={id}">{name}</a> &raquo;&nbsp;<!-- /NAVBAR_CAT -->{name_img}</td>
      <td class="right">{num_img}/{nb_img}</td>
    </tr>
  </table>
</div>

<div class="center" id="img">
  <a href="./?p=cat&amp;id={id_cat}&amp;page={page}"><img src="{img_url}" alt="{LANG_RETURN_CAT}" title="{LANG_RETURN_CAT}"/></a>
</div>

<table id="description">
  <tr>
    <td rowspan="5" class="back">
      <!-- IMG_BACK -->
        <script type="text/javascript">
          var backURL= "./?p=img&id={id}#img";
        </script>
        <a href="./?p=img&amp;id={id}#img"><img src="{tn_link}" alt="{name}" title="{name}"/></a>
      <!-- /IMG_BACK -->
      <!-- IMG_BACK_NOK -->{LANG_YOU_ARE_ON_FIRST_IMG}<!-- /IMG_BACK_NOK -->
    </td>
    <td>{name_img}<br /><br /></td>
    <td rowspan="5" class="next">
      <!-- IMG_NEXT -->
        <script type="text/javascript">
          var nextURL= "./?p=img&id={id}#img";
        </script>
        <a href="./?p=img&amp;id={id}#img"><img src="{tn_link}" alt="{name}" title="{name}"/></a>
      <!-- /IMG_NEXT -->
      <!-- IMG_NEXT_NOK -->{LANG_YOU_ARE_ON_LAST_IMG}<!-- /IMG_NEXT_NOK -->
    </td>
  </tr>

  <tr><td>{width} * {height}</td></tr>
  <tr><td>{size}</td></tr>
  <tr><td>{LANG_ADD_THE} {add_date} {LANG_AT} {add_hour}</td></tr>
  <tr><td>{nb_view} {LANG_VISIT}</td></tr>
</table>

<!-- COMM_OK -->
  <span id="comm" class="comment_title">{nb_comm} {LANG_COMMENT_OF_GUEST}</span><br />
  <div class="comment">
    <!-- COMM -->
      <fieldset>
        <legend>{LANG_BY} {name} {LANG_THE} {date_date} {LANG_AT} {date_hour} :</legend>
        {comment}
      </fieldset>
    <!-- /COMM -->
  </div>
<!-- /COMM_OK -->

<!-- COMM_NOK -->
  <span class="comment_title">{LANG_NO_COMMENT}</span><br />
  <div class="comment">
  </div>
<!-- /COMM_NOK -->

<br /><br />
<!-- COMM_ADD -->
  <span class="comment_title">{LANG_ADD_COMMENT}</span><br />
  <div class="comment">
    <form method="post" action="./?p=img&amp;id={id_img}">
      <div>
        {LANG_NAME} : <!-- NAME_INPUT --><input type="text" size="20" name="name" value=""/><!-- /NAME_INPUT --><!-- NAME -->{name}<!-- /NAME --><br />
        {LANG_COMMENT} :<br />
        <textarea name="comment" cols="70" rows="4"></textarea><br />
        <input type="submit" value="{LANG_SEND}" accesskey="s"/><br />
      </div>
    </form>
  </div>
<!-- /COMM_ADD -->
