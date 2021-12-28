/*
*
* Document Ready Function
*
* */
(function($) {

  $(function() {

    const SELECTOR_BOOTSTRAP_SELECT_DROPDOWN    = $('select.form-control');
    const SELECTOR_SELECT2_CONTAINER            = $('.select2-container');

    // INITIALIZE BOOTSTRAP SELECT2 DROPDOWN
    if (SELECTOR_BOOTSTRAP_SELECT_DROPDOWN.length > 0 && typeof $.fn.select2 != 'undefined') {
      SELECTOR_BOOTSTRAP_SELECT_DROPDOWN.select2({
        // theme: 'classic'
        width: '100%',
        allowClear: true,
        placeholder: function() {
          $(this).data('placeholder');
        },
        escapeMarkup: function(markup) {
          return markup;
        }
      }).focus(function () {
        $(this).select2('focus');
      });
    }

    // INITIALIZE BOOTSTRAP SELECT2 DROPDOWN VALIDATION
    if (SELECTOR_SELECT2_CONTAINER.length > 0 && typeof $.fn.select2 != 'undefined') {
      $.each(SELECTOR_SELECT2_CONTAINER, function (i, n) {
        $(n).next().show().fadeTo(0, 0).height('0px').css('left', 'auto'); // make the original select visible for validation engine and hidden for us
        $(n).prepend($(n).next());
        $(n).delay(500).queue(function () {
          $(this).removeClass('validate[required]'); //remove the class name from select2 container(div), so that validation engine dose not validate it
          $(this).dequeue();
        });
      });
    }

  });

}) (jQuery);
// End of Document Ready Function