<?php

/**
 * @since 1.5.0
 */
include(dirname(__FILE__) . '../../clictopay.php');

class ClictopaySuccesModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        $context = Context::getContext();
        $cart = $context->cart;
        $clictopay = new Clictopay();
        $customer = new Customer($cart->id_customer);
        Tools::redirect('index.php?controller=order-confirmation&id_cart=' . (int)($cart->id) . '&id_module=' . (int)($clictopay->id) . '&id_order=' . $clictopay->currentOrder . '&key=' . $customer->secure_key);
    }
}
