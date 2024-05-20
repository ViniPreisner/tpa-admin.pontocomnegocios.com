<script>
$(".btn-recover").click(function(event) {
    event.preventDefault();
	//$(".btn-recover").text('Aguarde...').prop('disabled', true);
	//$(".btn-recover").addClass('hidden');
    openRecover();
});

$(".btn-cancel-recover").click(function(event) {
    event.preventDefault();
    backLogin();
});

function backLogin() {
    $('.form-login').removeClass('hidden');
    $('.form-recover').addClass('hidden');
	$(".btn-action-recover").text('Continuar').prop('disabled', false);
}

function openRecover() {
    $('.form-login').addClass('hidden');
    $('.form-recover').removeClass('hidden');
}


$(".btn-action-recover").click(function(event){

    event.preventDefault();
    var originalBtText = $(".btn-action-recover").text();
	$(".btn-action-recover").text('Aguarde...').prop('disabled', true);

    var email = $("input[name='frmEmailRecover']").val();

    $.when(
            $.ajax({
                type: "POST",
                url: '<?=base_url()?>recover-cliente-action',
                data: { email: email }
            })
        ).done(function (j) {

            j = JSON.parse(j);

            if (j[0]) {
                $(".result-recover").html('Sua nova senha foi enviada para seu e-mail.').removeClass('hidden');
            } else {
                $(".result-recover").html('Não foi possível recuperar sua senha.').removeClass('hidden');
            }

            backLogin();

        });

});

$('#close').on( "click", function() {
  $.magnificPopup.close();
});
</script>

<?
if ($alert) { 
echo '<script>';
echo '$(function(){';
echo '$("#loginModal .modal-body").html("'.$alert.'")';
echo '
$.magnificPopup.open({
                items: {
                  src: "#loginModal"
                },
                type: "inline",
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: "auto",
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: "my-mfp-zoom-in",
                modal: true
});';
echo '});';
echo '</script>';
}
?>