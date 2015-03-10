$(function() {

    /**
     * Handle blocks
     */
    $('.block-accordion')
        .accordion({
            collapsible: true,
            header:      '> li > h3'
        })
        .sortable({
            handle: 'h3',
            stop: function( event, ui ) {
                ui.item.children('li').triggerHandler('focusout');

                orderBlocks();
            }
        })
        .accordion('refresh');

    var containers = $('.widget-blocks');

    containers.each(function (index) {
        var blocks = $(this).find('.admin_block_select');

        handleTemplates(blocks);

        handleBlockAccordion(blocks);
    });

    orderBlocks();

    $('body').on('click', '.admin-add-block', function (event) {
        event.preventDefault();

        var containerBlock = $(this)
            .closest('.collection-container')
                .find('.widget-blocks');
console.log(containerBlock);
        var
            prototypeBlock = containerBlock.attr('data-prototype'),
            blocks         = containerBlock.find('.admin_block_select');

        var blockCount = containerBlock
            .find('li')
            .length;

        var newBlock = prototypeBlock.replace(/__name__/g, blockCount);

        containerBlock.find('.block-accordion').append(newBlock);

        $(".chosen-select").chosen();

        var blocks = containerBlock.find('.admin_block_select');

        handleTemplates(blocks);

        $(this)
            .closest('.collection-container')
                .find('.templates-container:last')
                    .find('label.is-shown:first > input')
                        .attr('checked', true);

        $('.block-accordion')
            .accordion({
                collapsible: true,
                header:      '> li > h3'
            })
            .sortable({
                handle: 'h3',
                stop: function( event, ui ) {
                    ui.item.children('li').triggerHandler('focusout');

                    orderBlocks();
                }
            })
            .accordion('refresh');

        handleBlockAccordion(blocks);

        orderBlocks();
    });

    $('.admin-edit-block').unbind('click');

    $('body').on('click', '.admin-edit-block', function (event) {
        event.preventDefault();

        var
            modal   = $('#ajax-modal'),
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

        var currentBlock = $(this)
            .closest('li')
            .remove();

        orderBlocks();
    });

    $('body').on('change', '.admin_block_select', function (event) {
        handleTemplate($(this));

        replaceBlockAccordionName($(this));
    });

    function handleTemplates(blocks)
    {
        blocks.each(function (index) {
            handleTemplate($(this));
        });
    }

    function handleTemplate(block)
    {
        var val = block
            .find('option:selected')
                .html()
                .split('-');

        var
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
                    .addClass('is-hidden')
                    .hide();
            } else {
                $(this)
                    .parent()
                    .addClass('is-shown')
                    .show();
            }
        });
    }

    function handleBlockAccordion(blocks)
    {
        blocks.each(function (index) {
            replaceBlockAccordionName($(this));
        });
    }

    function replaceBlockAccordionName(block)
    {
        var currentBlockName = block
            .find('option:selected')
                .html();

        block
            .closest('.block-row')
                .find('.content-block-name')
                    .text(currentBlockName);
    }

    function orderBlocks()
    {
        var containers = $('.widget-blocks');

        containers.each(function (index) {
            var blocks  = $(this).find('.admin_block_select');

            blocks.each(function (index2) {
                $(this)
                    .closest('.b-accordion')
                        .find('.block-position')
                            .val(index2 + 1);
            });
        });
    }

});
