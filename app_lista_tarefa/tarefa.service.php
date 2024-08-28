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

    public function FiltrarTarefas($status) {
        if ($status == 'todas') {
            $query = "SELECT * FROM tb_tarefas";
        } elseif ($status == 'concluidas') {
            $query = "SELECT * FROM tb_tarefas WHERE id_status = 2"; 
        } elseif ($status == 'pendentes') {
            $query = "SELECT * FROM tb_tarefas WHERE id_status = 1"; 
        }
    
        $conn = $this->conexao->prepare($query);
        $conn->execute();
        return $conn->fetchAll(PDO::FETCH_OBJ);
    }

    //sistema de notificações
    public function dataLimite() {
        $currentDate = new DateTime();
        $oneWeekLater = $currentDate->add(new DateInterval('P7D'));
    
        $query = "SELECT * FROM tb_tarefas WHERE data_limite BETWEEN :currentDate AND :oneWeekLater";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':currentDate', $currentDate->format('Y-m-d'));
        $conn->bindValue(':oneWeekLater', $oneWeekLater->format('Y-m-d'));
        $conn->execute();
    
        return $conn->fetchAll(PDO::FETCH_OBJ);
    }

    //categoria tarefas

    //filtro tarefas por categoria

    //separar tarefas concluidas das pendentes
    public function arquivarTarefa($id) {
        $query = "UPDATE tb_tarefas SET id_status = 3 WHERE id = :id";
        $conn = $this->conexao->prepare($query);
        $conn->bindValue(':id', $id);
        $conn->execute();
    }
}

?>