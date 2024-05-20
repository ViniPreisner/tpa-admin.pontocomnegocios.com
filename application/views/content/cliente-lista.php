<div class="page-title"> 
<h3 class="title">Clientes</h3> 
</div>


<div class="panel">
            
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="m-b-30">
                    <a href="<?=base_url()?>clientes/incluir" id="addToTable" class="btn btn-primary waves-effect waves-light">Novo cliente <i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped" id="datatable-editable">
            <thead>
                <tr>
                    <th width="8%">ID</th>
                    <th>Razão social</th>
                    <th width="12%">CNPJ</th>
                    <th width="20%">E-mail</th>
                    <th width="12%">Status</th>
                    <th width="10%">Contratos</th>
                    <th width="10%">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr class="gradeX">
                    <td>100</td>
                    <td>Ana Costa Plano de Saúde</td>
                    <td>01.000.000/0001-99</td>
                    <td>email@empresa.com.br</td>
                    <td>Mantido</td>
                    <td><a href="<?=base_url()?>clientes/contratos/"><span class="label label-primary">visualizar</span></a></td>
                    <td class="actions">
                        <a href="<?=base_url()?>clientes/detalhes/"><i class="ion-android-search"></i></a>
                        <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>



        <div class="btn-group m-b-10" style="padding-top: 20px;">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-default">2</button>
        </div>

    </div>
    <!-- end: page -->

</div> <!-- end Panel -->