<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterManipulation\Model;

use Magento\Framework\Api\Search\SearchResult;
use Websolute\TransporterManipulation\Api\Data\ManipulationSearchResultInterface;

class ManipulationSearchResult extends SearchResult implements ManipulationSearchResultInterface
{

}
