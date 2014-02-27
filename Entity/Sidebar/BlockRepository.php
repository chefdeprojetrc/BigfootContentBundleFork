<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar;

use Doctrine\ORM\EntityRepository;

/**
 * BlockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlockRepository extends EntityRepository
{
    public function findOneBySidebarBlock($sidebar, $block)
    {
        return $this
            ->createQueryBuilder('b')
            ->where('b.sidebar = :sidebar')
            ->andWhere('b.block = :block')
            ->setParameter('sidebar', $sidebar)
            ->setParameter('block', $block)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
