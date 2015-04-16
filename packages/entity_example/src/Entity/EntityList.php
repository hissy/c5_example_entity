<?php
namespace Concrete\Package\EntityExample\Src\Entity;

use Concrete\Core\Search\ItemList\Database\ItemList;
use Concrete\Core\Search\Pagination\Pagination;
use Pagerfanta\Adapter\DoctrineDbalAdapter;

class EntityList extends ItemList
{
    /**
     * Create base query
     */
    public function createQuery()
    {
        $this->query->select('ee.eID')
            ->from('ExampleEntities', 'ee');
    }

    /**
     * Returns the total results in this list.
     * @return int
     */
    public function getTotalResults()
    {
        $query = $this->deliverQueryObject();
        return $query->select('count(ee.eID)')
            ->setMaxResults(1)
            ->execute()
            ->fetchColumn();
    }

    /**
     * Gets the pagination object for the query.
     * @return Pagination
     */
    protected function createPaginationObject()
    {
        $adapter = new DoctrineDbalAdapter($this->deliverQueryObject(), function ($query) {
            $query->select('count(ee.eID)')->setMaxResults(1);
        });
        $pagination = new Pagination($this, $adapter);
        return $pagination;
    }

    /**
     * Object mapping
     *
     * @param $queryRow
     * @return \Concrete\Package\EntityExample\Src\Entity\Entity
     */
    public function getResult($queryRow)
    {
        $ai = Entity::getByID($queryRow['eID']);
        return $ai;
    }

    /**
     * Filter by keywords
     *
     * @param $keywords
     */
    public function filterByKeywords($keywords)
    {
        $this->query->andWhere(
            $this->query->expr()->andX(
                $this->query->expr()->like('ee.name', ':keywords')
            )
        );
        $this->query->setParameter('keywords', '%' . $keywords . '%');
    }
}