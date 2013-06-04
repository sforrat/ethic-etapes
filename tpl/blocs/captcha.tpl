<label for="userCode">#{smarty_trad value='lib_entrez_code'}#</label>
<input name="userCode" id="userCode" type="text" />
<!-- Notre image créée -->
<img src="captcha.php" alt="Captcha" id="captcha" />
<!-- (JavaScript) Changer d'image à la volée si elle est illisible  -->
<a style="cursor:pointer" onclick="document.images.captcha.src='captcha.php?id='+Math.round(Math.random(0)*1000)+1"><img title="#{smarty_trad value='lib_recharge_image'}#" alt="#{smarty_trad value='lib_recharge_image'}#" src="reload.png"></a>