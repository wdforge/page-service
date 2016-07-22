<?php

/**
 * 
 * @package    Pagess
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */
namespace PagesService\Pages;
use System\Action\ActionController;
use System\Http\HttpRequest;
use System\Std\View\JsonModel;

class PagesController extends ActionController {

    /**
     * Параметры фильтрации передаваемых данных 
     */
    protected $_requestFilter = [

        'GetByIdAction' => [
            '__isRequest' => true,
            'id' => [
                'from' => 'URL',
                'type' => 'int',
                'regexp' => '/\d+/',
                'error' => 'Request param "id" is not valid set.',
            ],
        ],

        'GetByUrlAction' => [
            '__isRequest' => true,
            'id' => [
                'from' => 'GET',
                'type' => 'string',
                'regexp' => '/\d+/',
                'error' => 'Request param "url" is not valid set.',
            ],
        ],


        'GetListByParentAction' => [
            '__isRequest' => true,
            'group' => [
                'from' => 'URL',
                'type' => 'int',
                'regexp' => '/\d+/',
                'error' => 'Request param "parent" is not valid set.',
            ],
        ],
    ];

    /**
     * получение списка всех объектов + пример аутентификации.
     * @param none
     * @return JsonModel
     */
    public function IndexAction(HttpRequest $request) {

        $result = [];
        $authError = false;

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();

        // выполнение с авторизацией по Api - ключу.
        $apiKey = $request->getGetSection('apikey');

        if ($this->getAccessManager() && !$this->getAccessManager()->isLogged()) {

            $authError = true;

            if ($this->getAccessManager()->enter($apiKey)) {
                $authError = false;
            }
        }

        if ($authError) {
            $result['error'] = 'Can\'t not autorizated by this api key';
        }

        if (!$authError) {
            // запрос к базе и возврат в виде списка объектов
            $result = $this->getServiceManager()
                ->getRepository('\PagesService\Entity\Page\EntityPageItem')
                ->findAll();
        }

        $result['method'] = 'Index';
        $result['time'] = self::getWorkTime();
        $result['eventdata'] = $event->result;

        return new JsonModel($result);
    }

    /**
     * Получение одного объекта по идентификатору.
     *
     * @param integer $id   идентификатор объекта
     * @return JsonModel
     */
    public function GetByIdAction(HttpRequest $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();

        $id = $request->getUrlSection('id');
        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('\PagesService\Entity\Page\EntityPageItem')
            ->getById($id);

        $result['method'] = 'GetById';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }


    /**
     * Получение одного объекта по идентификатору.
     *
     * @param integer $id   идентификатор объекта
     * @return JsonModel
     */
    public function GetByUrlAction(HttpRequest $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();
        $url = $request->getGetSection('url');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('\PagesService\Entity\Page\EntityPageItem')
            ->getByUrl($url);

        $result['method'] = 'GetByUrl';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }


    /**
     * получение объекта по выбранному уровню.
     *
     * @param integer $level - уровень объектов
     * @return JsonModel
     */
    public function GetListByParentAction(HttpRequest $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();

        $parent = $request->getGetSection('parent');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('\PagesService\Entity\Page\EntityPageItem')
            ->getListByParent($parent);

        $result['method'] = 'GetListByParent';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }
}
