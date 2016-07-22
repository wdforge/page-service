<?php

/**
 * 
 * @package    Pages - Sections
 * @author     Dolgii Yurii <wdforge@gmail.com>
 */

/**
 * Формирование и передача запросов в виде массивов 
 * на метод выбоки findAll
 */
namespace PagesService\Sections;

use System\Db\Repository\DbZendRepository;
use System\Repository\AbstractRepository;

class SectionsRepository extends DbZendRepository {

    function __construct() {
        // тип данных элемента по умолчанию
        $this->setEntityClass('EntitySectionItem');
    }

    public function findAll($params = [
        'table' => 'sections',
        'field' => [
            'id',
            'name',
            'block_count',
            'type',
            'page_id',
            'ts'
        ]]) {

        return parent::findAll($params);
    }

    public function getByID($id) {

        $params = [
            'table' => 'sections',
    	     'field' => [
                'id',
                'name',
                'block_count',
                'type',
                'page_id',
                'ts'
            ],
            'where' => [
                'id = ' . $id,
            ],
        ];

        return parent::findAll($params);
    }

    public function getByPage($page) {

        $params = [
            'table' => 'sections',
    	     'field' => [
                'id',
                'name',
                'block_count',
                'type',
                'page_id',
                'ts'
            ],
            'where' => [
                'page_id = ' . $page,
            ],
        ];

        return parent::findAll($params);
    }


    public function getListByType($type) {

        $params = [
            'table' => 'pages',
            'field' => [
                'id',
                'name',
                'block_count',
                'type',
                'ts'
            ],
            'where' => [
                'type = ' . $type,
            ],
        ];

        return parent::findAll($params);
    }

}
