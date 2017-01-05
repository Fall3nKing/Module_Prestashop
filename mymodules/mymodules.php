<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class mymodules extends Module
{
  public function __construct()
  {
    $this->name = 'mymodules'; // Cet attribut sert d'identifiant interne, donc faites en sorte qu'il soit unique, sans caractères spéciaux ni espaces, et gardez-le en minuscule. Dans les faits, la valeur DOIT être le nom du dossier du module.
    $this->tab = 'front_office_features'; // Cet attribut donne l'identifiant de la section de la liste des modules du back-office de PrestaShop où devra se trouver ce module. Vous pouvez utiliser un nom existant, tel que seo, front_office_features ou analytics_stats, ou un identifiant personnalisé.
    $this->version = '1.0.0'; // numero de version du module
    $this->author = 'Benoit RICHARD'; // nom de l'auteur
    $this->need_instance = 0; // indique s'il faut charger la classe du module quand celui-ci est affiché dans la page "Modules" du back-office. S'il est à 0, le module n'est pas chargé, et il utilisera donc moins de ressources. Si votre module doit afficher un avertissement dans la page "Modules", alors vous devez passer ce drapeau à 1.
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); //Il permet d'indiquer clairement les versions de PrestaShop avec lesquelles le module est compatible. Dans l'exemple ci-dessus, nous indiquons explicitement que ce module ne fonctionnera qu'a partir de la version 1.6
    $this->bootstrap = true; // permet d'utiliser du bootstrap

    parent::__construct();

    $this->displayName = $this->l('Mon premier module'); // Nom du module dans le back Office
    $this->description = $this->l('Test de module'); // Mescription du module

    $this->confirmUninstall = $this->l('Êtes-vous sûr de vouloir désinstaller ?'); // phrase de désinstallation

    if (!Configuration::get('MYMODULE_NAME')) //un avertissement que le module n'a pas défini sa variable MYMODULE_NAME
      $this->warning = $this->l('No name provided');
  }
    public function install()
    {
        if (Shop::isFeatureActive()) //cette ligne teste simplement si la fonctionnalité multiboutique est activée ou non
        Shop::setContext(Shop::CONTEXT_ALL); // cette ligne modifie le contexte pour appliquer les changements qui suivent à toutes les boutiques existantes plus qu'à la seule boutique actuellement utilisée.

        return parent::install() && //vérifier que le module est installé.
        $this->registerHook('leftColumn') && //lier le module au hook leftColumn.
        $this->registerHook('header') && //lier le module au hook header.
        Configuration::updateValue('MYMODULE_NAME', 'my friend'); //créer la variable de configuration MYMODULE_NAME, en lui donnant la valeur "my friend".
    }

    public function uninstall()
    {
        return parent::uninstall() && Configuration::deleteByName('MYMODULE_NAME'); // supprime aussi la variable créer.
    }

}
