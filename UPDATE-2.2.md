# Feat-58

Adding a "label" parameter to templates :

For each template (group of subtemplates) add a label parameter like so

    bigfoot_content:
        templates:
            page:
                block_sidebar:
                    *label: 'Blocks and Sidebar !'*
                    class: 'Seh\Bundle\SehBundle\Entity\Page\Template\BlockSidebar'
                    sub_templates:
                        block_sidebar_left:  'Left sidebar'
                        block_sidebar_right: 'Right sidebar'

This label will be displayed as a title for the group of children subtemplates when displayed.
