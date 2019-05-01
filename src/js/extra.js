(function ($) {

    var prince = {

        init: () => {
            prince.handleActiveTab();
            $('.ui-state-default').click(prince.setActiveTab);
        },

        setActiveTab: function () {
            $('.ui-state-default').removeClass('ui-tabs-active ui-state-active');
            $('#post-body-content>div').hide();

            $(this).addClass('ui-tabs-active ui-state-active');
            $('#'+$(this).attr('aria-controls')).show();
            $('#'+$(this).attr('aria-controls')+' .prince-settings-nav>li:first-child').addClass('ui-tabs-active ui-state-active');
            const $id = $(this).attr('id');

            if(typeof(Storage) !== 'undefined'){
                localStorage.setItem('activeTab', $id);
            }
        },

        handleActiveTab: function () {
            $('.ui-state-default').removeClass('ui-tabs-active ui-state-active');
            $('#post-body-content>div').hide();

            const $id = localStorage.getItem('activeTab');
            const $tab = $('#'+$id);

            if($tab){
                $tab.addClass('ui-tabs-active ui-state-active');
                $('#'+$tab.attr('aria-controls')).show();

            }
        }
    };

    $(document).ready(prince.init);

    return prince;
})(jQuery);