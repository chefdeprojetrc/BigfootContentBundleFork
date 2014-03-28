$(function() {

    /**
     * Handle sidebars
     */
    var
        containerSidebar = $('.widget-sidebars');
        prototypeSidebar = containerSidebar.attr('data-prototype'),
        sidebars         = containerSidebar.find('.admin_sidebar_select');

    handleSidebarTemplates(sidebars);

    $('.admin-add-sidebar').on('click', function (event) {
        event.preventDefault();

        var sidebarCount = containerSidebar
            .find('li')
            .length;

        var newSidebar = prototypeSidebar.replace(/__name__/g, sidebarCount);

        containerSidebar.append(newSidebar);

        $(".chosen-select").chosen();

        var
            lastSidebar = containerSidebar.find('li:last'),
            sidebars    = containerSidebar.find('.admin_sidebar_select');

        handleSidebarTemplates(sidebars);

        $(this)
            .closest('.collection-container')
                .find('.templates-container:last')
                    .find('label.is-shown:first > input')
                        .attr('checked', true);
    });

    $('body').on('click', '.admin-delete-sidebar', function (event) {
        event.preventDefault();

        var currentSidebar = $(this)
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
        var val = sidebar
            .find('option:selected')
                .html()
                .split('-');

        var
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

});
