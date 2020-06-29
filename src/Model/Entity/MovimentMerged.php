<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

class MovimentMerged extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
