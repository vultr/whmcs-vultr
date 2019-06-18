<?php

namespace MGModule\vultr\models\testGroup\simpleItem;
use MGModule\vultr as main;

/**
 * Description of repository
 *
 * @author Michal Czech <michael@modulesgarden.com>
 */
class Repository extends \MGModule\vultr\mgLibs\models\Repository{
    public function getModelClass() {
        return __NAMESPACE__.'\SimpleItem';
    }
}
