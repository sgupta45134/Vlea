require(['jquery'], function($) {
       // JQuery is available via $
           $('.btn').click(function(){
               
                //$('.modal-body').html('<p style="color:green;">Your have alread </p>');
               
           });
           
           function abc() {
               alert("in abc");
           }
        
           $(document).on('click', '#id_intro', function() { // code
                values = $('#mform1').serialize();

                filepath    =   $('.filepicker-filename a').attr('href'); 
                $.ajax({
                  url : M.cfg.wwwroot + '/local/stripepayment/ajax.php',
                  data :{values:values,filepath:filepath},
                  type : 'POST',
                  success : function(response){
                    $('.modal-body').html(response);
                    
                    setTimeout(function(){
                        location.reload();
                    },2000);
                 }
                });

        });
   });
