<?php 

class TarefaService{
    private $conexao;
    private $tarefa;

    public function __construct(Conexao $conexao,Tarefa $tarefa){
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    //create 
    public function inserir(){
        $query = "insert into tb_tarefas(tarefa)values(:tarefa)";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $conn->execute();
    }

    //read
    public function recuperar(){
        $query = "select t.id, s.status, t.tarefa from tb_tarefas as t left join tb_status as s on (t.id_status = s.id)";
        $conn = $this->conexao->prepare($query);
        $conn->execute();
        return $conn->fetchAll((PDO::FETCH_OBJ));
    }

    //update
    public function atualizar(){
        $query = "update tb_tarefas set tarefa = ? where id = ?";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(1, $this->tarefa->__get('tarefa'));
        $conn->bindValue(2, $this->tarefa->__get('id'));

        return $conn->execute();
    }

    //delete
    public function remover(){
        $query = "delete from tb_tarefas where id = :id";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':id', $this->tarefa->__get('id'));
        $conn->execute();
    }

    //marcar a tarefa como realizada
    public function TarefaRealizada(){
        $query = "update tb_tarefas set id_status = ? where id = ?";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(1, $this->tarefa->__get('id_status'));
        $conn->bindValue(2, $this->tarefa->__get('id'));
        return $conn->execute();
    }

    //recuperar tarefas pendentes
    public function TarefasPendentes(){
        $query = "select t.id, s.status, t.tarefa from tb_tarefas as t left join tb_status as s on (t.id_status = s.id) where t.id_status = :id_status";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':id_status', $this->tarefa->__get('id_status'));
        $conn->execute();
        return $conn->fetchAll((PDO::FETCH_OBJ));
    }
}

?>