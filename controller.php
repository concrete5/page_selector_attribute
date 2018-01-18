<?php
namespace Concrete\Package\PageSelectorAttribute;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\TypeFactory;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends \Concrete\Core\Package\Package
{

    protected $pkgHandle = 'page_selector_attribute';
    protected $appVersionRequired = '8.0.0b1';
    protected $pkgVersion = '2.0.2';

    public function getPackageDescription()
    {
        return t("Attribute that allows the selection of pages.");
    }

    public function getPackageName()
    {
        return t("Page Selector Attribute");
    }

    public function install()
    {
        $pkg = parent::install();
        /**
         * @var $factory TypeFactory
         */
        $factory = $this->app->make(TypeFactory::class);
        $type = $factory->add('page_selector', t('Page Selector'), $pkg);
        $category = Category::getByHandle('collection')->getController();
        $category->associateAttributeKeyType($type);
    }


}