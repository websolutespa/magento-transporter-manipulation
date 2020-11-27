<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\TransporterManipulation\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ManipulationResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('transporter_manipulation', 'manipulation_id');
    }
}
