<!-- Mask Money -->
<script src="<?=asset_url()?>js/jquery.maskMoney.js"></script>
<script src="<?=asset_url()?>js/bootstrap-datepicker.min.js"></script>
<!-- Sweet Forms -->
<script src="<?=asset_url()?>lib/sweet-alert/swal-forms.js"></script>

<script src="<?=asset_url()?>js/moment-with-locales.js"></script>

<script>

    $(document).ready(function(){

        function addZeroes( num ) {
            num = num.toString();
            var value = Number(num);
            var res = num.split(".");
            if(res.length == 1 || (res[1].length < 3)) {
                value = value.toFixed(2);
            }
            return value
        }

        $(".br-currency").maskMoney({
            prefix: "R$ ",
            decimal: ",",
            thousands: "."
        });

        $('.due-date.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR"
        })
        .on('changeDate', dueDateChanged);

        $('.payday.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR"
        })
        .on('changeDate', payDateChanged);
        

        $("#frmTotalValue").blur(function(){
            var e = $(this).val();
            var total = ($(".br-currency").maskMoney('unmasked')[0]);
            var parcela = (total/12);
            parcela = parseFloat(parcela.toFixed(2))

            // remove ponto
            parcela = parcela.toString();
            parcela = parcela.replace(",","");
            parcela = parcela.replace(".",",");
            parcela = "R$ " + parcela;

            $(".quota-value").val(parcela);
        })

        $(".btnDelete").click(function(){
            var me = $(this);
            var strUrl = $(me).data('href');
            var id = $(me).data('id');

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
                                swal({title: data.title, text: data.message, type: "success"},function() { location.reload(); });
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

        $(".btnRelease").click(function(){
            var me = $(this);
            var strUrl = $(me).data('href');
            var id = $(me).data('id');
            var client = $(me).data('client');

            swal.withForm({
                title: 'Selecione o número de parcelas da quitação',
                text: 'Selecione o número de parcelas da quitação',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                showLoaderOnConfirm: true,
                formFields: [
                    { id: 'releaseQuotes',
                    type: 'select',
                    options: [
                    {value: '1', text: '1 parcela'},
                    {value: '2', text: '2 parcelas'},
                    {value: '3', text: '3 parcelas'},
                    {value: '4', text: '4 parcelas'},
                    {value: '5', text: '5 parcelas'},
                    {value: '6', text: '6 parcelas'},
                    {value: '12', text: '12 parcelas'}
                    ]}
                ]
            }, function (isConfirm) {

                if (isConfirm) {

                    $.ajax({
                        type: "POST",
                        data: {id: id, client: client, releaseQuotes: this.swalForm['releaseQuotes']},
                        url: strUrl,
                        success: function(data) {}
                    })
                    .done(function(data) {

                            var strMsg = '';
                                var type = 'success';
                                if (data.success) {
                                    swal({title: data.title, text: data.message, type: "success"},function() { location.reload(); });
                                }
                                else {
                                    swal(data.title, data.message, "error");
                            }

                    })
                    .error(function(data) {
                        swal("Oops", "Não foi possível se comunicar com o servidor!", "error");
                    });

                }
                //console.log(this.swalForm)
            })
            
        });

        <? if (isset($imprimir) && $imprimir === true) { ?>
        setTimeout(function(){ printContent(); }, 1000);
        <? } ?>

    });

    function printContent() 
    {
        $('.panel.panel-default').addClass('no-border');
        $('.top-head.container-fluid').addClass('hide');
        $('.page-title').addClass('hide');
        $('.footer').addClass('hide');
        $('.container-fluid').removeClass('wraper');

        setTimeout(function(){ 
            window.print();
        }, 100);

        setTimeout(function(){ 
            $('.panel.panel-default').removeClass('no-border');
            $('.top-head.container-fluid').removeClass('hide');
            $('.page-title').removeClass('hide');
            $('.footer').removeClass('hide');
            $('.container-fluid').addClass('wraper');
        }, 1000);
        
    }

    function dueDateChanged(ev) {
        if ($(ev.target).hasClass('first')) {
            var date = new Date(ev.date)
            
            i = 0;
            $('.due-date.datepicker').each(function() {

                date = moment(date).add(i, 'months').toDate();;

                $(this).datepicker('update', date);
                if (i == 0) {
                    i++;
                }
            });
        }
    }

    function payDateChanged(ev) {
        if ($(ev.target).hasClass('first')) {
            //console.log('payDateChanged',ev);
        }
    }

</script>