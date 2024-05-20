<script>

$(document).ready(function(){

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.sp_celphones').mask(SPMaskBehavior, spOptions);

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


    /* delete arquivo */
    $("a[id*='btnDeleteFile']").click(function(){
        var me = $(this);
        var strUrl = $(me).data('href');
        var id = $(me).data('id');

        swal({
            title: 'Atenção',
            text: "Você está prestes a excluir o logotipo, quer continuar?",
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

                            swal({title: data.title, text: data.message, type: "success"},
                            function(){ 
                                location.reload();
                            }
                );

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
    /* fim delete arquivo */


    $('#frmType').on('change', function() {
        var changed = this,
        check = changed.value.toLowerCase() === "pj";
        if (check) {
            $('.block-pj').show();
            $("#labelDocument").text('CNPJ');
            //$('#frmTradeName').prop("required", true);
            $("#labelTradeName").text('Razão Social');
            $('#frmName').removeAttr("required");
            $("#labelName").text('Nome fantasia');
            $('#frmDocument').mask('00.000.000/0000-00', {reverse: true});
        } else {
            $('.block-pj').hide();
            $("#labelDocument").text('CPF');
            //$('#frmTradeName').removeAttr("required");
            $("#labelTradeName").text('Nome');
            $('#frmName').prop("required", true);
            //$("#labelName").text('Nome');
            $('#frmDocument').mask('000.000.000-00', {reverse: true});
        }
        //$('.reason-other').toggle(check);
    }).change();

    $('#frmBillingAddressType').on('change', function() {
        var changed = this,
        check = changed.value.toLowerCase() === "outro";
        if (check) {
            $('.block-billing').show();
        } else {
            $('.block-billing').hide();
        }
        //$('.reason-other').toggle(check);
    }).change();

    /*
    $("#frmZipcode").blur(function(){
        var e = $(this).val();
        $.ajax({
                type: "GET",
                url: "https://api.postmon.com.br/v1/cep/" + e,
                success: function(e) {
                    $('input[name="address"]').val(e.logradouro),
                    //$('input[name="district"]').val(e.bairro),
                    $('input[name="city"]').val(e.cidade),
                    $('input[name="state"]').val(e.estado),
                    $('input[name="neighborhood"]').val(e.bairro),
                    $('input[name="address_number"]').focus()
                },
                error: function(e) {
                    e.status && alert('Endereço não localizado')
                }
        })
    })
    */

    $("#frmZipcode").blur(function(){
        var e = $(this).val();
        $.ajax({
                type: "GET",
                url: "https://viacep.com.br/ws/" + e + "/json/",
                success: function(e) {
                    $('input[name="address"]').val(e.logradouro),
                    //$('input[name="district"]').val(e.bairro),
                    $('input[name="city"]').val(e.localidade),
                    $('input[name="state"]').val(e.uf),
                    $('input[name="neighborhood"]').val(e.bairro),
                    $('input[name="address_number"]').focus()
                },
                error: function(e) {
                    e.status && alert('Endereço não localizado')
                }
        })
    })

    $("#frmBillingZipcode").blur(function(){
        var e = $(this).val();
        $.ajax({
                type: "GET",
                url: "https://viacep.com.br/ws/" + e + "/json/",
                success: function(e) {
                    $('input[name="billing_address"]').val(e.logradouro),
                    //$('input[name="district"]').val(e.bairro),
                    $('input[name="billing_city"]').val(e.localidade),
                    $('input[name="billing_state"]').val(e.uf),
                    $('input[name="billing_neighborhood"]').val(e.bairro),
                    $('input[name="billing_address_number"]').focus()
                },
                error: function(e) {
                    e.status && alert('Endereço não localizado')
                }
        })
    })

});

</script>