<?php

include('php/model/model.php');

function create_account($account)
{
    $reqMail = req_control_if_exist($account);

    if (!isset($reqMail[0])) {
        req_create_account($account);
        $_SESSION['notice'] = 'compte crée .';
        header('location: index.php');
    } else {
        $_SESSION['notice'] = 'mail déja existant .';
        header('location: index.php?action=create_account');
    }
}

function connection($log)
{
    $reqUser =  req_connection($log);
    if (isset($reqUser[0])) {
        $_SESSION['user_logged'] = $reqUser[0]['users_mail'];
        $_SESSION['user_pass'] = $reqUser[0]['users_pass'];
        header('location: index.php');
    } else {
        $_SESSION['notice'] = 'mail ou identifiant incorrecte .';
        header('location: index.php');
    }
}

function get_virement()
{
    if (isset($_SESSION['user_logged']) && !empty($_POST['from']) && !empty($_POST['amount']) && !empty($_POST['virage'])) {
        try {
            if(floatval($_POST['amount']) <= 0 || preg_match('/[a-z]/i' , $_POST['amount'])) {
                throw new Exception('valeur inacceptable !');
            }
            require_once('php/controler/class-compte.php');
            $initCompte = req_get_account($_SESSION['user_logged'], $_SESSION['user_pass']);
            $compte = new Comptes($initCompte['users_id'], $initCompte['users_solde']);
            if ($_POST['virage'] == 'compte-Zibanke') {
                $initFromCompte = req_get_account_from($_POST['from']);
                $fromCompte = new Comptes($initFromCompte['users_id'], $initFromCompte['users_solde']);
                $compte->virement(floatval($_POST['amount']));
                $fromCompte->get_virement(floatval($_POST['amount']));
                req_new_historic($initCompte['users_id'], $initFromCompte['users_id'], floatval($_POST['amount']));
                header('location: index.php');
            } elseif ($_POST['virage'] == 'autre') {
                $compte->virement(floatval($_POST['amount']));
                req_new_historic_ext($initCompte['users_id'], $_POST['from'], floatval($_POST['amount']));
                header('location: index.php');
            }else {
                throw new Exception("petit malin ! ");
                
            }
        } catch (Exception $e) {
            $_SESSION['notice'] = $e->getMessage();
            header('location: index.php');
        }
    } else {
        $_SESSION['notice'] = 'champ incomplet';
        header('location: index.php');
    }
}

function get_depot()
{
    if (isset($_SESSION['user_logged']) && !empty($_POST['amount'])) {
        try {
            if(floatval($_POST['amount']) <= 0 || preg_match('/[a-z]/i' , $_POST['amount'])) {
                throw new Exception('valeur inacceptable !');
            }
            require_once('php/controler/class-compte.php');
            $initCompte = req_get_account($_SESSION['user_logged'], $_SESSION['user_pass']);
            $compte = new Comptes($initCompte['users_id'], $initCompte['users_solde']);
            $compte->get_virement(floatval($_POST['amount']));
            req_new_historic_depot($initCompte['users_id'], floatval($_POST['amount']));
            header('location: index.php');
        } catch (Exception $e) {
            $_SESSION['notice'] = $e->getMessage();
            header('location: index.php');
        }
    } else {
        $_SESSION['notice'] = 'champ incomplet';
        header('location: index.php');
    }
}
