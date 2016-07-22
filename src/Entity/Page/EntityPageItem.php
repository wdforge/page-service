<?php

namespace PagesService\Entity\Page;

use System\Db\Repository\AbstractItem;


class EntityPageItem extends AbstractItem
{
    public $id;
    public $title;
    public $header;
    public $type;
    public $url;
    public $parent_id;
    public $ts;
}