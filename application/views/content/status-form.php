<div class="page-title"> 
    <h3 class="title">Status</h3> 
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Novo status</h3></div>
            <div class="panel-body">
                <form role="form" method="post" action="<?=base_url()?>status/post">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="name">Nome do status</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=(isset($item)) ? $item->name : ''?>" required>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <label for="description">Observações</label>
                        <input type="text" class="form-control" name="description" value="<?=(isset($item)) ? $item->description : ''?>" required>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" required>
                                <option <?=(isset($item) && $item->status == '1') ? 'selected' : ''?> value="1">Ativo</option>
                                <option <?=(isset($item) && $item->status == '0') ? 'selected' : ''?> value="0">Inativo</option>
                        </select>
                    </div>
                    <? if (isset($item)) : ?>
                    <input type="hidden" name="id" value="<?=$item->id?>">
                    <? endif; ?>
                    <button type="submit" class="btn btn-success m-l-10">Cadastrar</button>
                </form>
            </div><!-- panel-body -->
        </div> <!-- panel -->
    </div> <!-- col-->

</div> <!-- End row -->
