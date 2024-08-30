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
			
			.tarefa-titulo {
				padding-right: 15px;
				font-weight: bold;
				color: #333;
			}
			.tarefa-data {
				padding-right: 15px;
				font-size: 14px;
				color: #FF4D80;
			}

			.tarefa-categoria {
				padding-right: 15px;
				font-size: 14px;
				color: #ECC30B;
			}
			.tarefa-prioridade{
				padding-right: 15px;
				font-size: 14px;
				color: #272635;
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
										<div class="col-sm-6" id="tarefa_<?= $tarefa->id ?>">
											<span class="tarefa-titulo"><?= $tarefa->tarefa ?></span>
										</div>
										<div class="col-sm-3 mt-2 d-flex justify-content-between">
											<p class="tarefa-data">Prazo: <?= $tarefa->data_limite?></p>
											<p class="tarefa-categoria">Categoria: <?= $tarefa->categoria?></p>
											<p class="tarefa-prioridade">Prioridade: <?= $tarefa->prioridade ?></p>
											<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
											<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>
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