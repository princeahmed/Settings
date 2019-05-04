(function ($) {

    var prince = {

        init: () => {
            prince.handleActiveTab();
            $('.ui-tabs>ul>li').click(prince.setActiveTab);
        },

        /* set active tab on click */
        setActiveTab: function () {
            $('.ui-state-default').removeClass('ui-tabs-active ui-state-active');
            $('#post-body-content>div').hide();

            $(this).addClass('ui-tabs-active ui-state-active');

            const $aria_controls = $('#' + $(this).attr('aria-controls'));
            $aria_controls.show();
            $aria_controls.find('.prince-settings-nav>li:first-child').addClass('ui-tabs-active ui-state-active');

            const $tab_id = $(this).attr('id');

            if (typeof (Storage) !== 'undefined') {
                localStorage.setItem('prince_settings_active_tab', $tab_id);
            }
        },

        /* handle active tab after load */
        handleActiveTab:  () => {
            $('.ui-state-default').removeClass('ui-tabs-active ui-state-active');
            $('#post-body-content>div').hide();

            let $tab_id = localStorage.getItem('prince_settings_active_tab');
            $tab_id = $tab_id ? $tab_id : $('.ui-tabs>ul>li:first-child').attr('id');

            const $tab = $('#' + $tab_id);

            if ($tab) {
                $tab.addClass('ui-tabs-active ui-state-active');
                $('#' + $tab.attr('aria-controls')).show();
            }

            $('#post-body-content').show();
        }
    };

    $(document).ready(prince.init);

    return prince;
})(jQuery);