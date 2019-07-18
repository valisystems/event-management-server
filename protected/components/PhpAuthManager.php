<?php
class PhpAuthManager extends CPhpAuthManager{
    public function init(){
        // Hierarchy of roles located in auth.php file in the config app
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('application.config.auth').'.php';
        }
 
        parent::init();
 
        // For guests we have, and so the role of the default guest.
        if(!Yii::app()->user->isGuest){
            // Associate role defined in the database with the user ID
            // return UserIdentity.getId().
            $this->assign(Yii::app()->user->role, Yii::app()->user->id_user);
        }
    }
}
?>