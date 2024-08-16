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
        
    }

    //delete
}

?>