    <!-- jQuery UI -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/plugs/editor/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugs/editor/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" charset="utf-8">

	<!-- elRTE -->
	<script src="<?php echo base_url();?>assets/plugs/editor/js/elrte.min.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugs/editor/css/elrte.min.css" type="text/css" media="screen" charset="utf-8">

	<!-- elRTE translation messages -->
	<script src="<?php echo base_url();?>assets/plugs/editor/js/i18n/elrte.en.js" type="text/javascript" charset="utf-8"></script>
    
    <!---->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugs/file_manager/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <script src="<?php echo base_url();?>assets/plugs/file_manager/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url();?>assets/plugs/file_manager/js/elfinder.full.js" type="text/javascript" charset="utf-8"></script>
    <!---->
     <script type="text/javascript" charset="utf-8">
	
		$(document).ready(function() {
			var opts = {
				cssClass : 'el-rte',
				lang     : 'en',
				height   : 200,
				toolbar  : 'maxi',
				cssfiles : ['<?php echo base_url();?>assets/plugs/editor/css/elrte-inner.css'],
				fmOpen : function(callback) {
					$('<div id="myelfinder" />').elfinder({
						url : '<?php echo base_url();?>connectors/php/connector.php',
						lang : 'en',
						dialog : { width : 900, modal : true, title : 'File manager' },
						closeOnEditorCallback : true,
						editorCallback : callback
					})
				}
			}
			$('.editor').elrte(opts);
		})
	</script>