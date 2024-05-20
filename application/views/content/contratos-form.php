<div class="page-title"> 
    <h3 class="title">Contratos</h3> 
</div>


<div class="row">
    <!-- Basic example -->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Novo contrato</h3></div>
            <div class="panel-body">
                <form role="form" method="post" action="<?=base_url()?>contratos/post">
                    
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <label for="exampleInputEmail1">Cliente</label>
                        <select class="form-control" name="id_client" required>
                            <option value="">Selecione...</option>
                            <? if ($clientes) : ?>
                            <?php foreach($clientes as $clientes_item) : ?>
                            <?
                            $selected = '';
                            if ($id_client && $id_client === $clientes_item->id):
                                $selected = 'selected';
                            endif;
                            ?>
                            <option value="<?=$clientes_item->id?>" <?=$selected?>>
                                <?=($clientes_item->type == 'pj') ? $clientes_item->trade_name : $clientes_item->name?>
                            </option>
                            <? endforeach; ?> 
                            <? endif; ?>
                        </select>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <label for="number">Nº do contrato</label>
                        <input type="text" class="form-control" maxlength="15" name="number" value="<?=($contrato) ? $contrato->number : ''?>" required>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control" name="id_status" required>
                            <option value="">Selecione...</option>
                            <? if ($status) : 
                                var_dump($contrato);?>
                            <?php foreach($status as $status_item) :
                                if (isset($contrato)) :
                                    $selected = ($contrato->id_status == $status_item->id) ? 'selected' : '';
                                else :
                                    $selected = '';
                                endif;
                            ?>
                            <option value="<?=$status_item->id?>" <?=$selected?>><?=$status_item->name?></option>
                            <? endforeach; ?> 
                            <? endif; ?>
                        </select>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <label for="exampleInputEmail1">Cobrador</label>
                        <select class="form-control" name="id_collector" required>
                            <option value="">Selecione...</option>
                            <? if ($cobradores) : ?>
                            <?php foreach($cobradores as $cobradores_item) :
                                if (isset($contrato)) :
                                    $selected = ($contrato->id_collector == $cobradores_item->id) ? 'selected' : '';
                                else :
                                    $selected = '';
                                endif;
                            ?>
                            <option value="<?=$cobradores_item->id?>" <?=$selected?>><?=$cobradores_item->name?></option>
                            <? endforeach; ?> 
                            <? endif; ?>
                        </select>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-2">
                        <label for="value">Valor total</label>
                        <input type="text" class="form-control br-currency" id="frmTotalValue" name="amount" maxlength="15" value="<?=($contrato) ? money_format('%n',$contrato->amount) : ''?>" required>
                    </div>


                    


                </div>

                <div class="panel-body" style="margin: 12px;">

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
                <?
                $i = 1;
                $first = 'first';
                while ($i <= 12) {
                ?>
                <tr class="gradeX">
                    <td><?=$i?><input type="hidden" name="quote_id" value=""></td>
                    <td><input type="text" class="form-control quota-value" name="quote_amount[]" maxlength="15" required data-readonly></td>
                    <td><input type="text" class="form-control due-date datepicker <?=$first?>" name="due_date[]" required value=""></td>
                    <td>Em aberto</td>
                    <td>
                        <input type="text" class="form-control" id="frmObs" name="obs[]" maxlength="150" value="">
                    </td>
                    <td>
                        <select class="form-control" name="payment_method[]" required>
                                <option>Depósito</option>
                                <option>Boleto</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control payday datepicker <?=$first?>" name="payday[]" value="" readonly></td>
                    <td><input type="text" class="form-control br-currency" name="quote_amount_paid[]" maxlength="15"></td>
                </tr>
                <?
                $i++;
                $first = '';
                }
                ?>
            </tbody>
        </table>

        <br>

        <input type="hidden" name="id" value="">
        <button class="btn btn-icon btn-success m-b-5"> <i class="ion-plus-round"></i> <span>Salvar informações</span></button>

                </form>
            </div><!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col-->

</div> <!-- End row -->
