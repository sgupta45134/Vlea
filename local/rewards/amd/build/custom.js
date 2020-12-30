define(['jquery', 'core/notification', 'core/modal_factory', 'core/modal_events', 'core/templates'], function($, Notification, ModalFactory, ModalEvents, Templates) {
    return {
        init: function() {
            $('.button-wrapper .btn').on('click', function(e) {
                var clickedLink = $(e.currentTarget);
                ModalFactory.create({
                    type: ModalFactory.types.SAVE_CANCEL,
                    title: 'Redeem Prize',
                    body: 'Do you really want to redeem this prize?',
                }).then(function(modal) {
                    modal.setSaveButtonText('Redeem');
                    modal.getRoot().on(ModalEvents.save, function(e) {
                        var elementid = clickedLink.attr('id');
                        var prizeid = elementid.split('_')[1];
                        // Do something to process the action
                        // Don't close the modal yet.
                        e.preventDefault();
                        $.ajax({
                            url: M.cfg.wwwroot + '/local/rewards/ajax_bridge.php',
                            method: 'post',
                            data: {
                                'prizeid': prizeid,
                                'action': 'redeem'
                            },
                            success: function(result) {
                                modal.hide();
                                $('#notification-message-'+prizeid).html(result);
                                $('#notification-message-'+prizeid).show();
                            }
                        });
                    });
                    modal.show();
                });
            });
        }
    }
});