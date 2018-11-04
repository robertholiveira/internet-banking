
$(document).ready(function(){
    $('.cpf-field').mask('000.000.000-00', {reverse: true});
    $('.money-field').mask('000.000.000.000.000.00', {reverse: true});
    $('.agencia-field').mask('0000', {reverse: true});
    $('.conta-field').mask('00000000-0', {reverse: true});
});