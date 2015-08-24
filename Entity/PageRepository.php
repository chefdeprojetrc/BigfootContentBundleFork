<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    /**
     * @param $slug
     * @return Page|null
     */
    public function findOneByTranslated($params)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
            ->andWhere('p.slug = :slug')
            ->setParameters($params)
            ->setMaxResults(1);

        $query = $queryBuilder->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $results = $query->getResult();

        return $results ? $results[0] : null;
    }

    /**
     * Find page translated by unique id
     *
     * @param  array|string $ids
     * @param  string $locale
     *
     * @return array
     */
    public function findTranslatedByUniqueId($ids, $locale = null)
    {
        $query = $this
            ->createQueryBuilder('e')
            ->andWhere('e.uniqueId IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        if ($locale) {
            $query
                ->setHint(
                    \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
                    $locale
                );
        }

        return $query->getResult();
    }
}
