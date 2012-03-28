
$(document).ready(function() {
    
    setRadioInputListener();
    setFileInputListener();
    setPreviewClickListener();
    initTabUI();
    initFrameSelection();
});

function setPreviewClickListener() {
    $('#previewButton').click(function() {
        
        var name = $('#filepath_image').val();
        var imageName = $('input#image_name_id').val();
        var radio = $('input[name=radiovalue]').val();
        
        var fd = new FormData();
        fd.append('frame_name',radio);
        fd.append("filepath", name);
        fd.append("image_name",imageName );
	console.debug(imageName);
        $.ajax({
            url: "?c=AjaxWSInterface",
            type: "POST",
            data: fd,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            cache: false,
            success: function (response) {
                console.debug(response);
                response = jQuery.parseJSON(response);
                console.debug(response.error);
                var error = response.error;
                $('#previewDiv').empty();
                console.debug(error);
                if(error){
                    $('#previewDiv').append(error);
                }else{
                    var image = response.image;
                    var id_image = response.id_image;
                    $('#previewDiv').append("<img src='"+image+"' alt='preview'/>");
                    $('#tabs').tabs("enable", 3);
                    $('#status a#link-delete').attr('href','index.php?c=Upload&action=delete&id='+id_image);
                    $('#status a#link-add').attr('href','index.php?c=MyShoppingCart&action=add&id='+id_image);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("error");
                $('#previewDiv').empty();
                $('#previewDiv').append("An error occured:"+textStatus);
            }
            
        });
    });
}

function setRadioInputListener()
{
    $( "input[name='radioframe']" ).bind( "click", radioClicks );
    
    function radioClicks()
    {
        $('input[name=radiovalue]').val($(this).val());
        $('#tabs').tabs("enable", 2);   
        
    // alert( $( this ).val() );
    }
}


function initTabUI() { 

    // Tabs
    $('#tabs').tabs();
				
    //hover states on the static widgets
    $('#dialog_link, ul#icons li').hover( function() {
        $(this).addClass('ui-state-hover');
    }, 
    
    function() {
        $(this).removeClass('ui-state-hover');
    } );
    
    $('#tabs').tabs("option","disabled", [1, 2, 3]);
    
    var uploaded = $('#hide_uploaded').val();
    
    if (uploaded == 'false') {
        
    }
    else {
        $('#tabs').tabs("enable", 1);
        $('#tabs').tabs("select", 1);
    }
    
}

function initFrameSelection() {
    
    $('.tip').mouseover(function(){
        var tip = $('<div id="tip"><div class="t_box"><div><s><i></i></s><img src="'+this.src+'" /></div></div></div>');
        $('body').append(tip);
        $('#tip').show('fast');
    }).mouseout(function(){
        $('#tip').remove();
    }).mousemove(function(e){
        $('#tip').css({
            "top":(e.pageY-60)+"px",
            "left":(e.pageX+30)+"px"
        })
    })
}


function setFileInputListener() { 

    $(function () {
	
        $('form#photoform input[type=file]').change( function() 
        {
            // $('#fileform').submit();
            var sb = $("#photosel_button").val();
            
            if (sb == null) {
                $("#photo-1").append("<input type='submit' name='photo_submit' value='Submit to continue!' id='photosel_button'/>");
            }
        });
    });
}
