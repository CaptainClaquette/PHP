<?php

/**
 * Classe de connexion à une base de données.
 *
 * @author Komputeur
 */
class connectionDB {

    private $host;
    private $db;
    private $user;
    private $pwd;
    private $con;
    private $debug = false;

    public function __construct() {
        $this->host = "127.0.0.1";
        $this->db = "database";
        $this->user = "user";
        $this->pwd = "pwd";
        $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pwd);
		/* support utf8*/
        $this->con->query("SET NAMES 'utf8'");
    }

    public function executeQuery($rq) {
        if ($this->con) {
            return $this->con->query($rq);
        }
    }

    /**
     *  Execution d'une requete prepare.
     * 
     * @param String $rq Requete a executer.
     * @param array() $args Un tableau d'argument.
     * @return array()/int Retourne un tableau associatif si la requete est de type "SELECT", le nombre ligne affecte.
     */
    public function executePreparedQuery($rq, &$args) {
        $rqType = explode(' ', $rq);
        $stmt = $this->con->prepare($rq);

        foreach ($args as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        $stmt->execute();
        if ($this->debug)
        {
            error_log(serialize($stmt->errorInfo()));
        }
        if (preg_match("/insert|delete|update/", strtolower($rqType[0]))) {
            return $stmt->rowCount();
        } else {
            return $stmt->fetchall();
        }
    }

    public function getHost() {
        return $this->host;
    }

    public function getDb() {
        return $this->db;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setDb($db) {
        $this->db = $db;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
    }
    public function getDebug() {
        return $this->debug;
    }

    public function setDebug($debug) {
        $this->debug = $debug;
    }
    
}
