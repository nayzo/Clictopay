<?php

/*
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Clictopay extends PaymentModule
{
    private $_html = '';
    private $_postErrors = array();

    public $URL;
    public $affilie;

    function __construct()
    {
        $this->name = 'clictopay';
        $this->tab = 'payments_gateways';
        $this->version = '1.4.1';
        $this->author = 'Ala Eddine Khefifi';

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        $config = Configuration::getMultiple(array('URL', 'affilie'));

        if (isset($config['URL'])) {
            $this->URL = $config['URL'];
        }

        if (isset($config['affilie'])) {
            $this->affilie = $config['affilie'];
        }

        parent::__construct();

        $this->displayName = 'Clictopay SMT';
        $this->description = $this->l('This module allows you to accept online payments based on the SPS Clictopay SMT. Developed by Ala Eddine Khefifi. Email: alakhefifi@gmail.com');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');

        if ((!isset($this->URL) || !isset($this->affilie) || empty($this->URL) || empty($this->affilie))) {
            $this->warning = $this->l('The URL and the Affiliate fields must be configured in order to use this module correctly.');
        }

        if (!count(Currency::checkPaymentCurrencies($this->id))) {
            $this->warning = $this->l('No currency set for this module');
        }

        if ('localhost' === $_SERVER['HTTP_HOST']) {
            $this->warning = $this->l('The payment cannot be executed on localhost');
        }
    }

    public function install()
    {
        if (!parent::install() || !$this->registerHook('payment'))
            return false;

        $sql = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "clictopay`(
            `id_clictopay` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `reference` VARCHAR(256) NOT NULL,
			`param` VARCHAR(256),
			`cart` INT(11) NOT NULL,
			`total` FLOAT(11) NOT NULL,
			`module` VARCHAR(256) NOT NULL,
			`currency` INT(11) NOT NULL,
			`customer` VARCHAR(256) NOT NULL
			)";

        if (!Db::getInstance()->Execute($sql)) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!Configuration::deleteByName('URL') || !Configuration::deleteByName('affilie') || !parent::uninstall()) {
            return false;
        }

        $sql = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "clictopay`";

        if (!Db::getInstance()->Execute($sql)) {
            return false;
        }

        return true;
    }

    private function _postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
            if (!Tools::getValue('URL')) {
                $this->_postErrors[] = $this->l('The URL field is empty!');
            } elseif (!Tools::getValue('affilie')) {
                $this->_postErrors[] = $this->l('The Affiliate field is empty!');
            }
        }
    }

    private function _postProcess()
    {
        if (Tools::isSubmit('btnSubmit')) {
            Configuration::updateValue('URL', Tools::getValue('URL'));
            Configuration::updateValue('affilie', Tools::getValue('affilie'));
        }

        $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    private function _displayCart()
    {
        return $this->display(__FILE__, 'infos.tpl');
    }

    private function renderForm()
    {
        $this->_html .=
            '<form action="' . Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']) . '" method="post">
			<fieldset>
			<legend><img src="../img/admin/contact.gif" />' . $this->l('Info Clictopay SMT') . '</legend>
				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">
					<tr><td colspan="2">' . $this->l('Enter Configuration Information for Clictopay SMT') . '.<br /><br /></td></tr>
					<tr><td width="130" style="height: 35px;">' . $this->l('link to the Clictopay SMT payment site') . '</td><td><input type="text" name="URL" value="' . Tools::htmlentitiesUTF8(Tools::getValue('URL', $this->URL)) . '" style="width: 300px;" /></td></tr>
					<tr>
						<td width="130" style="height: 35px;">' . $this->l('Affiliate') . '</td>
						<td><input type="text" name="affilie" value="' . Tools::htmlentitiesUTF8(Tools::getValue('affilie', $this->affilie)) . '" style="width: 300px;" /></td>
					</tr>			
					<tr><td colspan="2" align="center"><br /><input class="button" name="btnSubmit" value="' . $this->l('Update settings') . '" type="submit" /></td></tr>
				</table>
			</fieldset>
		</form>';
    }

    public function getContent()
    {
        $this->_html .= '<h1>' . $this->displayName . '</h1>';

        if (Tools::isSubmit('btnSubmit')) {
            $this->_postValidation();

            if (!count($this->_postErrors)) {
                $this->_postProcess();
            } else {
                foreach ($this->_postErrors as $err) {
                    $this->_html .= $this->displayError($err);
                }
            }
        }

        $this->_html .= $this->_displayCart();
        $this->_html .= $this->renderForm();

        return $this->_html;
    }

    public function hookPayment($params)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        $this->smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/'
        ));

        return $this->display(__FILE__, 'payment.tpl');
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency((int)($cart->id_currency));
        $currencies_module = $this->getCurrency((int)$cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }

        return false;
    }
}
