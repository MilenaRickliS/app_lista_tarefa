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
        $query = "insert into tb_tarefas(tarefa, categoria, prioridade, data_limite)values(:tarefa, :categoria, :prioridade, :data_limite)";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
        $conn->bindValue(':categoria', $this->tarefa->__get('categoria'));
        $conn->bindValue(':prioridade', $this->tarefa->__get('prioridade'));
        $conn->bindValue(':data_limite', $this->tarefa->__get('data_limite'));
        $conn->execute();
    }

    //read
    public function recuperar(){
        $query = "select t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite from tb_tarefas as t left join tb_status as s on (t.id_status = s.id)";
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
        $query = "select t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite from tb_tarefas as t left join tb_status as s on (t.id_status = s.id) where t.id_status = :id_status";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':id_status', $this->tarefa->__get('id_status'));
        $conn->execute();
        return $conn->fetchAll((PDO::FETCH_OBJ));
    }

    //ordenar por data de criação
    public function OrderCriacao(){
        $query = "select t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite from tb_tarefas as t left join tb_status as s on (t.id_status = s.id) order by t.data_cadastrado";
        $conn = $this->conexao->prepare($query);
        $conn->execute();
        return $conn->fetchAll((PDO::FETCH_OBJ));
    }

    //ordenar por prioridade
    public function OrderPrioridade(){
        $query = "select t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite from tb_tarefas as t left join tb_status as s on (t.id_status = s.id) order by t.prioridade ";
        $conn = $this->conexao->prepare($query);
        $conn->execute();
        return $conn->fetchAll((PDO::FETCH_OBJ));
    }

    // Filtro tarefas
    public function FiltrarTarefas($status) {
        if($status == "todas"){
            $query = "select t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite from tb_tarefas as t left join tb_status as s on (t.id_status = s.id)";
            $conn = $this->conexao->prepare($query);
        }else{
            $query = "select t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite from tb_tarefas as t left join tb_status as s on (t.id_status = s.id) where s.status = :status";
            $conn = $this->conexao->prepare($query);
            $conn->bindValue(':status', $status);
        }
        
        $conn->execute();
        return $conn->fetchAll(PDO::FETCH_OBJ);
    }

    //filtro categorias
    public function FiltrarCategorias($categoria) {
        if ($categoria == 'todas') {
            $query = "SELECT t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite 
                       FROM tb_tarefas AS t 
                       LEFT JOIN tb_status AS s ON (t.id_status = s.id)";
            $conn = $this->conexao->prepare($query);
        } else {
            $query = "SELECT t.id, s.status, t.tarefa, t.categoria, t.prioridade, t.data_limite 
                       FROM tb_tarefas AS t 
                       LEFT JOIN tb_status AS s ON (t.id_status = s.id) 
                       WHERE t.categoria = :categoria";
            $conn = $this->conexao->prepare($query);
            $conn->bindValue(':categoria', $categoria);
        }
        $conn->execute();
        return $conn->fetchAll(PDO::FETCH_OBJ);
        
    }
    //sistema de notificações
    

    //separar tarefas concluidas das pendentes
    public function arquivarTarefa() {
        $query = "update tb_tarefas set id_status = :id_status where id = :id";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':id_status', 3);
        $conn->bindValue(':id', $this->tarefa->__get('id'));
        return $conn->execute();
    }
}

?>