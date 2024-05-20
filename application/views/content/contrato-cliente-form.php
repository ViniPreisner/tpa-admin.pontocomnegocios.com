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

    <? if ($contrato) : ?>

    <div class="panel panel-default">

    <form id="formContrato-<?=$contrato->id?>" role="form" method="post" action="<?=base_url()?>contratos/post">

    <div class="panel-heading contratos">
        <h4 class="panel-title">
            Contrato # <input type="text" name="number" value="<?=$contrato->number?>" required>
        </h4>
    </div>
 
    <div id="contrato-<?=$contrato->id?>" class="">

        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="exampleInputEmail1">Status</label>
                <select class="form-control" name="id_status" required>
                    <? if ($status) : ?>
                    <?php foreach($status as $status_item) : ?>
                    <option value="<?=$status_item->id?>" <?=(isset($contrato) && $contrato->id_status == $status_item->id) ? 'selected' : ''?>><?=$status_item->name?></option>
                    <? endforeach; ?> 
                    <? endif; ?>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="exampleInputEmail1">Cobrador</label>
                <select class="form-control" name="id_collector" required>
                    <? if ($cobradores) : ?>
                    <?php foreach($cobradores as $cobradores_item) : ?>
                    <option value="<?=$cobradores_item->id?>" <?=(isset($contrato) && $contrato->id_collector == $cobradores_item->id) ? 'selected' : ''?>><?=$cobradores_item->name?></option>
                    <? endforeach; ?> 
                    <? endif; ?>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <label for="exampleInputEmail1">Valor total</label>
                <input type="text" class="form-control br-currency" id="frmTotalValue" name="amount" maxlength="15" value="<?=($contrato) ? money_format('%n',$contrato->amount) : ''?>" required>
            </div>
        </div>
        
        <div class="panel-body" style="margin: 12px;">
            <? if (isset($contrato->parcelas)) : ?>
            <table class="table table-bordered table-striped" id="datatable-editable">
                <thead>
                    <tr>
                        <th width="14%">Parcelamento</th>
                        <th width="14%">Valor</th>
                        <th width="14%">Vencimento</th>
                        <th>Status</th>
                        <th>Observação</th>
                        <th width="14%">Tipo de pagto</th>
                        <th width="14%">Data de pagto</th>
                        <th width="14%">Valor de pagto</th>
                    </tr>
                </thead>
                <tbody>
                    <? $i = 1;
                    $isRelease = false;
                    $readonlyForce = "";
                    foreach ($contrato->parcelas as $parcela) :
                        if ($parcela->status == "Cancelada") {
                            $disabled = "disabled";
                            $readonly = "readonly";
                            //$readonlyForce = "readonly";
                            $released = "disabled";
                            $noPointer = "data-readonly";
                            //$datepicker = "";
                            $datepicker = "datepicker";
                            //$datepickerRelease = "";
                            $datepickerRelease = "datepicker";
                            $brCurrency = "";
                            $brCurrencyRelease = "";
                            $payday = '';
                            $quote_amount = money_format('%n',$parcela->quote_amount);
                            $quote_amount_paid = money_format('%n',$parcela->quote_amount_paid);
                            $permitRelease = true;
                        } else if ($parcela->status == "Em aberto") {
                            $disabled = "";
                            $readonly = "";
                            //$readonlyForce = "readonly";
                            $released = "";
                            $noPointer = "";
                            //$datepicker = "";
                            $datepicker = "datepicker";
                            //$datepickerRelease = "";
                            $datepickerRelease = "datepicker";
                            $brCurrency = "br-currency";
                            $brCurrencyRelease = "";
                            $payday = '';
                            $quote_amount = money_format('%n',$parcela->quote_amount);
                            $quote_amount_paid = '';
                            $permitRelease = true;
                        } else if ($parcela->status == "Paga") {
                            $disabled = "disabled";
                            $readonly = "readonly";
                            //$readonlyForce = "readonly";
                            $released = "";
                            $noPointer = "data-readonly";
                            //$datepicker = "";
                            $datepicker = "datepicker";
                            //$datepickerRelease = "";
                            $datepickerRelease = "datepicker";
                            $brCurrency = "";
                            $brCurrencyRelease = "";
                            $payday = dataMySQLtoPT($parcela->payday);
                            $quote_amount = money_format('%n',$parcela->quote_amount);
                            $quote_amount_paid = money_format('%n',$parcela->quote_amount_paid);
                            $permitRelease = true;
                        }
                        // quitação
                        if ($parcela->quote_type == "Release") {
                            $disabled = "";
                            $readonly = "";
                            //$readonlyForce = "";
                            $released = "";
                            $noPointer = "";
                            $datepicker = "datepicker";
                            $datepickerRelease = "datepicker";
                            $brCurrency = "br-currency";
                            $brCurrencyRelease = "br-currency";
                            $payday = '';
                            $quote_amount = '';
                            $quote_amount_paid = '';
                            $isRelease = true;
                        }
                    ?>
                    <tr class="gradeX">
                        <td><?=$i?><input type="hidden" name="id_quote[]" value="<?=$parcela->id?>" <?=$released?>></td>
                        <td><input type="text" class="form-control <?=$brCurrencyRelease?>" name="quote_amount[]" value="<?=$quote_amount?>" <?=$readonlyForce?> <?=$released?> required></td>
                        <td><input type="text" class="form-control <?=$datepickerRelease?>" name="due_date[]" maxlength="10" value="<?=dataMySQLtoPT($parcela->due_date)?>" <?=$readonlyForce?> <?=$released?> required></td>
                        <td><?=$parcela->status?></td>
                        <td>
                            <input type="text" class="form-control" id="frmObs" name="obs[]" maxlength="150" value="<?=$parcela->obs?>">
                        </td>
                        <td>
                            <?if ($parcela->status == "Em aberto") : ?>
                            <select class="form-control" name="payment_method[]">
                                <option <?=($parcela->payment_method == 'Depósito') ? 'selected' : ''?>>Depósito</option>
                                <option <?=($parcela->payment_method == 'Boleto') ? 'selected' : ''?>>Boleto</option>
                            </select>
                            <? else : ?>
                            <input type="text" class="form-control" name="payment_method[]" value="<?=$parcela->payment_method?>" readonly <?=$released?>>
                            <? endif ; ?>
                        </td>
                        <td><input type="text" class="form-control <?=$datepicker?>" name="payday[]" value="<?=$payday?>" <? //=$readonly?> <? //=$released?>></td>
                        <td><input type="text" class="form-control <?=$brCurrency?>" name="quote_amount_paid[]" value="<?=$quote_amount_paid?>" <?=$readonly?> <?=$released?>></td>
                    </tr>
                    <? $i++; ?>
                    <? endforeach; ?>
                </tbody>
            </table>
            <? else : ?>
            <div class="alert">Nenhuma parcela no contrato.</div>
            <? endif;?>
        </div>
        
        <div class="panel-body" style="margin: 12px;">
            <input type="hidden" name="id" value="<?=$contrato->id?>">
            <!--<input type="hidden" name="number" value="<?=$contrato->number?>">-->
            <input type="hidden" name="id_client" value="<?=$cliente->id?>">
            <button type="submit" class="btn btn-icon btn-success m-b-5"> <i class="ion-plus-round"></i> <span>Salvar informações</span></button>
            <? //if (isset($isRelease) && $isRelease !== null && $isRelease !== false) : ?>
            <a href="<?=base_url().'contratos/incluir/'.$cliente->id.'/'.$contrato->id?>" class="btn btn-primary m-b-5"> <i class="ion-loop"></i> <span>Renovar contrato</span></a>
                <? if (isset($permitRelease) && $permitRelease) : ?>
                <a href="javascript:;" data-id="<?=$contrato->id?>" data-client="<?=$cliente->id?>" data-href="<?=base_url().'contratos/quitacao/'.$contrato->id?>" class="btn btn-info m-b-5 btnRelease"> <i class="ion-checkmark-round"></i> Quitar contrato</a>
                <? endif;?>
            <a href="javascript:;" data-id="<?=$contrato->id?>" data-href="<?=base_url().'contratos/delete'?>" class="btn btn-danger m-b-5 btnDelete"> <i class="ion-close"></i> Excluir contrato</a>
            <? //endif;?>
            <a href="<?=base_url().'contratos/visualizar/'.$contrato->id?>" class="btn btn-warning m-b-5"> <i class="ion-printer"></i> <span>Versão para impressão</span> </a>
        </div>
        
    </div>
    </form>

    </div>

    <? else : ?>

    <div class="alert">Contrato inexistente.</div>

    <? endif;?>