
$(document).ready(function(){
    $('.cpf-field').mask('000.000.000-00', {reverse: true});
    $('.money-field').mask('000.000.000.000.000.00', {reverse: true});
    $('.agencia-field').mask('0000', {reverse: true});
    $('.conta-field').mask('00000000-0', {reverse: true});
    $('.phone-field').mask('00 00000-0000', {reverse: true});

    $('.c15').change(function() {
        $('.c30').prop('checked', false); // Unchecks it
        $('.c50').prop('checked', false); // Unchecks it
        $('.valor_recarga').val('15');
    });
    $('.c30').change(function() {
        $('.c15').prop('checked', false); // Unchecks it
        $('.c50').prop('checked', false); // Unchecks it
        $('.valor_recarga').val('30');
    });
    $('.c50').change(function() {
        $('.c15').prop('checked', false); // Unchecks it
        $('.c30').prop('checked', false); // Unchecks it
        $('.valor_recarga').val('50');
    });
});