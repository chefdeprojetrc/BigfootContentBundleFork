$(function() {

    /**
     * Handle blocks
     */
    var
        container = $('.widget-blocks'),
        prototype = container.attr('data-prototype'),
        blocks    = container.find('.admin_block_select');

    handleTemplates(blocks);

    $('.admin-add-sidebar-block').on('click', function (event) {
        event.preventDefault();

        blockCount = container
            .find('li')
            .length;

        newBlock = prototype.replace(/__name__/g, blockCount);

        container.append(newBlock);

        $(".chosen-select").chosen();

        var
            lastBlock = container.find('li:last'),
            blocks    = container.find('.admin_block_select');

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

            template = val[1].trim(),
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
