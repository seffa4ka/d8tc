$(document).ready(function(){
    var flag = true; // flip flag
    var currency = new Array(); // All currency
    var convertValue;
/*
    var RUB = new Object();
    RUB.USD = 58.38;
    RUB.EUR = 61.54;

    var USD = new Object();
    USD.RUB = 0.017;
    USD.EUR = 1.054;

    var EUR = new Object();
    EUR.USD = 0.949;
    EUR.RUB = 0.016;
*/
    var currencyAll = new Array();
    currencyAll['RUB'] = new Array();
    currencyAll['RUB']['USD'] = 58.38;
    currencyAll['RUB']['EUR'] = 61.54;
    currencyAll['USD'] = new Array();
    currencyAll['USD']['RUB'] = 0.017;
    currencyAll['USD']['EUR'] = 1.054;
    currencyAll['EUR'] = new Array();
    currencyAll['EUR']['USD'] = 0.949;
    currencyAll['EUR']['RUB'] = 0.016;

    // Getting all currency
    for (var i = 0; i < $('#select1').children().length; i++){
        currency[i] = $('#select1').children()[i]['id'];
    }

    // Start configuration
    $('#select2').find('#' + currency[1]).prop('selected', 'selected');
    $('#select2').find('#' + currency[0]).prop('disabled', 'disabled');
    $('#select1').find('#' + currency[1]).prop('disabled', 'disabled');

    // Start convertValue
    var currency1, currency2;
    for (var i = 0; i < currency.length; i++) {
        if ($('#select2').find('#' + currency[i]).prop('selected')) {
            currency1 = currency[i];
        }
        if ($('#select1').find('#' + currency[i]).prop('selected')) {
            currency2 = currency[i];
        }
    }
    convertValue = currencyAll[currency1][currency2];

    // Check selected currency for select2
    $('#select2').click(function(){
        for (var i = 0; i < currency.length; i++) {
            if ($('#select2').find('#' + currency[i]).prop('selected')) {
                $('#select1').find('#' + currency[i]).prop('disabled', 'disabled');
            } else {
            	$('#select1').find('#' + currency[i]).prop('disabled', false);
            }
        }
        for (var i = 0; i < currency.length; i++) {
            if ($('#select2').find('#' + currency[i]).prop('selected')) {
                currency1 = currency[i];
            }
            if ($('#select1').find('#' + currency[i]).prop('selected')) {
                currency2 = currency[i];
            }
        }
        convertValue = currencyAll[currency1][currency2];
        var result = parseFloat($('#text1').val());
        result *= convertValue;
        $('#text2').val(result);
    });

    // Check selected currency for select1
    $('#select1').click(function(){
        for (var i = 0; i < currency.length; i++) {
            if ($('#select1').find('#' + currency[i]).prop('selected')) {
                $('#select2').find('#' + currency[i]).prop('disabled', 'disabled');
            } else {
            	$('#select2').find('#' + currency[i]).prop('disabled', false);
            }
        }
        for (var i = 0; i < currency.length; i++) {
            if ($('#select2').find('#' + currency[i]).prop('selected')) {
                currency1 = currency[i];
            }
            if ($('#select1').find('#' + currency[i]).prop('selected')) {
                currency2 = currency[i];
            }
        }
        convertValue = currencyAll[currency1][currency2];
        var result = parseFloat($('#text2').val());
        result /= convertValue;
        $('#text1').val(result);
    });

    // Wright result in text2
    $('#text1').bind('keypress keyup blur', function() {
        var result = parseFloat($(this).val());
        result *= convertValue;
        $('#text2').val(result);
    });

    // Wright result in text1
    $('#text2').bind('keypress keyup blur', function() {
        var result = parseFloat($(this).val());
        result /= convertValue;
        $('#text1').val(result);
    });

    // Flip
    $('.button-converter').click(function(){
        if (flag) {
            $(".first-slot-converter").appendTo(".window-converter");
            flag = false;
        } else {
            $(".second-slot-converter").appendTo(".window-converter");
            flag = true;
        }
    });
});
