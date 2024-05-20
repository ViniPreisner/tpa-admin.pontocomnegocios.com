<div class="page-title"> 
    <h3 class="title">Negativados</h3> 
</div>

<? if (isset($alert) && isset($message)) : ?>
<div class="alert alert-<?=$alert?>" role="alert"><?=$message?></div>
<? endif; ?>

<form role="form" method="post" action="<?=base_url()?>negativados/post" enctype="multipart/form-data">

    <div class="row">
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default">
    
                <div class="panel-heading"><h3 class="panel-title">Novo negativado</h3></div>
    
                <div class="panel-body">

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="frmDocument" id="labelDocument">CNPJ</label>
                            <input type="text" class="form-control" id="frmDocument" name="document" value="<?=(isset($item)) ? $item->document : ''?>" required>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <label for="frmDocument" id="labelDocument">Razão Social</label>
                            <input type="text" class="form-control" id="frmDebtor" name="debtor" value="<?=(isset($item)) ? $item->debtor : ''?>" required>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label for="negative">Negativado</label>
                            <select class="form-control" name="negative">
                                    <option <?=(isset($item) && $item->negative == '1') ? 'selected' : ''?> value="1">Sim</option>
                                    <option <?=(isset($item) && $item->negative == '0') ? 'selected' : ''?> value="0">Não</option>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 block-pj">
                            <label for="frmCreditor" id="labelCreditor">Empresa credora</label>
                            <input type="text" class="form-control" id="frmCreditor" name="creditor" value="<?=(isset($item)) ? $item->creditor : ''?>" required>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="value">Data apontamento</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type="text" class="form-control" id="frmNoteDate" name="notedate" maxlength="10" value="<?=(isset($item)) ? dataMySQLtoPT($item->note_date) : ''?>" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="value">Hora apontamento</label>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type="text" class="form-control" id="frmNoteTime" name="notetime" maxlength="5" value="<?=(isset($item)) ? $item->note_time : ''?>" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="value">Valor total</label>
                            <input type="text" class="form-control br-currency" id="frmAmount" name="amount" maxlength="15" value="<?=(isset($item)) ? money_format('%n',$item->amount) : ''?>" required>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <? if (isset($item)) : ?>
                            <input type="hidden" name="id" value="<?=$item->id?>">
                            <? endif; ?>
                            <button type="submit" class="btn btn-success m-l-10">Cadastrar</button>
                        </div>

                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col-->
    </div> <!-- End row -->

</form>