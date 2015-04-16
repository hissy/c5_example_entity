<?php
namespace Concrete\Package\EntityExample\Controller\SinglePage\Dashboard;

class Entities extends \Concrete\Core\Page\Controller\DashboardPageController
{
    public function view()
    {
        $this->redirect('/dashboard/entities/search');
    }
}