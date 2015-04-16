<?php
namespace  Concrete\Package\EntityExample\Controller\SinglePage\Dashboard\Entities;

use Concrete\Package\EntityExample\Src\Entity\Entity;
use Concrete\Package\EntityExample\Src\Entity\EntityList;
use Request;

class Search extends \Concrete\Core\Page\Controller\DashboardPageController
{
    public function view()
    {
        $list = new EntityList();

        $r = Request::getInstance();
        if ($r->query->has('keywords') && $r->query->get('keywords') != '') {
            $list->filterByKeywords($r->query->get('keywords'));
        }

        $pagination = $list->getPagination();
        $entries = $pagination->getCurrentPageResults();

        $this->set('list', $list);
        $this->set('pagination', $pagination);
        $this->set('entries', $entries);
    }

    public function add()
    {
        $this->set('pageTitle', t('Add Entity'));
    }

    public function edit($id = 0)
    {
        $e = Entity::getByID($id);
        $this->set('eID',  $e->getID());
        $this->set('name', $e->getName());
        $this->set('pageTitle', t('Edit %s', h($e->getName())));
    }

    public function saved()
    {
        $this->set('message', t('Entity information saved successfully.'));
        $this->view();
    }

    public function deleted()
    {
        $this->set('message', t('Entity information deleted successfully.'));
        $this->view();
    }

    public function submit()
    {
        if (!$this->token->validate('submit')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->post('name')) {
            $this->error->add(t('You must specify a name for this entity.'));
        }

        if (!$this->error->has() && $this->isPost()) {
            if ($this->post('eID')) {
                $e = Entity::getByID($this->post('eID'));
            } else {
                $e = new Entity();
            }
            $e->setName($this->post('name'));
            $e->save();

            $this->redirect('/dashboard/entities/search', 'saved');
        }

        if ($this->post('eID')) {
            $this->edit($this->post('eID'));
        } else {
            $this->add();
        }
    }

    public function delete()
    {
        if (!$this->token->validate('delete')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has() && $this->isPost()) {
            $e = Entity::getByID($this->post('eID'));
            if (is_object($e)) {
                $e->delete();
            }

            $this->redirect('/dashboard/entities/search', 'deleted');
        }
        $this->view();
    }
}
