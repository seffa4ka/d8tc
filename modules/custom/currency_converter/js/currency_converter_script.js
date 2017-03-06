/**
 * @file
 * JS file.
 */

(function ($) {
  Drupal.behaviors.currency_converter = {
    attach: function () {
      var flag = true;
      var currency = new Array();
      var convertValue;

      var currencyAll = drupalSettings.currencies;

      /**
       * Getting all currency.
       *
       * @type Number
       */
      for (var i = 0; i < $('#select1').children().length; i++) {
        currency[i] = $('#select1').children()[i]['id'];
      }

      /**
       * Start configuration.
       */
      $('#select2').find('#' + currency[1]).prop('selected', 'selected');
      $('#select2').find('#' + currency[0]).prop('disabled', 'disabled');
      $('#select1').find('#' + currency[1]).prop('disabled', 'disabled');

      /**
       * Start convertValue.
       *
       * @type type
       */
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

      /**
       * Check selected currency for select2.
       */
      $('#select2').click(function () {
        for (var i = 0; i < currency.length; i++) {
          if ($('#select2').find('#' + currency[i]).prop('selected')) {
            $('#select1').find('#' + currency[i]).prop('disabled', 'disabled');
          }
          else {
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

      /**
       * Check selected currency for select1.
       */
      $('#select1').click(function () {
        for (var i = 0; i < currency.length; i++) {
          if ($('#select1').find('#' + currency[i]).prop('selected')) {
            $('#select2').find('#' + currency[i]).prop('disabled', 'disabled');
          }
          else {
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

      /**
       * Wright result in text2.
       */
      $('#text1').bind('keypress keyup blur', function () {
        var result = parseFloat($(this).val());
          result *= convertValue;
          $('#text2').val(result);
      });

      /**
       * Wright result in text1.
       */
      $('#text2').bind('keypress keyup blur', function () {
        var result = parseFloat($(this).val());
        result /= convertValue;
        $('#text1').val(result);
      });

      /**
       * Flip.
       */
      $('.button-converter').click(function () {
        if (flag) {
          $(".first-slot-converter").appendTo(".window-converter");
          flag = false;
        }
        else {
          $(".second-slot-converter").appendTo(".window-converter");
          flag = true;
        }
      });
    }
  };
})(jQuery);
