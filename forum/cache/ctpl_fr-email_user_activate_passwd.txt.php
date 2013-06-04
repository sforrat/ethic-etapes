<?php if (!defined('IN_PHPBB')) exit; ?>Subject: Activation du nouveau mot de passe

Bonjour <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>

Vous recevez cet e-mail parce que vous avez (ou quelqu'un qui prétend être vous) demandé à ce qu'un nouveau mot de passe vous soit envoyé pour votre compte sur "<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>". Si vous n'avez pas demandé cet e-mail, vous pouvez l'ignorer. Si vous continuez à le recevoir, contactez l'administrateur du forum.

Pour utiliser le nouveau mot de passe, vous avez besoin de l'activer. Pour ce faire, cliquez sur le lien fourni ci-dessous.

<?php echo (isset($this->_rootref['U_ACTIVATE'])) ? $this->_rootref['U_ACTIVATE'] : ''; ?>

Si cela réussit, vous pourrez vous connecter avec le mot de passe suivant:

Mot de passe: <?php echo (isset($this->_rootref['PASSWORD'])) ? $this->_rootref['PASSWORD'] : ''; ?>

Vous pouvez bien sûr changer vous-même ce mot de passe via votre profil. Si vous rencontrez des difficultés, contactez l'administrateur du forum.

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>