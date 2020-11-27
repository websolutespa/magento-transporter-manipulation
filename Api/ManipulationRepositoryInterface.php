<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterManipulation\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Websolute\TransporterManipulation\Api\Data\ManipulationInterface;
use Websolute\TransporterManipulation\Api\Data\ManipulationSearchResultInterface;

interface ManipulationRepositoryInterface
{
    /**
     * @param int $id
     * @return ManipulationInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ManipulationInterface;

    /**
     * @param ManipulationInterface $manipulation
     * @return ManipulationInterface
     */
    public function save(ManipulationInterface $manipulation);

    /**
     * @param ManipulationInterface $manipulation
     * @return void
     */
    public function delete(ManipulationInterface $manipulation);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ManipulationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ManipulationSearchResultInterface;

    /**
     * @param int $activityId
     * @param string $entityIdentifier
     * @param string $status
     */
    public function createOrUpdate(int $activityId, string $entityIdentifier, string $status);

    /**
     * @param int $activityId
     * @param string $entityIdentifier
     * @param string $status
     * @throw NoSuchEntityException
     */
    public function update(int $activityId, string $entityIdentifier, string $status);

    /**
     * @param int $activityId
     * @return ManipulationInterface[]
     */
    public function getAllByActivityId(int $activityId): array;
}
