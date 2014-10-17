<?php
session_start();

/**
 * @since 1.5.0
 */
class ClictopayValidationModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $cart = $this->context->cart;

        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
            Tools::redirect('index.php?controller=order&step=1');

        // Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
        $authorized = false;
        foreach (Module::getPaymentModules() as $module)
            if ($module['name'] == 'clictopay') {
                $authorized = true;
                break;
            }

        if (!$authorized)
            die($this->module->l('This payment method is not available.', 'validation'));

        $customer = new Customer($cart->id_customer);

        if (!Validate::isLoadedObject($customer))
            Tools::redirect('index.php?controller=order&step=1');

        $currency = $this->context->currency;
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);


        $cartid = (int)$cart->id;
        $name = $this->module->displayName;
        $currencyid = (int)$currency->id;
        $customerkey = $customer->secure_key;
        $reference = strtoupper(Tools::passwdGen(9, 'NO_NUMERIC')) . strtoupper(Tools::passwdGen(9, 'NO_NUMERIC'));

        $config = Configuration::getMultiple(array('URL', 'affilie'));
        $_SESSION['URL'] = $config['URL'];
        $_SESSION['Reference'] = $reference;
        $_SESSION['Montant'] = $total;
        $_SESSION['affilie'] = $config['affilie'];
        $_SESSION['Devise'] = $currency->iso_code;

        Db::getInstance()->execute("INSERT INTO " . _DB_PREFIX_ . "clictopay (reference,cart,total,module,currency,customer) VALUES ('$reference','$cartid','$total','$name','$currencyid','$customerkey')");

        Tools::redirect('index.php?fc=module&module=clictopay&controller=order');

    }
}
