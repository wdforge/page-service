<?php
namespace PagesService\Entity\Section;

use System\Db\Repository\AbstractItem;


class EntitySectionItem extends AbstractItem 
{
    public $id;
    public $name;
    public $type;
    public $block_count;
    public $ts;
}