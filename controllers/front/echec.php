<?php

/**
 * @since 1.5.0
 */
class ClictopayEchecModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {

        parent::initContent();
        Tools::redirect('index.php?controller=order');

    }
}
