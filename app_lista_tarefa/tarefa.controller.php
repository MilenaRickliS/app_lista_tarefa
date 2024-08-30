<?php

	require "../app_lista_tarefa/tarefa.model.php";
	require "../app_lista_tarefa/tarefa.service.php";
	require "../app_lista_tarefa/conexao.php";

	$acao = isset($_GET['acao']) ? $_GET['acao'] : 'recuperar';
	
	if($acao == 'inserir' ) {
		$tarefa = new Tarefa();
		$tarefa->__set('tarefa', $_POST['tarefa']);
		$tarefa->__set('categoria', $_POST['categoria']);
    	$tarefa->__set('prioridade', $_POST['prioridade']);
    	$tarefa->__set('data_limite', $_POST['data_limite']);	

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->inserir();

		header('Location: nova_tarefa.php?inclusao=1');
	
	} else if($acao == 'recuperar') {
		
		$tarefa = new Tarefa();
		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);
		// $tarefas = $tarefaService->recuperar();
		if (!empty($_GET['status']) && !empty($_GET['categoria'])) {
			$tarefas = $tarefaService->Filtrar($_GET['status'], $_GET['categoria']);
		} else {
			$tarefas = $tarefaService->recuperar();
		}

	
	} else if($acao == 'atualizar') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id'])
			->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		if($tarefaService->atualizar()) {
			
			if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
				header('location: index.php');	
			} else {
				header('location: todas_tarefas.php');
			}
		}


	} else if($acao == 'remover') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();

		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'TarefaRealizada') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->TarefaRealizada();

		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'TarefasPendentes') {

		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->TarefasPendentes();

	} else if($acao == 'OrderCriacao') {

		$tarefa = new Tarefa();
		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->OrderCriacao();

	} else if($acao == 'OrderPrioridade') {

		$tarefa = new Tarefa();
		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->OrderPrioridade();

	} else if ($acao == 'Filtrar') {
		
		$tarefa = new Tarefa();
		$conexao = new Conexao();
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->Filtrar($_GET['status'], $_GET['categoria']);
		require_once 'todas_tarefas.php';

	}else if ($acao == 'arquivarTarefa') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 3);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->arquivarTarefa();

		if( isset($_GET['pag']) && $_GET['pag'] == 'todas_tarefas') {
			header('location: todas_tarefas.php');	
		} else {
			header('location: tarefas_arquivadas.php');
		}
	}

?>