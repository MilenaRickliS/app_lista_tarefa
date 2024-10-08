<?php


require 'tarefa_controller.php';
$acao = 'Filtrar';

	/*
	echo '<pre>';
	print_r($tarefas);
	echo '</pre>';
	*/
	

?>

<html lang="pt-br">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

		<style>
			.tarefa {
				display: flex;
				flex-wrap: wrap;
				justify-content: space-between;
			}

			.tarefa > div {
				flex-basis: 12.5%; 
			}
			.tarefa-titulo {
				padding-right: 15px;
				font-weight: bold;
				color: #333;
			}

			.tarefa-data {
				margin-right: 15px;
				padding: 15px;
				width: 80px;
				font-size: 10px;
				color: #fff;
				background-color: #00523D;
				border-radius: 15px;
			}

			.tarefa-categoria {
				margin-right: 15px;
				padding: 15px;
				width: 80px;
				font-size: 10px;
				color: #000;
				background-color: #ADCAFF;
				border-radius: 15px;
			}

			.tarefa-prioridade {
				margin-right: 15px;
				padding: 15px;
				width: 80px;
				font-size: 10px;
				color: #000;
				border-radius: 15px;
			}

			.tarefa-prioridade.alta {
				background-color: #D1234C;
			}

			.tarefa-prioridade.media {
				background-color: #FFE66D;
			}

			.tarefa-prioridade.baixa {
				background-color: #4ECDC4;
			}

			
			@media (max-width: 990px) {
			.tarefa {
				flex-direction: column;
			}
			.tarefa-data, .tarefa-categoria, .tarefa-prioridade {
				margin-bottom: 10px;
			}
			}
			.prazo-container {
				width: 120px; 
			}
			.prazo{
				
				padding: 2px;
				font-size: 13px;
				font-weight: bold;
				width: 200px;
				box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px 0px inset;				
				border-radius: 15px;
				background-color: #fff;
			}



		</style>

		<script>
			function editar(id, txt_tarefa) {

				//criar um form de edição
				let form = document.createElement('form')
				form.action = 'tarefa_controller.php?acao=atualizar'
				form.method = 'post'
				form.className = 'row'

				//criar um input para entrada do texto
				let inputTarefa = document.createElement('input')
				inputTarefa.type = 'text'
				inputTarefa.name = 'tarefa'
				inputTarefa.className = 'col-9 form-control'
				inputTarefa.value = txt_tarefa

				//criar um input hidden para guardar o id da tarefa
				let inputId = document.createElement('input')
				inputId.type = 'hidden'
				inputId.name = 'id'
				inputId.value = id

				//criar um button para envio do form
				let button = document.createElement('button')
				button.type = 'submit'
				button.className = 'col-3 btn btn-info'
				button.innerHTML = 'Atualizar'

				//incluir inputTarefa no form
				form.appendChild(inputTarefa)

				//incluir inputId no form
				form.appendChild(inputId)

				//incluir button no form
				form.appendChild(button)

				//teste
				//console.log(form)

				//selecionar a div tarefa
				let tarefa = document.getElementById('tarefa_'+id)

				//limpar o texto da tarefa para inclusão do form
				tarefa.innerHTML = ''

				//incluir form na página
				tarefa.insertBefore(form, tarefa[0])

			}

			function remover(id) {
				location.href = 'todas_tarefas.php?acao=remover&id='+id;
			}

			function TarefaRealizada(id) {
				location.href = 'todas_tarefas.php?acao=TarefaRealizada&id='+id;
			}
			function OrderCriacao() {
				location.href = 'todas_tarefas.php?acao=OrderCriacao';
			}
			function OrderPrioridade() {
				location.href = 'todas_tarefas.php?acao=OrderPrioridade';
			}
			function Filtrar() {
				var status = document.getElementById("status").value;
				var categoria = document.getElementById("categoria").value;
				location.href = 'todas_tarefas.php?acao=Filtrar&status=' + status + '&categoria=' + categoria;
			}
			function arquivarTarefa(id){
				location.href = 'todas_tarefas.php?acao=arquivarTarefa&id=' + id;
			}
			
		</script>
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
						<li class="list-group-item"><a href="tarefas_arquivadas.php">Tarefas Arquivadas</a></li>
					</ul>
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<button class="btn btn-secondary" onclick="OrderCriacao()">Ordenar por criação</button>
								<button class="btn btn-secondary" onclick="OrderPrioridade()">Ordenar por prioridade</button>
								<hr />
								
								
									<form>
										<select name="status" id="status">
											<option value="todas">Todas</option>
											<option value="realizado">Concluídas</option>
											<option value="pendente">Pendentes</option>
										</select>
										<select name="categoria" id="categoria">
											<option value="todas">Todas</option>
											<option value="rotina">Tarefa de rotina</option>
											<option value="longoprazo">Tarefa de longo prazo</option>
											<option value="manutencao">Tarefa de manutenção</option>
											<option value="prioritaria">Tarefa prioritária</option>
											<option value="criativa">Tarefa criativa</option>
											<option value="pesquisa">Tarefa de pesquisa</option>
											<option value="aprendizado">Tarefa de aprendizado</option>
											<option value="administrativa">Tarefa administrativa</option>
											<option value="colaboracao">Tarefa de colaboração</option>
										</select>
										<button type="submit" onclick="Filtrar()">Filtrar</button>
									</form>
								
								

								<?php foreach($tarefas as $indice => $tarefa) { ?>
									<?php if($tarefa->status == 'pendente' || $tarefa->status == 'realizado') { ?>
										<div class="row mb-3 d-flex align-items-center tarefa">
										<div class="col-sm-2" id="tarefa_<?= $tarefa->id ?>">
											<span class="tarefa-titulo"><?= $tarefa->tarefa ?></span> <?= $tarefa->status  ?> 
											<?php if($tarefa->status == 'realizado') { ?>
											<button class="btn btn-secondary" onclick="arquivarTarefa(<?= $tarefa->id ?>)">Arquivar Tarefa Concluída</button>
											<?php } ?>
										</div>
										<div class="col-sm-1 mt-2">
											<?php if($tarefa->status == 'pendente') { ?>
											<p class="tarefa-data"><?= date('d/m/Y', strtotime($tarefa->data_limite)) ?></p>
											<?php } ?>
										</div>
										<div class="col-sm-1 mt-2">
											<?php if($tarefa->status == 'pendente') { ?>
											<p class="tarefa-categoria"><?= $tarefa->categoria ?></p>
											<?php } ?>
										</div>
										<div class="col-sm-1 mt-2">
											<?php if($tarefa->status == 'pendente') { ?>
											<p class="tarefa-prioridade <?= $tarefa->prioridade == 'alta' ? 'alta' : ($tarefa->prioridade == 'media' ? 'media' : 'baixa') ?>"><?= $tarefa->prioridade ?></p>
											<?php } ?>
										</div>
										<div class="col-sm-1 mt-2">
											<?php if($tarefa->status == 'pendente') { ?>
											<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
											<?php } ?>
										</div>
										<div class="col-sm-1 mt-2">
											<?php if($tarefa->status == 'pendente') { ?>
											<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>
											<?php } ?>
										</div>
										<div class="col-sm-1 mt-2">
											<?php if($tarefa->status == 'pendente') { ?>
											<i class="fas fa-check-square fa-lg text-success" onclick="TarefaRealizada(<?= $tarefa->id ?>)"></i>
											<?php } ?>
										</div>										
										<div class="col-sm-1 mt-2 prazo-container">
											<?php if($tarefa->status == 'pendente') { ?>
											<?php 
												$today = date('Y-m-d');												
												if($tarefa->data_limite <= $today) {
												// Prazo expirado
												echo '<span class="text-danger prazo">Prazo expirado!</span>';
												} else if($tarefa->data_limite <= date('Y-m-d', strtotime('+7 days'))) {
												// Prazo próximo
												echo '<span class="text-warning prazo">Prazo próximo!</span>';
												}
											?>
											<?php } ?>
										
										</div>
										</div>
									<?php } ?>
								<?php } ?>
								
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>