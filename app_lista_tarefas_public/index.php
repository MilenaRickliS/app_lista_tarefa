<?php

	$acao = 'TarefasPendentes';
	require 'tarefa_controller.php';

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
				flex-basis: 14.28%; 
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


		</style>


		<script>
			function editar(id, txt_tarefa) {

				//criar um form de edição
				let form = document.createElement('form')
				form.action = 'index.php?pag=index&acao=atualizar'
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
				location.href = 'index.php?pag=index&acao=remover&id='+id;
			}

			function TarefaRealizada(id) {
				location.href = 'index.php?pag=index&acao=TarefaRealizada&id='+id;
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
				<div class="col-md-3 menu">
					<ul class="list-group">
						<li class="list-group-item active"><a href="#">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item"><a href="todas_tarefas.php">Todas tarefas</a></li>
						<li class="list-group-item"><a href="tarefas_arquivadas.php">Tarefas Arquivadas</a></li>
					</ul>
				</div>

				<div class="col-md-9">
				<div class="container pagina">
					<div class="row">
					<div class="col">
						<h4>Tarefas pendentes</h4>
						<hr />

						<?php foreach($tarefas as $indice => $tarefa) { 
						if($tarefa->status == 'pendente') {?>
						<div class="row mb-3 d-flex align-items-center tarefa">
						<div class="col-sm-2" id="tarefa_<?= $tarefa->id ?>">
							<span class="tarefa-titulo"><?= $tarefa->tarefa ?></span>
						</div>
						<div class="col-sm-1 mt-2">
							<p class="tarefa-data"><?= date('d/m/Y', strtotime($tarefa->data_limite)) ?></p>
						</div>
						<div class="col-sm-1 mt-2">
							<p class="tarefa-categoria"><?= $tarefa->categoria ?></p>
						</div>
						<div class="col-sm-1 mt-2">
							<p class="tarefa-prioridade <?= $tarefa->prioridade == 'alta' ? 'alta' : ($tarefa->prioridade == 'media' ? 'media' : 'baixa') ?>"><?= $tarefa->prioridade ?></p>
						</div>
						<div class="col-sm-1 mt-2">
							<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
						</div>
						<div class="col-sm-1 mt-2">
							<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>
						</div>
						<div class="col-sm-1 mt-2">
							<i class="fas fa-check-square fa-lg text-success" onclick="TarefaRealizada(<?= $tarefa->id ?>)"></i>
						</div>
						</div>

						<?php } }?>

					</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</body>
</html>