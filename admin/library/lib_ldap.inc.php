<?
// +--------------------------------------------------------------------------+
// | Back-Office - 09/01/2003                                                 |
// +--------------------------------------------------------------------------+
// | Copyright (c) 2002-2003 FullSud Team                                     |
// +--------------------------------------------------------------------------+
// | License:  Contact Fullsud : contact@fullsud.com                          |
// +--------------------------------------------------------------------------+
// | Library fo ldap information                                              |
// |                                                                          |
// | usage:                                                                   |
// |                                                                          |
// | example:                                                                 |
// |                                                                          |
// | required: - PHP                                                          |
// |           - MySQL                                                        |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Author:   Yoann CULAS <yculas@fullsud.com>                               |
// +--------------------------------------------------------------------------+



// +--------------------------------------------------------------------------+
// |                                                                          |
// |         Fonction qui verifie l'authentification sur l'annuaire ldap      |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters : ldap_udi, ldap_userpassword                                 |
// +--------------------------------------------------------------------------+
// | Date : 09/01/2003                                                        |
// +--------------------------------------------------------------------------+
function ldap_check_user($uid,$password) {

  $ds=@ldap_connect(_CONST_LDAP_HOST);  // Doit être un serveur LDAP valide!

    if ($ds) {
      $r=@ldap_bind($ds);     // Ceci est un lien "anonymous", typiquement
                           // en lecture seule. En cas d'accès, affiche
                           // " Lien résultat est"

    $sr=@ldap_search($ds,_CONST_LDAP_FILTER, "uid=".$uid);
    $info = @ldap_get_entries($ds, $sr);

    for ($i=0; $i<$info["count"]; $i++) {
		$grain_de_sel=ereg_replace("{crypt}","",ldap_get_user_info($uid, "userpassword"));

		if (strcmp(crypt($password,$grain_de_sel),ereg_replace("{crypt}","",ldap_get_user_info($uid, "userpassword")))==0) {
			return true;
		}
		else {
			return false;
		}
    }
    ldap_close($ds);
  }
  else {
    echo "<br>Impossible de se connecter à un serveur LDAP.";
  }
}


// +--------------------------------------------------------------------------+
// |                                                                          |
// |         Fonction qui retourne la valeur d'une clef                       |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters : ldap_udi, ldap_attrib                                       |
// +--------------------------------------------------------------------------+
// | Date : 09/01/2003                                                        |
// +--------------------------------------------------------------------------+
function ldap_get_user_info($uid, $attrib) {
  $ds=ldap_connect(_CONST_LDAP_HOST);  // Doit être un serveur LDAP valide!

  if ($ds) {
    $r=ldap_bind($ds);     // Ceci est un lien "anonymous", typiquement
                           // en lecture seule. En cas d'accès, affiche
                           // " Lien résultat est"

    $sr=ldap_search($ds,_CONST_LDAP_FILTER, "uid=".$uid);
    $info = ldap_get_entries($ds, $sr);

    for ($i=0; $i<$info["count"]; $i++) {
		$value = $info[$i][$attrib];
		return($value[0]);
    }

    ldap_close($ds);
  }
  else {
    echo "<br>Impossible de se connecter à un serveur LDAP.";
  }

}
?>