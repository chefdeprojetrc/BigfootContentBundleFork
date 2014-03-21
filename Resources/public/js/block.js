$(function() {

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

    /**
     * Handle blocks
     */
    var containers = $('.widget-blocks');

    containers.each(function (index) {
        var blocks = $(this).find('.admin_block_select');

        handleTemplates(blocks);
    });

    $('body').on('click', '.admin-add-block', function (event) {
        event.preventDefault();

        var
            containerBlock = $(this)
                .closest('.collection-container')
                    .find('.widget-blocks');

        var
            prototypeBlock = containerBlock.attr('data-prototype'),
            blocks         = containerBlock.find('.admin_block_select');

        var blockCount = containerBlock
            .find('li')
            .length;

        var newBlock = prototypeBlock.replace(/__name__/g, blockCount);

        containerBlock.append(newBlock);
        $(".chosen-select").chosen();

        var blocks = containerBlock.find('.admin_block_select');

        handleTemplates(blocks);
    });

    $('body').on('click', '.admin-edit-block', function (event) {
        event.preventDefault();

        var
            blockId = $(this).closest('.block-row').find('.admin_block_select').val();
            url     = Routing.generate('admin_block_edit', { 'id': blockId, 'layout': '_modal' }),
            title   = $(this).data('title');

        $('body').modalmanager('loading');

        setTimeout(function() {
            modal.load(url, '', function() {
                modal.modal();
                $('.modal-header h3').html(title);
            });
        }, 1000);
    });

    $('body').on('click', '.admin-delete-block', function (event) {
        event.preventDefault();

        currentBlock = $(this)
            .closest('li')
            .remove();
    });

    $('body').on('change', '.admin_block_select', function (event) {
        handleTemplate($(this));
    });

    function handleTemplates(blocks)
    {
        blocks.each(function (index) {
            handleTemplate($(this));
        });
    }

    function handleTemplate(block)
    {
        var
            val = block
                .find('option:selected')
                    .html()
                    .split('-'),

            template = val[val.length-1].trim(),
            radios   = block
                .closest('.block-row')
                    .find('input[type=radio]');

        radios.each(function (index) {
            var values = $(this)
                .val()
                .split('/');

            if (values[0] !== template) {
                $(this)
                    .parent()
                    .hide();
            } else {
                $(this)
                    .parent()
                    .show();
            }
        });
    }

});
