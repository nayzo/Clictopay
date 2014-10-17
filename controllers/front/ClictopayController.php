<?php

/**
 * @since 1.5.0
 */
class ClictopayControllerModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {

        if (empty($_GET['Reference']) || empty($_GET['Action']))
            exit;

        $ref = $_GET['Reference'];
        $act = $_GET['Action'];

        if (!Db::getInstance()->getValue("SELECT `id_clictopay` FROM `" . _DB_PREFIX_ . "clictopay` WHERE `reference` = '$ref'"))
            exit;

        switch ($act) {
            case "DETAIL":
                // access the database, and retrieve the amount
                $montant = Db::getInstance()->getValue("
                        SELECT `total`
                        FROM `" . _DB_PREFIX_ . "clictopay`
                        WHERE `reference` = '$ref'");
                if (empty($montant))
                    exit;

                echo "Reference=$ref&Action=$act&Reponse=$montant";
                break;


            case "ERREUR":
                // access the database and update the transaction state
                Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "clictopay` WHERE `reference` = '$ref'");

                echo "Reference=$ref&Action=$act&Reponse=OK";
                break;


            case "ACCORD":
                // access the database, register the authorization number (in param)
                $par = $_GET['Param'];

                $data = Db::getInstance()->executeS("
                        SELECT *
                        FROM `" . _DB_PREFIX_ . "clictopay`
                        WHERE `reference` = '$ref'");
                foreach ($data as $row) {
                    $mailVars = array();
                    $this->module->validateOrder($row['cart'], Configuration::get('PS_OS_PAYMENT'), $row['total'], $row['module'], NULL, $mailVars, $row['currency'], false, $row['customer']);
                }
                Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "clictopay` SET `param` = $par WHERE `reference` = '$ref'");
                echo "Reference=$ref&Action=$act&Reponse=OK";
                break;


            case "REFUS":
                // access the database and update the transaction state
                Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "clictopay` WHERE `reference` = '$ref'");

                echo "Reference=$ref&Action=$act&Reponse=OK";
                break;


            case "ANNULATION":
                // access the database and update the transaction state
                Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "clictopay` WHERE `reference` = '$ref'");

                echo "Reference=$ref&Action=$act&Reponse=OK";
                break;

        }
        exit;
    }

}