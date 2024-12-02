<?php session_start();
include('php/controler/controler.php');

if(isset($_GET['action'])) {
  if($_GET['action'] == 'create_account') {
    include_once('php/view/create_account.php');
  }
  elseif($_GET['action'] == 'creating') {
    create_account($_POST);
  }
  elseif($_GET['action'] == 'connexion') {
    connection($_POST);
  }
  elseif($_GET['action'] == 'disconnect') {
    session_unset();
    session_destroy();
    session_abort();
    header('location: index.php');
  }
  elseif($_GET['action'] == 'virement') {
    get_virement();
  }
  elseif($_GET['action'] == 'depot') {
    get_depot();
  }
  
}
elseif(isset($_SESSION['user_logged'])) {
  include_once('php/view/compte.php');
}else {
  include_once('php/view/login.php');
};

