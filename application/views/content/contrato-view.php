<div class="page-title">
	<h3 class="title">Cliente</h3>
</div>
<div class="row" id="print-content">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-right"><img src="<?=$logo?>" alt="velonic" style="width: 120px;"></h4>
					</div>

						<div class="col-md-10 pull-right">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th width="25%">Status</th>
											<th width="25%">Cobrador</th>
											<th width="25%">Valor total</th>
											<th width="25%" style="text-align:center"><h4 style="margin:0">Contrato</h4></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?=$contrato->name_status?></td>
											<td><?=($contrato->name_collector == "") ? "Indefinido" : $contrato->name_collector?></td>
											<td><?=($contrato->amount == "") ? "Indefinido" : money_format('%n',$contrato->amount)?></td>
											<td style="text-align:center"><h4 style="margin:0"><?=$contrato->number?></strong></h4>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

				</div>
				<!-- <hr> -->
				<div class="row m-t-10">

					<div class="col-md-12">

						<address>
							<?=($cliente->trade_name !== '') ? '<strong>Razão social: </strong>'.$cliente->trade_name.'<br>': ''?>
							<?='<strong>Nome fantasia: </strong>'.$cliente->name.'<br>'?>
							<?=($cliente->phone_number_1 !== '') ? '<strong>Telefone 1: </strong>'.$cliente->phone_number_1: ''?>
							<?=($cliente->phone_number_2 !== '') ? ' | <strong>Telefone 2: </strong>'.$cliente->phone_number_2.'<br>': ''?>
							<?=($cliente->email !== '') ? '<strong>E-mail: </strong>'.$cliente->email: ''?>
							<?=($cliente->website !== '') ? ' <strong>Website: </strong>'.$cliente->website: ''?>
							<?=($cliente->document !== '') ? '<strong>CNPJ/CPF: </strong>'.$cliente->document.'<br>': ''?>
						</address>

					</div>

				</div>


				<div class="row m-t-10">

					<div class="col-md-12">

						<table style="width:100%;">

							<tr>

								<td width="50%">
									<address>
										<strong>Endereço comercial</strong><br>
										<?=($cliente->address !== '') ? $cliente->address : ''?>
										<?=($cliente->address_number !== '') ? ', '.$cliente->address_number : ''?>
										<?=($cliente->address_complement !== '') ? ' - ' . $cliente->address_complement : ''?>
										<?=($cliente->neighborhood !== '') ? ' - ' . $cliente->neighborhood : ''?>
										<br>
										<?=($cliente->zipcode !== '') ? 'CEP: '.$cliente->zipcode : ''?>
										<?=($cliente->city !== '') ? ' '.trim($cliente->city) : ''?>
										<?=($cliente->state !== '') ? '/' . $cliente->state : ''?>
										<br>
									</address>
								</td>

								<td width="50%">
									<address>
										<strong>Endereço de cobrança</strong><br>
										<? if ($cliente->billing_address_type == "O mesmo") : ?>
										O mesmo
										<? else : ?>
										<?=($cliente->billing_address !== '') ? $cliente->billing_address : ''?>
										<?=($cliente->billing_address_number !== '') ? ', '.$cliente->billing_address_number : ''?>
										<?=($cliente->billing_address_complement !== '') ? ' - ' . $cliente->billing_address_complement : ''?>
										<?=($cliente->billing_neighborhood !== '') ? ' - ' . $cliente->billing_neighborhood : ''?>
										<br>
										<?=($cliente->billing_zipcode !== '') ? 'CEP: '.$cliente->billing_zipcode : ''?>
										<?=($cliente->billing_city !== '') ? ' '.trim($cliente->billing_city) : ''?>
										<?=($cliente->billing_state !== '') ? '/' . $cliente->billing_state : ''?>
										<? endif; ?>
									</address>
								</td>

							</tr>

						</table>

					</div>

				</div>

				<div class="row">

					<div class="col-md-12">
					
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th width="15%">Tipo</th>
									<th width="15%">Status</th>
									<th width="20%">Produto</th>
									<th width="15%">CD-ROM</th>
									<th>Categoria</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?=($cliente->type == "pj") ? "Pessoa jurírica" : "Pessoa física"?></td>
										<td><?=$status->name?></td>
										<td><?=($produto) ? $produto->name : 'indefinido'?></td>
										<td><?=$cliente->cdrom?></td>
										<td><?=$categoria->name?></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>

				</div>

				
				<? if ($cliente->authorizer_name !== '') : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>Nome do autorizante</th>
									<th width="13%">Telefone</th>
									<th width="20%">Cargo</th>
									<th width="13%">CPF</th>
									<th width="13%">RG</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?=$cliente->authorizer_name?></td>
										<td><?=$cliente->authorizer_phone_number?></td>
										<td><?=$cliente->authorizer_role?></td>
										<td><?=$cliente->authorizer_cpf?></td>
										<td><?=$cliente->authorizer_rg?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<? endif ;?>

				<? if ($parcelas) : ?>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th width="8%">Parcela</th>
										<th width="13%">Valor</th>
										<th width="13%">Vencimento</th>
										<th width="6%">Status</th>
										<th width="17%">Obs</th>
										<th width="15%">Tipo de pagto</th>
										<th width="15%">Data de pagto</th>
										<th width="13%">Valor de pagto</th>
									</tr>
								</thead>
								<tbody>
									<? $i = 1 ?>
									<? foreach ($parcelas as $parcela) : ?>
									<tr>
										<td><?=$i?></td>
										<td><?=money_format('%n',$parcela->quote_amount)?></td>
										<td><?=dataMySQLtoPT($parcela->due_date)?></td>
										<td><?=$parcela->status?></td>
										<td><?=$parcela->obs?></td>
										<td><?=$parcela->payment_method?></td>
										<td><?=($parcela->payday !== null) ? dataMySQLtoPT($parcela->payday) : ''?></td>
										<td><?=money_format('%n',$parcela->quote_amount_paid)?></td>
									</tr>
									<? $i++ ?>
									<? endforeach ;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<? endif ; ?>
				<!-- <div class="row" style="border-radius: 0px;">
					<div class="col-md-3 col-md-offset-9">
					<p class="text-right"><b>Valor total:</b> R$ 4.500,00</p>
					</div>
					</div>
					<hr>
					-->
				<div class="hidden-print">
					<div class="pull-right">
						<a href="javascript:;" onclick="printContent();" class="btn btn-inverse"><i class="fa fa-print"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>