<?
// Classe spécifique de Smarty pour l'application locale
// permet de définir une seule fois les paramèters globaux du moteur de gestion
// de templates Smarty

require('Smarty.class.php');

class Smarty_local extends Smarty {
     
     function Smarty_local() {
     
     // Constructeur de la classe. Appelé automatiquement
     // à l'instanciation de la classe.
     
     $this->Smarty();
     
     $this->template_dir = _CONST_TEMPLATE_DIR;
     $this->compile_dir = _CONST_COMPILE_DIR;
     $this->config_dir = _CONST_CONFIG_DIR;
     $this->cache_dir = _CONST_CACHE_DIR;
     
     $this->caching = false;
     $this->assign('app_name',_CONST_APPLI_NAME);
     }
}
?>
