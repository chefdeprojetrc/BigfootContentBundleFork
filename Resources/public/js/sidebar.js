$(function() {

    /**
     * Handle blocks
     */
    var containers = $('.widget-blocks');

    containers.each(function (index) {
        var blocks = $(this).find('.admin_block_select');

        handleTemplates(blocks);
    });

    $('body').on('click', '.admin-add-sidebar-block', function (event) {
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

    $('body').on('click', '.admin-delete-sidebar-block', function (event) {
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
