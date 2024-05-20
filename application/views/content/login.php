        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading" style="background-color: #fff;">
                   <h3 class="text-center m-t-10">
                       Efetuar Login em <strong>TPA</strong>
                       <img src="<?=asset_url()?>img/logo.png" alt="logo" style="max-width: 170px;">
                   </h3>
                </div> 

                <form class="form-horizontal m-t-40" method="post" action="<?php echo base_url(); ?>login/auth">
                                            
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="txtbxUsuario" name="frmEmail" class="form-control" placeholder="Usuário" required>
                        </div>
                    </div>
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            <input type="password" id="txtbxSenha" name="frmPass" class="form-control" placeholder="Senha" required>
                        </div>
                    </div>

                    
                    
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Entrar</button>
                        </div>
                    </div>
                    
                </form>

            </div>
        </div>