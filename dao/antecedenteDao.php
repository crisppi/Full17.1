<?php

require_once("./models/antecedente.php");
require_once("./models/message.php");

// Review DAO
require_once("dao/antecedenteDao.php");

class antecedenteDAO implements antecedenteDAOInterface
{

    private $conn;
    private $url;
    public $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildantecedente($data)
    {
        $antecedente = new antecedente();

        $antecedente->id_antecedente = $data["id_antecedente"];
        $antecedente->antecedente_ant = $data["antecedente_ant"];

        return $antecedente;
    }

    public function findAll()
    {
    }

    public function getantecedente()
    {

        $antecedente = [];

        $stmt = $this->conn->query("SELECT * FROM tb_antecedente ORDER BY id_antecedente asc");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $antecedenteArray = $stmt->fetchAll();

            foreach ($antecedenteArray as $antecedente) {
                $antecedente[] = $this->buildantecedente($antecedente);
            }
        }

        return $antecedente;
    }

    public function getantecedenteByNome($nome)
    {

        $antecedente = [];

        $stmt = $this->conn->prepare("SELECT * FROM tb_antecedente
                                    WHERE antecedente_ant = :antecedente_ant
                                    ORDER BY id_antecedente asc");

        $stmt->bindParam(":antecedente_ant", $antecedente_ant);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $antecedenteArray = $stmt->fetchAll();

            foreach ($antecedenteArray as $antecedente) {
                $antecedente[] = $this->buildantecedente($antecedente);
            }
        }

        return $antecedente;
    }

    public function findById($id_antecedente)
    {
        $antecedente = [];
        $stmt = $this->conn->prepare("SELECT * FROM tb_antecedente
                                    WHERE id_antecedente = :id_antecedente");

        $stmt->bindParam(":id_antecedente", $id_antecedente);
        $stmt->execute();

        $data = $stmt->fetch();
        //var_dump($data);
        $antecedente = $this->buildantecedente($data);

        return $antecedente;
    }

    public function findByTitle($title)
    {

        $antecedente = [];

        $stmt = $this->conn->prepare("SELECT * FROM tb_antecedente
                                    WHERE title LIKE :nome");

        $stmt->bindValue(":title", '%' . $title . '%');

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $antecedenteArray = $stmt->fetchAll();

            foreach ($antecedenteArray as $antecedente) {
                $antecedente[] = $this->buildantecedente($antecedente);
            }
        }

        return $antecedente;
    }

    public function create(antecedente $antecedente)
    {

        $stmt = $this->conn->prepare("INSERT INTO tb_antecedente (
        antecedente_ant
      ) VALUES (
        :antecedente_ant
     )");

        $stmt->bindParam(":antecedente_ant", $antecedente->antecedente_ant);



        $stmt->execute();

        // Mensagem de sucesso por adicionar filme
        $this->message->setMessage("antecedente adicionado com sucesso!", "success", "list_antecedente.php");
    }

    public function update(antecedente $antecedente)
    {

        $stmt = $this->conn->prepare("UPDATE tb_antecedente SET
        antecedente_ant = :antecedente_ant
        
        WHERE id_antecedente = :id_antecedente 
      ");

        $stmt->bindParam(":antecedente_ant", $antecedente->antecedente_ant);

        $stmt->bindParam(":id_antecedente", $antecedente->id_antecedente);
        $stmt->execute();

        // Mensagem de sucesso por editar antecedente
        $this->message->setMessage("antecedente atualizado com sucesso!", "success", "list_antecedente.php");
    }

    public function destroy($id_antecedente)
    {
        $stmt = $this->conn->prepare("DELETE FROM tb_antecedente WHERE id_antecedente = :id_antecedente");

        $stmt->bindParam(":id_antecedente", $id_antecedente);

        $stmt->execute();

        // Mensagem de sucesso por remover filme
        $this->message->setMessage("antecedente removido com sucesso!", "success", "list_antecedente.php");
    }


    public function findGeral()
    {

        $antecedente = [];

        $stmt = $this->conn->query("SELECT * FROM tb_antecedente ORDER BY id_antecedente asc");

        $stmt->execute();

        $antecedente = $stmt->fetchAll();

        return $antecedente;
    }
}
