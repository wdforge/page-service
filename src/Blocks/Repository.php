<?php

/**
 * 
 * @package    Pages - Blocks
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */

/**
 * Формирование и передача запросов в виде массивов 
 * на метод выбоки findAll
 */
namespace PagesService\Blocks;

use System\Db\Repository\DbZendRepository;
use System\Repository\AbstractRepository;

class BlocksRepository extends DbZendRepository {

    function __construct() {
        // тип данных элемента по умолчанию
        $this->setEntityClass('EntityBlockItem');
    }

    public function findAll($params = [
        'table' => 'blocks',
        'field' => [
            'id',
            'title',
            'type',
            'source_id',
            'section_id',
            'parent_id',
            'style',
            'ts'
        ]]) {

        return parent::findAll($params);
    }

    public function getByID($id) {

        $params = [
            'table' => 'blocks',
    	     'field' => [
                'id',
                'title',
                'type',
                'source_id',
                'section_id',
                'parent_id',
                'style',
                'ts'
            ],
            'where' => [
                'id = ' . $id,
            ],
        ];

        return parent::findAll($params);
    }

    public function getByParent($parent) {

        $params = [
            'table' => 'blocks',
    	     'field' => [
                'id',
                'title',
                'type',
                'source_id',
                'section_id',
                'parent_id',
                'style',
                'ts'
            ],
            'where' => [
                'parent_id = ' . $parent,
            ],
        ];

        return parent::findAll($params);
    }


    public function getBySection($section) {

        $params = [
            'table' => 'blocks',
    	     'field' => [
                'id',
                'title',
                'type',
                'source_id',
                'section_id',
                'parent_id',
                'style',
                'ts'
            ],
            'where' => [
                'section_id = ' . $section,
            ],
        ];

        return parent::findAll($params);
    }


    public function getListByType($type) {

        $params = [
            'table' => 'pages',
            'field' => [
                'id',
                'title',
                'type',
                'source_id',
                'section_id',
                'parent_id',
                'style',
                'ts'
            ],
            'where' => [
                'type = ' . $type,
            ],
        ];

        return parent::findAll($params);
    }

}
