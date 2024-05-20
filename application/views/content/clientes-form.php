<div class="page-title"> 
    <h3 class="title">Cliente</h3> 
</div>

<? if (isset($alert) && isset($message)) : ?>
<div class="alert alert-<?=$alert?>" role="alert"><?=$message?></div>
<? endif; ?>

<form role="form" method="post" action="<?=base_url()?>clientes/post" enctype="multipart/form-data">

    <div class="row">
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Novo cliente</h3></div>

                <div class="panel-body">
                    
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label for="is_published">Publicado</label>
                            <select class="form-control" name="is_published">
                                    <option <?=(isset($item) && $item->is_published == 'Sim') ? 'selected' : ''?> value="Sim">Sim</option>
                                    <option <?=(isset($item) && $item->is_published == 'Não') ? 'selected' : ''?> value="Não">Não</option>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="id_status">Status</label>
                            <select class="form-control" name="id_status" required>
                                <option value="">Selecione...</option>
                                <? if ($status) : ?>
                                <?php foreach($status as $status_item) : ?>
                                <option 
                                    value="<?=$status_item->id?>" 
                                    <?=(isset($item) && $item->id_status == $status_item->id) ? 'selected' : ''?> 
                                    <?=(!isset($item) && $status_item->default_item == 1) ? 'selected' : ''?>>
                                    <?=$status_item->name?>
                                </option>
                                <? endforeach; ?> 
                                <? endif; ?>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="type">Tipo</label>
                            <select class="form-control" name="type" id="frmType">
                                <option <?=(isset($item) && $item->type == 'pj') ? 'selected' : ''?> value="pj">Pessoa Jurídica</option>
                                <option <?=(isset($item) && $item->type == 'pf') ? 'selected' : ''?> value="pf">Pessoa Física</option>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="product">Produto</label>
                            <select class="form-control" name="product" required>
                                <option value="">Selecione...</option>
                                <? if ($produtos) : ?>
                                <?php foreach($produtos as $produto_item) : ?>
                                <option 
                                    value="<?=$produto_item->code?>" 
                                    <?=(isset($item) && $item->product == $produto_item->code) ? 'selected' : ''?> 
                                    <?=(!isset($item) && $produto_item->default_item == 1) ? 'selected' : ''?>>
                                    <?=$produto_item->name?>
                                </option>
                                <? endforeach; ?> 
                                <? endif; ?>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="cdrom">CD-ROM</label>
                            <select class="form-control" name="cdrom" required>
                                    <option value="">Selecione...</option>
                                    <option 
                                        <?=(isset($item) && $item->cdrom == 'Enviado') ? 'selected' : ''?> 
                                        value="Enviado">
                                        Enviado
                                    </option>
                                    <option 
                                        <?=(isset($item) && $item->cdrom == 'Não enviado') ? 'selected' : ''?> 
                                        <?=(!isset($item)) ? 'selected' : ''?> 
                                        value="Não enviado">
                                        Não enviado
                                    </option>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label for="cdrom">Destaque</label>
                            <select class="form-control" name="featured" required>
                                    <option value="">Selecione...</option>
                                    <option 
                                        <?=(isset($item) && $item->featured == 1 || (!isset($item))) ? 'selected' : ''?> 
                                        value="1">
                                        Sim
                                    </option>
                                    <option 
                                        <?=(isset($item) && $item->featured == 0) ? 'selected' : ''?> 
                                        <?=(!isset($item)) ? 'selected' : ''?> 
                                        value="0">
                                        Não
                                    </option>
                            </select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="id_categoria">Categoria</label>
                            <select class="form-control" name="id_categoria" required>
                                    <option value="">Selecione...</option>
                                    <? if ($categorias) : ?>
                                    <?php foreach($categorias as $categoria_item) : ?>
                                    <option value="<?=$categoria_item->id?>" <?=(isset($item) && $item->id_category == $categoria_item->id) ? 'selected' : ''?>><?=$categoria_item->name?></option>
                                    <? endforeach; ?> 
                                    <? endif; ?>
                            </select>
                        </div>

                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col-->
    </div> <!-- End row -->


    <div class="row">
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                        <div class="col-xs-12 col-sm-12 col-md-9">
                            <label for="frmTradeName" id="labelTradeName">Razão social</label>
                            <input type="text" class="form-control" id="frmTradeName" name="trade_name" value="<?=(isset($item)) ? $item->trade_name : ''?>" required>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="frmDocument" id="labelDocument">CNPJ</label>
                            <input type="text" class="form-control" id="frmDocument" name="document" value="<?=(isset($item)) ? $item->document : ''?>" required>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-7">
                            <label for="frmName" id="labelName">Nome fantasia</label>
                            <input type="text" class="form-control" id="frmName" name="name" value="<?=(isset($item)) ? $item->name : ''?>" required>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <label for="logo">Logo</label>
                            <? if (isset($item) && $logo) : ?>
                            <div class="container-logo">
                                <img src="<?=$logo?>" class="responsive">
                                <a href="javascript:;" data-id="<?=$item->id?>" data-href="<?=base_url().'clientes/logo/delete/'.$item->id?>" class="on-default remove-row" id="btnDeleteFile"><i class="fa fa-trash-o"></i></a>
                            </div>
                            <? else : ?>
                            <input type="file" name="logo" class="form-control">
                            <? endif ; ?>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="frmZipcode">CEP</label>
                            <input type="text" class="form-control" id="frmZipcode" name="zipcode" value="<?=(isset($item)) ? $item->zipcode : ''?>" data-mask="00000-000">
                        </div>
                            
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <label for="address">Endereço</label>
                            <input type="text" class="form-control" name="address" value="<?=(isset($item)) ? $item->address : ''?>">
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="address_number">Número</label>
                            <input type="text" class="form-control" name="address_number" value="<?=(isset($item)) ? $item->address_number : ''?>">
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label for="address_complement">Comp</label>
                            <input type="text" class="form-control" name="address_complement" value="<?=(isset($item)) ? $item->address_complement : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label for="neighborhood">Bairro</label>
                            <input type="text" class="form-control" name="neighborhood" value="<?=(isset($item)) ? $item->neighborhood : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="city">Cidade</label>
                            <input type="text" class="form-control" name="city" value="<?=(isset($item)) ? $item->city : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label for="state">UF</label>
                            <input type="text" class="form-control" maxlength="2" name="state" value="<?=(isset($item)) ? $item->state : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="phone_number_1">Telefone 1</label>
                            <input type="text" class="form-control sp_celphones" name="phone_number_1" value="<?=(isset($item)) ? $item->phone_number_1 : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="phone_number_2">Telefone 2</label>
                            <input type="text" class="form-control sp_celphones" name="phone_number_2" value="<?=(isset($item)) ? $item->phone_number_2 : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="email">E-mail</label>
                            <input type="text" class="form-control" name="email" value="<?=(isset($item)) ? $item->email : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="website">Website</label>
                            <input type="text" class="form-control" name="website" value="<?=(isset($item)) ? $item->website : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="billing_address_type">Endereço cobrança</label>
                            <select class="form-control" name="billing_address_type" id="frmBillingAddressType">
                                <option <?=(isset($item) && $item->billing_address_type == 'O mesmo') ? 'selected' : ''?> value="O mesmo">O mesmo</option>
                                <option <?=(isset($item) && $item->billing_address_type == 'Outro') ? 'selected' : ''?> value="Outro">Outro</option>
                            </select>
                        </div>

                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col-->
    </div> <!-- End row -->


    <div class="row block-billing">
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Endereço de cobrança</h3></div>

                <div class="panel-body">

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="frmBillingZipcode">CEP</label>
                            <input type="text" class="form-control" id="frmBillingZipcode" name="billing_zipcode" value="<?=(isset($item)) ? $item->billing_zipcode : ''?>" data-mask="00000-000">
                        </div>
                            
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <label for="billing_address">Endereço</label>
                            <input type="text" class="form-control" name="billing_address" value="<?=(isset($item)) ? $item->billing_address : ''?>" readonly>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="billing_address_number">Número</label>
                            <input type="text" class="form-control" name="billing_address_number" value="<?=(isset($item)) ? $item->billing_address_number : ''?>">
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label for="billing_address_complement">Comp</label>
                            <input type="text" class="form-control" name="billing_address_complement" value="<?=(isset($item)) ? $item->billing_address_complement : ''?>">
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label for="billing_neighborhood">Bairro</label>
                            <input type="text" class="form-control" name="billing_neighborhood" value="<?=(isset($item)) ? $item->billing_neighborhood : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="billing_city">Cidade</label>
                            <input type="text" class="form-control" name="billing_city" value="<?=(isset($item)) ? $item->billing_city : ''?>" readonly>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label for="billing_state">UF</label>
                            <input type="text" class="form-control" name="billing_state" value="<?=(isset($item)) ? $item->billing_state : ''?>" readonly>
                        </div>

                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col-->
    </div> <!-- End row -->


    <div class="row">
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">                             

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="frmAuthorizerName">Nome do autorizante</label>
                            <input type="text" class="form-control" id="frmAuthorizerName" name="authorizer_name" value="<?=(isset($item)) ? $item->authorizer_name : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="authorizer_phone_number">Telefone</label>
                            <input type="text" class="form-control sp_celphones" name="authorizer_phone_number" value="<?=(isset($item)) ? $item->authorizer_phone_number : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <label for="authorizer_role">Cargo</label>
                            <input type="text" class="form-control" name="authorizer_role" value="<?=(isset($item)) ? $item->authorizer_role : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="authorizer_cpf">CPF</label>
                            <input type="text" class="form-control" name="authorizer_cpf" data-mask="000.000.000-00" value="<?=(isset($item)) ? $item->authorizer_cpf : ''?>">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <label for="authorizer_rg">RG</label>
                            <input type="text" class="form-control" name="authorizer_rg" value="<?=(isset($item)) ? $item->authorizer_rg : ''?>">
                        </div>

                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col-->
    </div> <!-- End row -->


    <div class="row">
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label for="comments">Observações</label>
                            <textarea class="form-control" rows="5" name="comments"><?=(isset($item)) ? $item->comments : ''?></textarea>
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