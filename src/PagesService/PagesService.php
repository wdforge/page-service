<?php

/**
 * 
 * @package    Pages
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */

namespace PagesService\PagesService;

use System\Application\AbstractApplication;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\ExceptionInterface;

class PagesService extends AbstractApplication {

    public function init() {
        $this->initConnection();
        parent::init();
    }

    public function initConnection() {
        $cfg = self::getConfig();

        try {
            $sm = $this->getServiceManager();

            // создаем Zend\Db\Apapter и кладем в сервис-менеджер
            $sm->set('zend-db-adapter', new Adapter([
                    'driver' =>   $cfg['connection']['pages']['db']['driver'],
                    'database' => $cfg['connection']['pages']['db']['database'],
                    'username' => $cfg['connection']['pages']['db']['username'],
                    'password' => $cfg['connection']['pages']['db']['password'],
                    'hostname' => $cfg['connection']['pages']['db']['hostname'],
                    'charset' =>  $cfg['connection']['pages']['db']['charset']
                ])
            );
        } catch (ExceptionInterface $e) {
            trigger_error($e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage());
        } catch (\Exception $e) {
            trigger_error($e->getMessage());
        }
    }

    // Обработка событий
    public function BeforePagesServiceIndexAction(&$event) {
        $event->result[] = "from Before index data method: " . __METHOD__;
    }

    // Отрабатывает но данных не видно т.к. их выдача уже прошла.
    public function AfterPagesServiceIndexAction(&$event) {
        $event->result[] = "from After index data method: " . __METHOD__;
    }
}
