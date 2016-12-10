<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="kartik_fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script src="kartik_fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="kartik_fileinput/js/fileinput.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- canvas-to-blob.min.js is only needed if you wish to resize images before upload.
         This must be loaded before fileinput.min.js -->
    <!-- <script src="kartik_fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script> -->
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
         This must be loaded before fileinput.min.js -->
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
         This must be loaded before fileinput.min.js -->
    <!-- <script src="kartik_fileinput/js/plugins/purify.min.js" type="text/javascript"></script> -->
    <!-- the main fileinput plugin file -->
    <!-- bootstrap.js below is needed if you wish to zoom and view file content
         in a larger detailed modal dialog -->
    <!-- optionally if you need a theme like font awesome theme you can include
        it as mentioned below -->
    <!-- <script src="kartik_fileinput/js/fa.js"></script> -->
    <!-- optionally if you need translation for your language then include
        locale file as mentioned below -->
    <!-- <script src="kartik_fileinput/js/<lang>.js"></script> -->
  </head>
  <body>
    <input id="images" name="images[]" type="file" multiple class="file-loading">

    <script>
      $(document).on('ready', function() {
          // $("#images").fileinput();
          $("#images").fileinput({
              uploadUrl: "upload.php",
              uploadAsync: false,
              browseOnZoneClick: true, //activates the zone to click for browse
              // initialPreview: [
              //     'http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg',
              //     'http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg'
              // ],
              initialPreviewAsData: true,
              // initialPreviewConfig: [
              //     {caption: "Moon.jpg", size: 930321, width: "120px", key: 1},
              //     {caption: "Earth.jpg", size: 1218822, width: "120px", key: 2}
              // ],
              overwriteInitial: false,
              // maxFileSize: 100,
              initialCaption: "The Moon and the Earth",
              layoutTemplates: {
                footer:
                '<div class="file-thumbnail-footer">\n' +
                '<div style="margin:5px 0">\n' +
                '<input class="kv-input kv-new form-control input-sm text-center {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
                // '<input class="kv-input kv-init form-control input-sm text-center {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n' +
                '</div>\n' +
                '{size}\n' +
                '{actions}\n' +
                '</div>',

                size:
                '<samp><small>({sizeText})</small></samp>',

                actions:
                '<div class="file-actions">\n' +
                '    <div class="file-footer-buttons">\n' +
                '       {delete} {zoom}' +
                '    </div>\n' +
                '    {drag}\n' +
                '    <div class="file-upload-indicator" title="{indicatorTitle}">{indicator}</div>\n' +
                '    <div class="clearfix"></div>\n' +
                '</div>'
              },

              previewThumbTags: {
                '{TAG_VALUE}': '', // no value
                '{TAG_CSS_NEW}': '', // new thumbnail input
                '{TAG_CSS_INIT}': 'hide' // hide the initial input
              },

              uploadExtraData: function() {
                  var out = {}, key, name, ext, i = 0;
                  $('.kv-input:visible').each(function() {
                    $el = $(this);
                    key = $el.hasClass('kv-new') ? 'new_' + i : 'init_' + i;
                    name= $el.val();
                    ext= $el.val().split('.').pop();
                    if (name.length > ext.length) {
                      out[key] = name.substring(0,name.length-ext.length-1);
                    }else{
                      out[key] = name;
                    }
                    i++;
                    out['extra_size'] = i;
                  });
                  return out;
              }
          });

          $('#images').on('fileloaded', function(e, file, previewId, index, reader) {
             $('.file-live-thumbs').sortable();
          });

          $('#images').on('filebatchuploadsuccess', function(event, params) {
              console.log('File Batch uploaded params', params);
          });

          $('#images').on('filepreupload', function(event, params) {
              console.log('File thumbnail uploaded params', params);
          });

      });
    </script>
  </body>
</html>
