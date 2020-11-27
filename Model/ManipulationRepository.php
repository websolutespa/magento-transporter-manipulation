<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterManipulation\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Websolute\TransporterBase\Exception\TransporterException;
use Websolute\TransporterManipulation\Api\Data\ManipulationInterface;
use Websolute\TransporterManipulation\Api\Data\ManipulationSearchResultInterface;
use Websolute\TransporterManipulation\Api\Data\ManipulationSearchResultInterfaceFactory;
use Websolute\TransporterManipulation\Api\ManipulationRepositoryInterface;
use Websolute\TransporterManipulation\Model\ManipulationModelFactory as ManipulationFactory;
use Websolute\TransporterManipulation\Model\ResourceModel\Entity\ManipulationCollectionFactory;
use Websolute\TransporterManipulation\Model\ResourceModel\ManipulationResourceModel;

class ManipulationRepository implements ManipulationRepositoryInterface
{
    /**
     * @var ManipulationFactory
     */
    private $manipulationFactory;

    /**
     * @var ManipulationCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ManipulationSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var ManipulationResourceModel
     */
    private $manipulationResourceModel;

    /**
     * @param ManipulationModelFactory $manipulationFactory
     * @param ManipulationCollectionFactory $collectionFactory
     * @param ManipulationSearchResultInterfaceFactory $manipulationSearchResultInterfaceFactory
     * @param ManipulationResourceModel $manipulationResourceModel
     */
    public function __construct(
        ManipulationFactory $manipulationFactory,
        ManipulationCollectionFactory $collectionFactory,
        ManipulationSearchResultInterfaceFactory $manipulationSearchResultInterfaceFactory,
        ManipulationResourceModel $manipulationResourceModel
    ) {
        $this->manipulationFactory = $manipulationFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $manipulationSearchResultInterfaceFactory;
        $this->manipulationResourceModel = $manipulationResourceModel;
    }

    /**
     * @param int $id
     * @return ManipulationInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ManipulationInterface
    {
        $manipulation = $this->manipulationFactory->create();
        $this->manipulationResourceModel->load($manipulation, $id);
        if (!$manipulation->getId()) {
            throw new NoSuchEntityException(__('Unable to find TransporterManipulation with ID "%1"', $id));
        }
        return $manipulation;
    }

    /**
     * @param ManipulationInterface $manipulation
     * @throws Exception
     */
    public function delete(ManipulationInterface $manipulation)
    {
        $this->manipulationResourceModel->delete($manipulation);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ManipulationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ManipulationSearchResultInterface
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param int $activityId
     * @param string $entityIdentifier
     * @param string $status
     * @throws AlreadyExistsException
     */
    public function createOrUpdate(int $activityId, string $entityIdentifier, string $status)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(ManipulationModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->addFieldToFilter(ManipulationModel::ENTITY_IDENTIFIER, ['eq' => $entityIdentifier]);
        $collection->load();

        /** @var ManipulationModel $manipulation */
        if ($collection->count()) {
            $manipulation = $collection->getFirstItem();
        } else {
            $manipulation = $this->manipulationFactory->create();
            $manipulation->setActivityId($activityId);
            $manipulation->setEntityIdentifier($entityIdentifier);
        }

        $manipulation->setStatus($status);

        $this->save($manipulation);
    }

    /**
     * @param ManipulationInterface $manipulation
     * @return ManipulationInterface
     * @throws AlreadyExistsException
     */
    public function save(ManipulationInterface $manipulation)
    {
        $this->manipulationResourceModel->save($manipulation);
        return $manipulation;
    }

    /**
     * @param int $activityId
     * @param string $entityIdentifier
     * @param string $status
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function update(int $activityId, string $entityIdentifier, string $status)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(ManipulationModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->addFieldToFilter(ManipulationModel::ENTITY_IDENTIFIER, ['eq' => $entityIdentifier]);
        $collection->load();

        if (!$collection->count()) {
            throw new NoSuchEntityException(__(
                'Non existing manipulator ~ activityId:%1 ~ entityIdentifier:%2',
                $activityId,
                $entityIdentifier
            ));
        }

        /** @var ManipulationInterface $manipulation */
        $manipulation = $collection->getFirstItem();
        $manipulation->setStatus($status);

        $this->save($manipulation);
    }

    /**
     * @param int $activityId
     * @return ManipulationInterface[]
     */
    public function getAllByActivityId(int $activityId): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(ManipulationModel::ACTIVITY_ID, ['eq' => $activityId]);
        $collection->load();

        /** @var ManipulationInterface[] $manipulations */
        $manipulations = $collection->getItems();

        return $manipulations;
    }
}
