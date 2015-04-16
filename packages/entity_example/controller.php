<?php
namespace Concrete\Package\EntityExample;

use \Concrete\Core\Backup\ContentImporter;

class Controller extends \Concrete\Core\Package\Package
{
    protected $pkgHandle = 'entity_example';
    protected $appVersionRequired = '5.7.3';
    protected $pkgVersion = '0.0.1';

    public function getPackageDescription()
    {
        return t('A package contains example entity with doctrine orm.');
    }

    public function getPackageName()
    {
        return t('Entity Example');
    }

    public function install()
    {
        $pkg = parent::install();

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/config/install.xml');
    }
}
