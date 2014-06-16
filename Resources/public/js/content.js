$(function() {

    $( ".template-row" ).each(function() {
        var $radio = $(this).find('input[type=radio]');
        $radio.click(function() {
            $('.template-row i.icon-ok').hide();
            $(this).parent().parent().find('i.icon-ok').show();
        });

    });

    /**
     * Handle modal response
     */
    var
        modal   = $('#ajax-modal'),
        options = {
            success: successResponse,
        };

    $('.modal-save')
        .unbind('click')
        .on('click', function (event) {
            var
                pathname    = window.location.pathname.split('/'),
                contentType = null;
                template    = pathname[pathname.length-1].trim(),
                form        = $(this)
                    .closest('.modal')
                        .find('form');

            var action = form.attr('action');

            if ($.inArray('page', pathname) != -1) {
                contentType = 'page';
            } else {
                contentType = 'sidebar';
            }

            form
                .attr('action', action + '?layout=_blank&contentType=' + contentType + '&template=' + template)
                .ajaxSubmit(options);
        });

    function successResponse(responseText, statusText, xhr) {
        if (responseText.status === true) {
            modal
                .find('.modal-body')
                .empty()
                .prepend(responseText.content);
        } else if (responseText.status === 'new_block') {
            modal.modal('hide');

            $('.widget-blocks').attr('data-prototype', responseText.content.prototype);

            $('.admin_block_select').each(function (index) {
                $(this).append('<option value="' + responseText.content.option.value + '">' + responseText.content.option.label + '</option>');
            });

            $('.admin_block_select').trigger("chosen:updated");
        } else if (responseText.status === 'edit_block') {
            modal.modal('hide');

            $('.widget-blocks').attr('data-prototype', responseText.content.prototype);

            $('.admin_block_select > option[value="' + responseText.content.option.id + '"]').each(function (index) {
                $(this).html(responseText.content.option.label);
            });

            $('.admin_block_select').trigger("chosen:updated");
        } else {
            modal
                .find('.modal-body')
                .empty()
                .prepend("<div class='alert alert-block alert-danger'>" + responseText.message + '</div>')
                .append(responseText.content);
        }
    }
});
