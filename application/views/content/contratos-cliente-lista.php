<div class="page-title">
	<h3 class="title">Cliente: <?=$cliente->name?></h3>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="m-b-30">
			<a href="<?=base_url().'contratos/incluir/'.$cliente->id?>" id="addToTable" class="btn btn-primary waves-effect waves-light">Novo contrato <i class="fa fa-plus"></i></a>
		</div>
	</div>
</div>
<div class="panel-group">

    <? if ($contratos) : ?>

    <? foreach ($contratos as $contrato) : ?>

    <div class="panel panel-default">

            <div class="panel-heading contratos">
                <h4 class="panel-title">
                    <a href="#contrato-<?=$contrato->id?>">
                    Contrato #<?=$contrato->number?>
                    </a>
                </h4>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <label for="exampleInputEmail1">Status: </label> <span class="label label-default"><?=$contrato->name_status?></span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <label for="exampleInputEmail1">Cobrador: </label> <span class="label label-default"><?=$contrato->name_collector?></span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <label for="exampleInputEmail1">Valor total</label> <span class="label label-default"><?=money_format('%n',$contrato->amount)?></span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <a href="<?=base_url().'contratos/cliente/'.$contrato->id_client.'/'.$contrato->id?>"><span class="label label-primary">abrir</span></a>
                </div>
            </div>
    </div>

    <? endforeach; ?>

    <? else : ?>

    <div class="alert">Nenhum contrato para o cliente.</div>

    <? endif;?>