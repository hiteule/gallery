<script type="text/javascript">
  <!--
  function verif_cat(){
    if(document.form_img.cat.value==""){
      alert("{LANG_SELECT_CAT}");
      document.form_img.cat.focus();
      return false;
    }
  }
  //-->
</script>

<div class="navbar">
  <a href="./?p=dashboard">{LANG_DASHBOARD}</a> &raquo; <a href="./?p=img_add">{LANG_ADD_PHOTOS}</a>
</div>

<form name="form_img" method="post" action="./?p=img_add" enctype="multipart/form-data" onsubmit="return verif_cat()">
  <fieldset>
    <legend>{LANG_CAT}</legend>
    <table>
      <tr>
        <td><label id="cat">{LANG_CAT}</label> :</td>
        <td>
          <select name="cat" id="cat">
            <option value=""></option>
            <!-- CAT -->
              <option value="{id}" {selected}><!-- CAT_N -->--<!-- /CAT_N --> {name}</option>
            <!-- /CAT -->
          </select>
        </td>
      </tr>
    </table>
  </fieldset>

  <fieldset>
    <legend>{LANG_PHOTO_N1}</legend>
    <table>
      <tr><td>{LANG_NAME} :</td> <td><input type="text" name="name0" size="20" value=""/> <span class="font10">{LANG_NOT_REQUIRE}</span></td></tr>
      <tr><td>{LANG_PHOTO} :</td> <td><input name="upfile0" type="file"/></td></tr>
    </table>
  </fieldset>
  
  <fieldset>
    <legend>{LANG_PHOTO_N2}</legend>
    <table>
      <tr><td>{LANG_NAME} :</td> <td><input type="text" name="name1" size="20" value=""/> <span class="font10">{LANG_NOT_REQUIRE}</span></td></tr>
      <tr><td>{LANG_PHOTO} :</td> <td><input name="upfile1" type="file"/></td></tr>
    </table>
  </fieldset>
  
  <fieldset>
    <legend>{LANG_PHOTO_N3}</legend>
    <table>
      <tr><td>{LANG_NAME} :</td> <td><input type="text" name="name2" size="20" value=""/> <span class="font10">{LANG_NOT_REQUIRE}</span></td></tr>
      <tr><td>{LANG_PHOTO} :</td> <td><input name="upfile2" type="file"/></td></tr>
    </table>
  </fieldset>
  
  <fieldset>
    <legend>{LANG_PHOTO_N4}</legend>
    <table>
      <tr><td>{LANG_NAME} :</td> <td><input type="text" name="name3" size="20" value=""/> <span class="font10">{LANG_NOT_REQUIRE}</span></td></tr>
      <tr><td>{LANG_PHOTO} :</td> <td><input name="upfile3" type="file"/></td></tr>
    </table>
  </fieldset>

  <br />
  <div class="center">
    <input type="submit" name="submit_tn" value="{LANG_ADD_TN}"/>&nbsp;&nbsp; {LANG_OR} &nbsp;&nbsp;<input type="submit" name="submit_add" value="{LANG_ADD_OTHER}"/>
  </div>
</form>