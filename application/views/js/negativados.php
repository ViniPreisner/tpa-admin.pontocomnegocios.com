<!-- Mask Money -->
<script src="<?=asset_url()?>js/jquery.maskMoney.js"></script>
<script src="<?=asset_url()?>lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script>

$(document).ready(function(){

    $(".br-currency").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });

    $('#frmNoteDate').datetimepicker({
        format: 'L',
        locale: 'pt-BR'
    });
    $('#frmNoteTime').datetimepicker({
        format: 'LT',
        locale: 'pt-BR'
    });

    $('#frmDocument').mask('00.000.000/0000-00', {reverse: true});

    /* delete */
    $("a[id*='btnDelete']").click(function(){
        var me = $(this);
        var strUrl = $(me).data('href');
        var id = $(me).data('id');
        var indexRow = $(me).parent().parent().index();

        swal({
            title: 'Atenção',
            text: "Você está prestes a deletar este registro, quer continuar?",
            type: "warning",
            showCancelButton: true,
            closeOnCancel: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: "Sim",
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true
        }, function() {
            $.ajax({
                type: "POST",
                data: { id: id },
                url: strUrl,
                success: function(data) {}
            })
            .done(function(data) {

                    var strMsg = '';
                        var type = 'success';
                        if (data.success) {
                            $("#datatable-editable > tbody tr:eq(" + indexRow + ")").remove();
                            swal(data.title, data.message, "success");
                        }
                        else {
                            swal(data.title, data.message, "error");
                    }

            })
            .error(function(data) {
                swal("Oops", "Não foi possível se comunicar com o servidor!", "error");
            });
        });
    });
    /* fim delete */

});

</script>