$(function() {

    /**
     * Handle blocks
     */
    var containers = $('.widget-blocks');

    containers.each(function (index) {
        var blocks = $(this).find('.admin_block_select');

        handleBlockTemplates(blocks);
    });

    $('body').on('click', '.admin-add-page-block', function (event) {
        event.preventDefault();

        var
            containerBlock = $(this)
                .closest('.collection-container')
                    .find('.widget-blocks');

            prototypeBlock = containerBlock.attr('data-prototype'),
            blocks         = containerBlock.find('.admin_block_select');

        blockCount = containerBlock
            .find('li')
            .length;

        newBlock = prototypeBlock.replace(/__name__/g, blockCount);

        containerBlock.append(newBlock);

        $(".chosen-select").chosen();

        var blocks = containerBlock.find('.admin_block_select');

        handleBlockTemplates(blocks);
    });

    $('body').on('click', '.admin-delete-page-block', function (event) {
        event.preventDefault();

        currentBlock = $(this)
            .closest('li')
            .remove();
    });

    $('body').on('change', '.admin_block_select', function (event) {
        handleBlockTemplate($(this));
    });

    function handleBlockTemplates(blocks)
    {
        blocks.each(function (index) {
            handleBlockTemplate($(this));
        });
    }

    function handleBlockTemplate(block)
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

    /**
     * Handle sidebars
     */
    var
        containerSidebar = $('.widget-sidebars');
        prototypeSidebar = containerSidebar.attr('data-prototype'),
        sidebars         = containerSidebar.find('.admin_sidebar_select');

    handleSidebarTemplates(sidebars);

    $('.admin-add-page-sidebar').on('click', function (event) {
        event.preventDefault();

        sidebarCount = containerSidebar
            .find('li')
            .length;

        newSidebar = prototypeSidebar.replace(/__name__/g, sidebarCount);

        containerSidebar.append(newSidebar);

        $(".chosen-select").chosen();

        var
            lastSidebar = containerSidebar.find('li:last'),
            sidebars    = containerSidebar.find('.admin_sidebar_select');

        handleSidebarTemplates(sidebars);
    });

    $('body').on('click', '.admin-delete-page-sidebar', function (event) {
        event.preventDefault();

        currentSidebar = $(this)
            .closest('li')
            .remove();
    });

    $('body').on('change', '.admin_sidebar_select', function (event) {
        handleSidebarTemplate($(this));
    });

    function handleSidebarTemplates(sidebars)
    {
        sidebars.each(function (index) {
            handleSidebarTemplate($(this));
        });
    }

    function handleSidebarTemplate(sidebar)
    {
        var
            val = sidebar
                .find('option:selected')
                    .html()
                    .split('-'),

            template = val[1].trim(),
            radios   = sidebar
                .closest('.sidebar-row')
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
