<?php

class ErrorsController extends ControllerBase
{
    public function initialize()
    {
        //$this->tag->setTitle('Oops!');
        parent::initialize();
    }

    public function show404Action()
    {
        $this->logger->info($this->logMsg('404エラー'));
    }

    public function show401Action()
    {

    }

    public function show500Action()
    {
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(500, "Internal Server Error");
        $this->logger->info($this->logMsg('500エラー'));
    }

}
