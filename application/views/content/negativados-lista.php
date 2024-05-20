<div class="page-title"> 
    <h3 class="title">Negativados</h3> 
</div>

<? if (isset($alert) && isset($message)) : ?>
<div class="alert alert-<?=$alert?>" role="alert"><?=$message?></div>
<? endif; ?>

<div class="panel">
            
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="m-b-30">
                    <a href="<?=base_url()?>negativados/incluir" id="addToTable" class="btn btn-primary waves-effect waves-light">Novo negativado <i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <?php if ($items) : ?>
        <table class="table table-bordered table-striped" id="datatable-editable">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th width="12%">CNPJ/CPF</th>
                    <th width="20%">Empresa Credora</th>
                    <th width="12%">Negativado</th>
                    <th width="10%">Valor</th>
                    <th width="100">Data cadastro</th>
                    <th width="10%">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item) : ?>
                <tr class="gradeX">
                    <td><?=$item->id?></td>
                    <td><?=formatCnpjCpf($item->document)?></td>
                    <td><?=$item->creditor?></td>
                    <td><?=($item->negative == 1) ? 'Sim' : 'Não'?></td>
                    <td><?=money_format('%n',$item->amount)?></td>
                    <td><?=dataMySQLtoPT($item->created_at)?></td>
                    <td class="actions">
                        <a href="<?=base_url().'negativados/editar/'.$item->id?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:;" data-id="<?=$item->id?>" data-href="<?=base_url().'negativados/delete'?>" class="on-default remove-row" id="btnDelete"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>  
                <? endforeach; ?>   
            </tbody>
        </table>
        <?php else : ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="m-b-10 text-center">
                    Nenhum registro encontrado.
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?=$pagination?>

    </div>
    <!-- end: page -->

</div> <!-- end Panel -->