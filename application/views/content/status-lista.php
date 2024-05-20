<div class="page-title"> 
    <h3 class="title">Status</h3> 
</div>

<? if (isset($alert) && isset($message)) : ?>
<div class="alert alert-<?=$alert?>" role="alert"><?=$message?></div>
<? endif; ?>

<div class="panel">
            
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="m-b-30">
                    <a href="<?=base_url()?>status/incluir" id="addToTable" class="btn btn-primary waves-effect waves-light">Novo status <i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <?php if ($items) : ?>
        <table class="table table-bordered table-striped" id="datatable-editable">
            <thead>
                <tr>
                    <th width="8%">ID</th>
                    <th width="20%">Nome do status</th>
                    <th>Observações</th>
                    <th width="5%">Status</th>
                    <th width="5%">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item) : ?>
                <tr class="gradeX">
                    <td><?=$item->id?></td>
                    <td><?=$item->name?></td>
                    <td><?=$item->description?></td>
                    <td>
                        <? if($item->status == 1) : ?>
                        <span class="label label-success">ativo</span>
                        <? else : ?>
                        <span class="label label-danger">inativo</span>
                        <? endif;?>
                    </td>
                    <td class="actions">
                        <a href="<?=base_url().'status/editar/'.$item->id?>" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:;" data-id="<?=$item->id?>" data-href="<?=base_url().'status/delete'?>" class="on-default remove-row" id="btnDelete"><i class="fa fa-trash-o"></i></a>
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