<?php

/*
 * This file is part of Monsieur Biz's Sylius Cms Block Plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusCmsBlockPlugin\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use MonsieurBiz\SyliusCmsBlockPlugin\Entity\BlockInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BlockRepository extends EntityRepository implements BlockRepositoryInterface
{
    public function createListQueryBuilder(string $localeCode, ?string $fallbackLocaleCode = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->leftJoin('o.translations', 'translation', 'WITH', 'translation.locale = :localeCode')
            ->setParameter('localeCode', $localeCode)
        ;
        if (null !== $fallbackLocaleCode && $fallbackLocaleCode !== $localeCode) {
            $queryBuilder
                ->addSelect('fallbackTranslation')
                ->leftJoin('o.translations', 'fallbackTranslation', 'WITH', 'fallbackTranslation.locale = :fallbackLocaleCode')
                ->setParameter('fallbackLocaleCode', $fallbackLocaleCode)
            ;
        }

        return $queryBuilder;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneEnabledByCode(string $code): ?BlockInterface
    {
        /** @phpstan-ignore-next-line */
        return $this->createQueryBuilder('b')
            ->andWhere('b.code = :code')
            ->andWhere('b.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
