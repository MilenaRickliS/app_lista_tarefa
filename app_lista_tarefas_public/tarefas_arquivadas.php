<?php

	require 'tarefa_controller.php';

?>

<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<link rel="stylesheet" href="css/estilo.css">

		<style>
			.tarefa-arquivada {
				background-color: #f7f7f7;
				padding: 15px;
				border-bottom: 1px solid #ddd;
			}

			.tarefa-titulo {
				font-weight: bold;
				color: #333;
			}

			.tarefa-data {
				font-size: 14px;
				color: #666;
			}

			.tarefa-categoria {
				font-size: 14px;
				color: #999;
			}

			.fa-archive {
				font-size: 24px;
				margin-top: 10px;
			}

		</style>
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
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item"><a href="todas_tarefas.php">Todas tarefas</a></li>
						<li class="list-group-item active"><a href="#">Tarefas Arquivadas</a></li>
					</ul>
				</div>

				<div class="col-md-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Tarefas arquivadas</h4>
								<hr />

								<?php foreach($tarefas as $indice => $tarefa) { 
									if($tarefa->status == 'arquivado') {?>
									<div class="row mb-3 d-flex align-items-center tarefa-arquivada">
										<div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>">
											<span class="tarefa-titulo"><?= $tarefa->tarefa ?></span>
											<span class="tarefa-data"><?= $tarefa->data_limite?></span>
											<span class="tarefa-categoria"><?= $tarefa->categoria?></span>
											
										</div>
										<div class="col-sm-3 text-right">
											<i class="fas fa-archive fa-lg text-muted"></i>
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