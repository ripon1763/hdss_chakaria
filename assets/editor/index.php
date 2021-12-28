<!DOCTYPE html>
<html>
        <head>
                <meta charset="utf-8">
                <title>CKEditor</title>
				<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <script src="http://localhost/editor2/ckeditor/ckeditor.js"></script>
        </head>
        <body>
                <textarea id="editor1" name="editor1" rows="10" cols="80"></textarea>
                
				
					<script>
var roxyFileman = 'http://localhost/editor2/fileman/index.html?integration=ckeditor';
$(function(){
  CKEDITOR.replace( 'editor1',{filebrowserBrowseUrl:roxyFileman, 
                               filebrowserImageBrowseUrl:roxyFileman+'&type=image',
                               removeDialogTabs: 'link:upload;image:upload'});
});
</script>
					
        </body>
</html>