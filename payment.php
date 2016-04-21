<?php

/*
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$useSSL = true;

require('../../config/config.inc.php');
Tools::displayFileAsDeprecated();

$controller = new FrontController();
$controller->init();

Tools::redirect(Context::getContext()->link->getModuleLink('clictopay', 'payment'));
