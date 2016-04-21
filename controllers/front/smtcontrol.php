<?php

/*
 * (c) Ala Eddine Khefifi <alakhefifi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ClictopaySmtcontrolModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        if (empty($_GET['Reference']) || empty($_GET['Action'])) {
            exit;
        }

        $ref = $_GET['Reference'];
        $act = $_GET['Action'];

        if (!Db::getInstance()->getValue("
            SELECT `id_clictopay`
            FROM `" . _DB_PREFIX_ . "clictopay`
            WHERE `reference` = '$ref'")
        ) {
            exit;
        }

        switch (strtoupper($act)) {

            case "DETAIL":
                // access the database, and retrieve the amount
                $montant = Db::getInstance()->getValue("
                    SELECT `total`
                    FROM `" . _DB_PREFIX_ . "clictopay`
                    WHERE `reference` = '$ref'");
                if (empty($montant)) {
                    exit;
                }

                $montant = sprintf('%.3f', $montant);
                echo "Reference=$ref&Action=$act&Reponse=$montant";
                break;

            case "ACCORD":
                // access the database, register the authorization number (in param)

                $data = Db::getInstance()->executeS("
                    SELECT *
                    FROM `" . _DB_PREFIX_ . "clictopay`
                    WHERE `reference` = '$ref'");

                foreach ($data as $row) {
                    $mailVars = array();
                    $this->module->validateOrder($row['cart'],
                        Configuration::get('PS_OS_PAYMENT'),
                        $row['total'],
                        $row['module'],
                        NULL,
                        $mailVars,
                        $row['currency'],
                        false,
                        $row['customer']
                    );
                }

                $param = $_GET['Param'];
                if (isset($param)) {
                    Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "clictopay`
                    SET `param` = '$param'
                    WHERE `reference` = '$ref'");
                }

                echo "Reference=$ref&Action=$act&Reponse=OK";
                break;

            case "ERREUR":
            case "REFUS":
            case "ANNULATION":
                // access the database and update the transaction state
                Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "clictopay`
                    WHERE `reference` = '$ref'"
                );

                echo "Reference=$ref&Action=$act&Reponse=OK";
                break;
        }

        exit;
    }
}
