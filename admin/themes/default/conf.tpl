<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=conf">{LANG_CONFIG}</a>
</div>

<form method="post" action="./?p=conf"  enctype="multipart/form-data">
  <table id="table">
    <tr><td><label for="open">{LANG_OPEN_GAL}</label> :</td> <td><select name="open" id="open"><option value="1" {selected_open_open}>{LANG_OPEN}</option><option value="0" {selected_open_close}>{LANG_CLOSE}</option></select></td></tr>
    <tr><td><label for="lang">{LANG_LANGUAGE}</label> :</td> <td><select name="language_new" id="language_new"><!-- LANG --><option value="{value}" {selected}>{name}</option><!-- /LANG --></select></td></tr>
    <tr><td>{LANG_TITLE} :</td> <td><input type="text" name="title" value="{title}" size="40"/></td></tr>
    <tr><td>{LANG_DESC} :</td> <td><input type="text" name="description" value="{description}" size="40"/></td></tr>
    <tr><td>{LANG_NB_CAT_PER_LINE} :</td> <td><input type="text" name="cat_per_line" value="{cat_per_line}" size="2"/></td></tr>
    <tr><td>{LANG_PHOTO_PER_LINE} :</td> <td><input type="text" name="img_per_line" value="{img_per_line}" size="2"/></td></tr>
    <tr><td>{LANG_LINE_PER_PAGE} :</td> <td><input type="text" name="line_per_page" value="{line_per_page}" size="2"/></td></tr>
    <tr><td>{LANG_FORM_DATE} :</td> <td><input type="text" name="form_date" value="{form_date}" size="8"/></td></tr>
    <tr><td>{LANG_FORM_HOUR} :</td> <td><input type="text" name="form_hour" value="{form_hour}" size="8"/></td></tr>
    <tr><td>{LANG_TIMEZONE} :</td> <td><input type="text" name="timezone" value="{timezone}" size="20"/></td></tr>
    <tr><td><label for="comm_open">{LANG_COMM_OPEN}</label> :</td> <td><select name="comm_open" id="comm_open"><option value="1" {selected_comm_open_open}>{LANG_OPEN}</option><option value="0" {selected_comm_open_close}>{LANG_CLOSE}</option></select></td></tr>
    <tr><td><label for="comm_invit">{LANG_COMM_OPEN_INVIT}</label> :</td> <td><select name="comm_invit" id="comm_invit"><option value="1" {selected_comm_invit_open}>{LANG_OPEN}</option><option value="0" {selected_comm_invit_close}>{LANG_CLOSE}</option></select></td></tr>
    <tr><td><label for="sort_img">{LANG_PHOTO_SORT}</label> :</td> <td><select name="sort_img" id="sort_img"><option value="date_add" {selected_sort_img_date_add}>{LANG_DATE_ADD_ESC}</option><option value="date_add DESC" {selected_sort_img_date_add_desc}>{LANG_DATE_ADD_DESC}</option><option value="name" {selected_sort_img_name}>{LANG_NAME_ESC}</option><option value="name DESC" {selected_sort_img_name_desc}>{LANG_NAME_DESC}</option><option value="nb_view" {selected_sort_img_nb_view}>{LANG_NB_VIEW_ESC}</option><option value="nb_view DESC" {selected_sort_img_nb_view_desc}>{LANG_NB_VIEW_DESC}</option></select></td></tr>
    <tr><td><label for="watermark">{LANG_WATERMARK_PHOTO}</label> :</td> <td><select name="watermark" id="watermark"><option value="1" {selected_watermark_yes}>{LANG_YES}</option><option value="0" {selected_watermark_no}>{LANG_NO}</option></select> &nbsp; {LANG_IMG} : <input type="file" name="upfile"/></td></tr>
    <tr><td>{LANG_CONTACT_NAME} :</td> <td><input type="text" name="contact_nom" value="{contact_nom}" size="20"/></td></tr>
    <tr><td>{LANG_CONTACT_MAIL} :</td> <td><input type="text" name="contact_mail" value="{contact_mail}" size="20"/></td></tr>
    <tr><td>{LANG_NB_LAST_COMM_PER_PAGE} :</td> <td><input type="text" name="number_last_comm" value="{number_last_comm}" size="2"/></td></tr>
    <tr><td>{LANG_NB_VIEW_PHOTO} :</td> <td><input type="text" name="number_most_viewed" value="{number_most_viewed}" size="2"/></td></tr>
    <tr><td colspan="2" class="submit"><input type="submit" value="{LANG_SAVE}"/></td></tr>
  </table>
</form>