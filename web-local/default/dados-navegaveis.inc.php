<link rel="stylesheet" href=/address-for-all/web/resources/css/api.css"> <!-- >> Estilos do botão em caso de solicitação por donor -->
<link rel="stylesheet" href="/address-for-all/web/resources/css/dados-navegaveis.css">
<section class="main-api" style="">
	<h1>Mapa de Dados</h1>
	<div>
		<h2>Escolha a região:</h2>
		<ul class="menu-uf" id="menu-uf"></ul></br>
	</div>
	<div>
		<h2>Escolha o tipo de dado:</h2>
		<input checked type="radio" id="preservado" name="tipododado" value="preservado">
		<label for="preservado">Preservado</label></br>
		<input disabled type="radio" id="filtrado" name="tipododado" value="filtrado">
		<label for="filtrado">Filtrado</label></br>
		<input disabled type="radio" id="consolidado" name="tipododado" value="consolidado">
		<label for="consolidado">Consolidado</label></br>
	</div>
	<div id="entidade">
		<h2>Escolha a entidade:</h2>
		<input checked type="radio" id="opt_jurisdiction" name="entidade" value="jurisdiction">
		<label for="opt_jurisdiction">Jurisdiction</label></br>
		<input type="radio" id="opt_donor" name="entidade" value="donor">
		<label for="opt_donor">Donor</label></br>
	</div>
	</br>
	<div class="grid-container">
		<div class="grid-child"><h2>&#x1F5FA; Gráfico</h2>
			<?php include 'default/mapa-do-brasil.inc.php';?>
		</div>

		<div class="grid-child"><h2>&#x1F5D2; Matriz</h2>
			<table id="jurisdiction" class="display responsive nowrap" style="display: none;">
				<thead>
					<tr>
						<th>Name</th>
						<th>Abbrev</th>
						<th>Wikidata</th>
						<th>DDD</th>
						<th>Info</th>    
					</tr> 
				</thead>
			</table>
			<table id="donor" class="display responsive nowrap" style="display: none;">
				<thead>
					<tr>
						<th>Scope</th>
						<th>ShortName</th>
						<th>Id Wikidata</th>
						<th>Donations</th>    
					</tr> 
				</thead>
			</table>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="/address-for-all/web/resources/js/dados-navegaveis.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/sp-1.1.1/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"/>

</section>
<!-- END MAIN CONTAINER  -->
