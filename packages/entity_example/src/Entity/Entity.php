<?php
namespace Concrete\Package\EntityExample\Src\Entity;

use Database;

/**
 * @Entity
 * @Table(name="ExampleEntities")
 */
class Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $eID;

    /**
     * @Column(type="string")
     */
    protected $name;

    public function getID()
    {
        return $this->eID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public static function getByID($eID)
    {
        $em = Database::get()->getEntityManager();
        return $em->getRepository('\Concrete\Package\EntityExample\Src\Entity\Entity')
            ->find($eID);
    }

    public function save()
    {
        $em = Database::get()->getEntityManager();
        $em->persist($this);
        $em->flush();
    }

    public function delete()
    {
        $em = Database::get()->getEntityManager();
        $em->remove($this);
        $em->flush();
    }
}
