/**
 * @file
 * JS file.
 */

(function ($) {
  Drupal.behaviors.currency_converter = {
    attach: function (context) {
      var flag = true;
      var currency = new Array();
      var convertValue;

      var currencyAll = drupalSettings.currencies;

      /**
       * Getting all currency.
       *
       * @type Number
       */
      for (var i = 0; i < $(context).find('#select1').children().length; i++) {
        currency[i] = $(context).find('#select1').children()[i]['id'];
      }

      /**
       * Start configuration.
       */
      $(context).find('#select2').find('#' + currency[1]).prop('selected', 'selected');
      $(context).find('#select2').find('#' + currency[0]).prop('disabled', 'disabled');
      $(context).find('#select1').find('#' + currency[1]).prop('disabled', 'disabled');

      /**
       * Start convertValue.
       *
       * @type type
       */
      var currency1, currency2;
      for (var i = 0; i < currency.length; i++) {
        if ($(context).find('#select2').find('#' + currency[i]).prop('selected')) {
          currency1 = currency[i];
        }
        if ($(context).find('#select1').find('#' + currency[i]).prop('selected')) {
          currency2 = currency[i];
        }
      }
      convertValue = currencyAll[currency1][currency2];

      /**
       * Check selected currency for select2(destination field).
       */
      $(context).find('#select2').click(function () {
        for (var i = 0; i < currency.length; i++) {
          if ($(context).find('#select2').find('#' + currency[i]).prop('selected')) {
            $(context).find('#select1').find('#' + currency[i]).prop('disabled', 'disabled');
          }
          else {
            $(context).find('#select1').find('#' + currency[i]).prop('disabled', false);
          }
        }
        for (var i = 0; i < currency.length; i++) {
          if ($(context).find('#select2').find('#' + currency[i]).prop('selected')) {
            currency1 = currency[i];
          }
          if ($(context).find('#select1').find('#' + currency[i]).prop('selected')) {
            currency2 = currency[i];
          }
        }
        convertValue = currencyAll[currency1][currency2];
        var result = parseFloat($(context).find('#text1').val());
        if (result) {
          result *= convertValue;
          $(context).find('#text2').val(result.toFixed(3));
        }
      });

      /**
       * Check selected currency for select1(source field).
       */
      $(context).find('#select1').click(function () {
        for (var i = 0; i < currency.length; i++) {
          if ($(context).find('#select1').find('#' + currency[i]).prop('selected')) {
            $(context).find('#select2').find('#' + currency[i]).prop('disabled', 'disabled');
          }
          else {
            $(context).find('#select2').find('#' + currency[i]).prop('disabled', false);
          }
        }
        for (var i = 0; i < currency.length; i++) {
          if ($(context).find('#select2').find('#' + currency[i]).prop('selected')) {
            currency1 = currency[i];
          }
          if ($(context).find('#select1').find('#' + currency[i]).prop('selected')) {
              currency2 = currency[i];
          }
        }
        convertValue = currencyAll[currency1][currency2];
        var result = parseFloat($(context).find('#text2').val());
        if (result) {
          result /= convertValue;
          $(context).find('#text1').val(result.toFixed(3));
        }
      });

      /**
       * Wright result in text2(destination field).
       */
      $(context).find('#text1').bind('keypress keyup blur', function () {
        var result = parseFloat($(this).val());
        if (result) {
          result *= convertValue;
          $(context).find('#text2').val(result.toFixed(3));
        }
      });

      /**
       * Wright result in text1(source field).
       */
      $(context).find('#text2').bind('keypress keyup blur', function () {
        var result = parseFloat($(this).val());
        if (result) {
          result /= convertValue;
          $(context).find('#text1').val(result.toFixed(3));
        }
      });

      /**
       * Flip.
       */
      $(context).find('.button-converter').click(function () {
        if (flag) {
          $(context).find(".first-slot-converter").appendTo(".window-converter");
          flag = false;
        }
        else {
          $(context).find(".second-slot-converter").appendTo(".window-converter");
          flag = true;
        }
      });
    }
  };
})(jQuery);
