(function ($) {
    'use strict';

    $('.envato_license.settings form').submit(function () {
        var data   = $(this).serialize(),
            submit = $('#submit'),
            value  = submit.val();

        submit.val('Saving...');

        $.post('options.php', data).error(
            function () {
                alert('error');
                submit.val(value);
            }).success(function () {
                location.reload();
            }
        );
        return false;
    });

})(window.jQuery);