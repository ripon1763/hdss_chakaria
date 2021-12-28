

    <footer class="main-footer">
        <div class="pull-right">
		  Developed & Maintain by IT, <a href="http://www.icddrb.org">icddr,b</a>.
         <!-- <b>Developed</b> by | icddr,b  -->
        </div>
		<div class="hidden-xs">
          <strong>Copyright &copy; <?php echo DATE('Y') ?> <a class="no-print" href="<?php echo base_url(); ?>">icddr,b</a>.</strong> All rights reserved.
	    </div>
    </footer>
    
    <!-- jQuery UI 1.11.2 -->
    <!-- <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script> -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.2 JS -->

    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
	
	<!-- DataTables -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.multifile.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/wickedpicker.js"></script>
	<script src="<?php echo base_url('assets/plugins/datatables.colvis/dataTables.colVis.js')?>"></script>
    
    <script type="text/javascript">
	    
        var windowURL = window.location.href;
        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
        var x= $('a[href="'+pageURL+'"]');
            x.addClass('active');
            x.parent().addClass('active');
        var y= $('a[href="'+windowURL+'"]');
            y.addClass('active');
            y.parent().addClass('active');
    </script>
  </body>
</html>