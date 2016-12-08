jQuery( document ).ready( function(){
  
    //let us dome some magic
    
    var jq = jQuery;
      
    console.log('editable-activity has been loaded');
      
    function bind_editable_activity(){
       
        jq( 'body' ).editable({          
            type: 'textarea',
            name: 'activity-content',  
            pk: function(){
                    //activity id
                    return jq(this).data('id') ;
                    console.log('pk function');
            },
            selector: '.acomment-edit',//delegated to it
            url: ajaxurl,
            params: function( params ){
                //for wp action
               params.action = 'editable_activity_update';
               params.nonce = jq('#_activity_edit_nonce_'+params.pk).val();
               console.log('params function');
               return params;
            },
            display: function (value, sourceData){
                   console.log('display function');
            },

            success: function( response, newValue ) {
                if(response.error) {
                    return response.message; //msg will be shown in editable form
                    console.log('error in init');
                }
                if( response.success){
                    //update content
                    jq( '#activity-' + response.data.id ).replaceWith( response.data.content );
                     console.log('success in init');
                           
                }
            },
            title: BPEditableActivity.edit_activity_title
    });
  
  }
   
    bind_editable_activity();
    
    
    //for activity comment
    function bind_editable_activity_comment(){
    
        jq( 'body').editable({
          
        type: 'textarea',
        name: 'activity-content',  
        pk: function(){
                //activity comment id
                return jq(this).data('id') ;

        },
        selector: '.acomment-reply-edit',
        url: ajaxurl,
        params: function( params ){
           params.action = 'editable_activity_comment_update';
           params.nonce = jq('#_activity_edit_nonce_' + params.pk ).val()
           return params;
        },
        display: function (value, sourceData){

        },

        success: function( response, newValue ) {
            
            if( response.error )
                return response.message; //msg will be shown in editable form
            
            if( response.success ){
                //update content

                jq( '#acomment-' + response.data.id ).replaceWith( response.data.content );
               
            }
        },
        title: BPEditableActivity.edit_activity_title
       });

    }
    bind_editable_activity_comment();



});