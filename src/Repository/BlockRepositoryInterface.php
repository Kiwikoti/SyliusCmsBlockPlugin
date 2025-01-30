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
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface BlockRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $localeCode, ?string $fallbackLocaleCode = null): QueryBuilder;

    /**
     * @throws NonUniqueResultException
     */
    public function findOneEnabledByCode(string $code, ?string $locale = null, ?string $fallbackLocaleCode = null): ?BlockInterface;

    /**
     * @throws NonUniqueResultException
     */
    public function findOneEnabledByIdentifier(string $identifier, ?string $locale = null, ?string $fallbackLocaleCode = null): ?BlockInterface;
}
