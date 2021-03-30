<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See LICENSE and/or COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterManipulation\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ManipulationSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return ManipulationInterface[]
     */
    public function getItems();

    /**
     * @param ManipulationInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
