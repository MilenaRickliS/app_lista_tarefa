<?php 

require_once "../app_lista_tarefa/conexao.php";
require_once "../app_lista_tarefa/tarefa.service.php";
require_once "../app_lista_tarefa/tarefa.model.php";

class TarefaController{
    public $acao;
    public function criacaoTarefa(){
        $tarefa = new Tarefa();
        return $tarefa;
    }
    public function criacaoConexao(){
        $conexao = new Conexao();
        return $conexao;
    }
}

$acao = isset($__GET['acao']) ? $__GET['acao'] : $acao;
$tarefaController = new TarefaController();

if($acao == 'inserir'){
    $tarefa = $tarefaController->criacaoTarefa();
    $tarefa->__set('tarefa', $_POST['tarefa']);
    $conexao = $tarefaController->criacaoConexao();
    $tarefaService = new TarefaService($conexao, $tarefa); 
    $tarefaService->inserir();
    
}else if($acao == 'recuperar'){
    $tarefa = $tarefaController->criacaoTarefa();
    $conexao = $tarefaController->criacaoConexao();
    $tarefaService = new TarefaService($conexao, $tarefa); 
    $tarefaService->recuperar();

}else if($acao == 'atualizar'){
    $tarefa = $tarefaController->criacaoTarefa();
    $tarefa->__set('tarefa', $_POST['tarefa']);    
    $conexao = $tarefaController->criacaoConexao();
    $tarefaService = new TarefaService($conexao, $tarefa); 
    $tarefaService->atualizar();

}else if($acao == 'remover'){
    $tarefa = $tarefaController->criacaoTarefa();
    $tarefa->__set('id', $__GET['id']); 
    $conexao = $tarefaController->criacaoConexao();
    $tarefaService = new TarefaService($conexao, $tarefa); 
    $tarefaService->remover();

}else if($acao == 'TarefaRealizada'){
    $tarefa = $tarefaController->criacaoTarefa();
    $tarefa->__set('id_status', $_POST['id_status']);    
    $conexao = $tarefaController->criacaoConexao();
    $tarefaService = new TarefaService($conexao, $tarefa); 
    $tarefaService->TarefaRealizada();

}else if($acao == 'TarefasPendentes'){
    $tarefa = $tarefaController->criacaoTarefa();
    $tarefa->__set('id_status', $_POST['id_status']);
    $conexao = $tarefaController->criacaoConexao();
    $tarefaService = new TarefaService($conexao, $tarefa); 
    $tarefaService->TarefasPendentes();
}

?>