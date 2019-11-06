var imagename = "";
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery(document).ready(function($) {


    $('#filesubmit').submit(function(event) {

        var f = $(this);
        f.parsley().validate();

        event.preventDefault();
        var formData = new FormData($( 'form#filesubmit' )[ 0 ]);
        $.ajax({
        url: storeurl,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        data: formData,
        beforeSend: function (argument) {
            $('.overlay').show();
            $('.loader').removeClass('d-none');
        },
        success: function(data) {
           imagename = data.filename;
           $('.overlay').hide();
           $('.loader').addClass('d-none');
           $('#firststep').hide();
           $('#secondstep').removeClass('d-none');
        }
        })
    });


    $('#addfield').click(function(event) {

        event.preventDefault();
        $('#cropform').append("<div class='row'><span><input data-parsley-type='digits' data-parsley-required-message='Please enter width' required='' type=input name='width[]' class='form-control with' placeholder='Width' style='margin-right: 10px'></span><span><input data-parsley-type='digits' data-parsley-required-message='Please enter height' required='' type='input' name='height[]' class='form-control height' placeholder='Height' style='margin-right: 10px'></span><button style='height: 37px;' class='btn btn-danger remove-field'><i class='fa fa-minus-circle'></i></button></div>");
    });

    $(document).on('click','.remove-field', function() {
        $(this).parent('div.row').remove();
    });

    $('#subform').click(function(event) {

      var g = $('#cropform');
      g.parsley().validate();
      
      if (g.parsley().isValid()) {

      $('#outputimages').empty();
      $('#cropform .row').each(function(index, el) {
       var w = $(this).find('.with').val();
       var h = $(this).find('.height').val(); 
       $('#outputimages').append("<a class='btn btn-success' target='_blank' style='width:200px' href='"+url+"/"+w+"/"+h+"/"+imagename+"'>"+w+"x"+h+"</a><br>");
      });

      donwloadALl();

      }

    });


    /* Parsley Validation */
    window.Parsley.addValidator('maxFileSize', {
      validateString: function(_value, maxSize, parsleyInstance) {
        if (!window.FormData) {
          alert('You are making all developpers in the world cringe. Upgrade your browser!');
          return true;
        }
       
        var files = parsleyInstance.$element[0].files;
        return files.length != 1  || files[0].size <= maxSize * 1024;
      },
      requirementType: 'integer',
      messages: {
        en: 'The image should not be larger than 2mb.',
      }
    });

    window.ParsleyValidator.addValidator('fileextension', function (value, requirement) {
          var tagslistarr = requirement.split(',');
          var fileExtension = value.split('.').pop();
          var arr=[];
          $.each(tagslistarr,function(i,val){
             arr.push(val);
          });
          if(jQuery.inArray(fileExtension, arr)!='-1') {
            console.log("is in array");
            return true;
          } else {
            console.log("is NOT in array");
            return false;
          }
      }, 32)
      .addMessage('en', 'fileextension', 'The extension doesn\'t match the required');

    // button events
    $('#goback1').click(function(event) {
       $('.overlay').hide();
       $('.loader').addClass('d-none');
       $('#firststep').show();
       $('#secondstep,#thirdstep').addClass('d-none');
    });
    $('#goback2').click(function(event) {
       $('.overlay').hide();
       $('.loader').addClass('d-none');
       $('#thirdstep').addClass('d-none');
       $('#secondstep').removeClass('d-none');
    });

    function donwloadALl() {
      var formData = new FormData($( '#secondstep form' )[ 0 ]);
      formData.append('filename', imagename);
      $.ajax({
      url: downloadallurl,
      processData: false,
      contentType: false,
      type: 'POST',
      dataType: 'json',
      data: formData,
      beforeSend: function (data) {

      },
      success: function(data) {
        if (data.filename) {
          $('#downloadall .downloadall').attr('href', downloadallpath+'/'+data.filename);
          }
          $('#secondstep').addClass('d-none');
          $('#thirdstep').removeClass('d-none');
      }
      })
    }


});

function bs_input_file() {
    $(".input-file").after(
        function() {
            if ( ! $(this).next().hasClass('input-ghost') ) {
                var element = $("<input style='visibility:hidden; height:0'  id='file' type='file' class='form-control-file input-ghost' required='' data-parsley-max-file-size='2048'  data-parsley-required-message='Please upload the image' data-parsley-fileextension='jpg,png' >");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.prev(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').next().click();
                    return false;
                });
                return element;
            }
        }
    );
}
$(function() {
    bs_input_file();
});

