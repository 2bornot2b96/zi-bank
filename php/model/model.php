<?php

function req_create_account($account) {
    $db = dbConnect();

    $sqlQuery = 'INSERT INTO users(users_nom, users_prenom, users_pass, users_mail, users_solde) VALUES(:nom, :prenom, :pass, :mail, :solde)';
    $insertUser = $db -> prepare($sqlQuery);
    $insertUser -> execute([
        'nom' => $account['nom'],
        'prenom' => $account['prenom'],
        'pass' => $account['pass'],
        'mail' => $account['mail'],
        'solde' => 50,
    ]);

};

function req_control_if_exist($account) {
    $db = dbConnect();

    $sqlQuery = 'SELECT users_mail FROM users WHERE users_mail = :mail';
    $reqMail = $db -> prepare($sqlQuery);
    $reqMail -> execute([
        'mail' => $account['mail'],
    ]);

    return $reqMail -> fetchAll();
}

function req_connection($log) {
    $db = dbConnect();

    $sqlQuery = 'SELECT * , CONCAT(FORMAT(users_solde, 2),\'€\') AS \'solde\'  FROM users WHERE users_mail = :mail AND users_pass = :pass';
    $reqConnect = $db -> prepare($sqlQuery);
    $reqConnect -> execute([
        'mail' => $log['mail'],
        'pass' => $log['pass'],
    ]);
    $reqUser = $reqConnect -> fetchAll();
    return $reqUser;
}

function req_get_account($mail, $pass) {
    $db = dbConnect();

    $sqlQuery = 'SELECT * , CONCAT(FORMAT(users_solde, 2),\'€\') AS \'solde\'  FROM users WHERE users_mail = :mail AND users_pass = :pass';
    $reqConnect = $db -> prepare($sqlQuery);
    $reqConnect -> execute([
        'mail' => $mail,
        'pass' => $pass,
    ]);
    $reqUser = $reqConnect -> fetchAll();
    return $reqUser[0];
}

function req_get_account_from($mail) {
    $db = dbConnect();

    $sqlQuery = 'SELECT users_id, users_solde  FROM users WHERE users_mail = :mail';
    $reqConnect = $db -> prepare($sqlQuery);
    $reqConnect -> execute([
        'mail' => $mail,
    ]);
    $reqUser = $reqConnect -> fetchAll();
    if(empty($reqUser[0][0])) {
        throw new Exception("destinataire non trouvé .");     
    }
    return $reqUser[0];
}

function req_new_solde(float $solde,int $id) {
    $db = dbConnect();

    $sqlQuery = 'UPDATE users SET users_solde = '. $solde . ' WHERE users_id = '. $id ;
    $req = $db->prepare($sqlQuery);
    $req->execute();
    
}

function req_new_historic(int $to, int $from, float $mount) {
    $db = dbConnect();

    $sqlQuery = 'INSERT INTO historic(historic_to, historic_from, historic_amount, historic_date) VALUES(:de, :fromer, :amount, :dates)';
    $req = $db->prepare($sqlQuery);
    $req->execute([
        'de' => $to,
        'fromer' => $from,
        'amount' => $mount,
        'dates' => date('Y-m-d H:i:s'),
    ]);
}

function req_new_historic_ext(int $to, string $from, float $mount) {
    $db = dbConnect();

    $sqlQuery = 'INSERT INTO historic(historic_to, historic_add, historic_amount, historic_date) VALUES(:de, :fromer, :amount, :dates)';
    $req = $db->prepare($sqlQuery);
    $req->execute([
        'de' => $to,
        'fromer' => $from,
        'amount' => $mount,
        'dates' => date('Y-m-d H:i:s'),
    ]);
}

function req_new_historic_depot(int $from, float $mount) {
    $db = dbConnect();

    $sqlQuery = 'INSERT INTO historic(historic_from, historic_add, historic_amount, historic_date) VALUES(:fromer, \'depot\', :amount, :dates)';
    $req = $db->prepare($sqlQuery);
    $req->execute([
        'fromer' => $from,
        'amount' => $mount,
        'dates' => date('Y-m-d H:i:s'),
    ]);
}

function req_get_send(int $id) {
    $db = dbConnect();

    $sqlQuery = 'SELECT f.users_prenom AS prenom, f.users_nom AS nom, CONCAT(FORMAT(h.historic_amount, 2),\'€\') AS amount, h.historic_date AS dates, h.historic_add AS adds FROM historic AS h
    INNER JOIN users AS t ON t.users_id = h.historic_to
    LEFT JOIN users AS f ON f.users_id = h.historic_from
    WHERE h.historic_to = :id';
    $req = $db->prepare($sqlQuery);
    $req->execute([
        ':id' => $id,
    ]);
    return $req->fetchAll();
}

function req_get_received(int $id) {
    $db = dbConnect();

    $sqlQuery = 'SELECT t.users_prenom AS prenom, t.users_nom AS nom, CONCAT(FORMAT(h.historic_amount, 2),\'€\') AS amount, h.historic_date AS dates, h.historic_add AS adds FROM historic AS h
    INNER JOIN users AS f ON f.users_id = h.historic_from
    LEFT JOIN users AS t ON t.users_id = h.historic_to
    WHERE h.historic_from = :id';
    $req = $db->prepare($sqlQuery);
    $req->execute([
        ':id' => $id,
    ]);
    return $req->fetchAll();
}
//connexion db

function dbConnect() {

    try {
        $db = new PDO('mysql:host=localhost;dbname=zi_banke;charset=utf8', 'root', 'root');
        return $db;
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}