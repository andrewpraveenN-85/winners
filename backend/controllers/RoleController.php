<?php

namespace backend\controllers;

use yii\rbac\Item;
use backend\controllers\ItemController;

class RoleController extends ItemController {

    /**
     * @var int
     */
    protected $type = Item::TYPE_ROLE;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Role',
        'Items' => 'Roles',
    ];
}
