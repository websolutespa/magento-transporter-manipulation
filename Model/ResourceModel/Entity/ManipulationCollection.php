<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterManipulation\Model\ResourceModel\Entity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Websolute\TransporterManipulation\Model\ManipulationModel;
use Websolute\TransporterManipulation\Model\ResourceModel\ManipulationResourceModel;

class ManipulationCollection extends AbstractCollection
{
    protected $_idFieldName = 'manipulation_id';
    protected $_eventPrefix = 'transporter_manipulation_collection';
    protected $_eventObject = 'manipulation_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ManipulationModel::class, ManipulationResourceModel::class);
    }
}
