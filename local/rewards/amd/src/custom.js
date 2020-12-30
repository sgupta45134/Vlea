define([], function() {
 
    return {
        init: function() {
            $('.like').click(function(){
                var postidstring = $(this).attr('id');
                var postid = postidstring.split('_')[1];

                $.ajax({
                    url:M.cfg.wwwroot+'/local/sharewall/ajax_bridge.php',
                    method:'post',
                    data:{'postid':postid, 'action':'like'},
                    success:function(result){
                    }
                });
            });
        }
    };
});