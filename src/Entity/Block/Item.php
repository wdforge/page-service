<?php

namespace PagesService\Entity\Block;

use System\Db\Repository\AbstractItem;


class EntityBlockItem extends AbstractItem
{
    public $id;
    public $title;
    public $type;
    public $source_id;
    public $section_id;
    public $parent_id;
    public $style;
    public $ts;
}