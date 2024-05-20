<div class="page-title"> 
    <h3 class="title">Clientes</h3> 
</div>

<? if (isset($alert) && isset($message)) : ?>
<div class="alert alert-<?=$alert?>" role="alert"><?=$message?></div>
<? endif; ?>

<div class="panel">
            
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="m-b-30">
                    <a href="<?=base_url()?>clientes/incluir" id="addToTable" class="btn btn-primary waves-effect waves-light">Novo cliente <i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <?php if ($items) : ?>
        <table class="table table-bordered table-striped" id="datatable-editable">
            <thead>
                <tr>
                    <th width="8%">ID</th>
                    <th width="100">Data cadastro</th>
                    <th>Razão social/Nome</th>
                    <th width="12%">CNPJ/CPF</th>
                    <th width="20%">E-mail</th>
                    <th width="12%">Status</th>
                    <th width="10%">Contratos</th>
                    <th width="10%">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item) : ?>
                <tr class="gradeX">
                    <td><?=$item->number_contract?></td>
                    <td><?=dataMySQLtoPT($item->created_at)?></td>
                    <td>
                        <?=($item->type == 'pj') ? $item->trade_name : $item->name?>
                    </td>
                    <td><?=$item->document?></td>
                    <td><?=$item->email?></td>
                    <td><?=$item->status_name?></td>
                    <td><a href="<?=base_url().'contratos/cliente/'.$item->id?>"><span class="label label-primary">visualizar</span></a></td>
                    <td class="actions">
                        <a href="<?=base_url().'clientes/editar/'.$item->id?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                        <a href="<?=base_url().'contratos/cliente/'.$item->id?>/last" class="on-default"><i class="fa fa-print"></i></a>
                        <a href="javascript:;" data-id="<?=$item->id?>" data-href="<?=base_url().'clientes/delete'?>" class="on-default remove-row" id="btnDelete"><i class="fa fa-trash-o"></i></a>
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