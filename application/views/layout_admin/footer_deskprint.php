

<!-- Bottom Navigation khusus Mobile -->
<!-- <nav class="navbar bottom-nav">
	<ul class="nav nav-pills nav-justified">
		<li class="active"><a href="https://tgmprint.com/dashboard"><span class="glyphicon glyphicon-home"></span><br>Home</a></li>
		<li><a href="https://tgmprint.com/profile/myprofile"><span class="glyphicon glyphicon-user"></span><br>Profile</a></li>
		<li><a href="https://tgmprint.com/product/"><span class="glyphicon glyphicon-list"></span><br>Product</a></li>
		<li><a href="https://tgmprint.com/karyawan/absen"><span class="glyphicon glyphicon-plus"></span><br>Absen</a></li>
		<li><a href="https://tgmprint.com/auth/logout"><span class="glyphicon glyphicon-off"></span><br>Logout</a></li>
	</ul>
</nav> -->


<!-- Vendor -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://tgmprint.com/assets/vendor/jquery/jquery.js"></script>
		<script src="https://tgmprint.com/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<!-- <script src="https://tgmprint.com/assets/vendor/bootstrap/js/bootstrap.js"></script> -->
		<script src="https://tgmprint.com/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="https://tgmprint.com/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="https://tgmprint.com/assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="https://tgmprint.com/assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="https://tgmprint.com/assets/vendor/select2/js/select2.js"></script>
		<script src="https://tgmprint.com/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="https://tgmprint.com/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		<!-- <script src="https://tgmprint.com/assets/vendor/jquery-appear/jquery-appear.js"></script> -->
		<!-- <script src="https://tgmprint.com/assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script> -->
		<script src="https://tgmprint.com/assets/vendor/flot/jquery.flot.js"></script>
		<script src="https://tgmprint.com/assets/vendor/flot.tooltip/flot.tooltip.js"></script>
		<script src="https://tgmprint.com/assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="https://tgmprint.com/assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="https://tgmprint.com/assets/vendor/flot/jquery.flot.resize.js"></script>
		<!-- <script src="https://tgmprint.com/assets/vendor/jquery-sparkline/jquery-sparkline.js"></script> -->
		<!-- <script src="https://tgmprint.com/assets/vendor/raphael/raphael.js"></script> -->
		<!-- <script src="https://tgmprint.com/assets/vendor/morris.js/morris.js"></script> -->
		<!-- <script src="https://tgmprint.com/assets/vendor/gauge/gauge.js"></script> -->
		<!-- <script src="https://tgmprint.com/assets/vendor/snap.svg/snap.svg.js"></script> -->
		<!-- <script src="https://tgmprint.com/assets/vendor/liquid-meter/liquid.meter.js"></script> -->
		<script src="https://tgmprint.com/assets/vendor/chartist/chartist.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="https://tgmprint.com/assets/javascripts/theme.js"></script>
		<script src="https://tgmprint.com/assets/javascripts/ui-elements/examples.modals.js"></script>
		
		<!-- Theme Custom -->
		<script src="https://tgmprint.com/assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="https://tgmprint.com/assets/javascripts/theme.init.js"></script>

		<!-- Examples -->
		<script src="https://tgmprint.com/assets/javascripts/tables/examples.datatables.editable.js"></script>
		<!-- Examples -->
		
		<script src="https://tgmprint.com/assets/javascripts/tables/examples.datatables.default.js"></script>
		<!-- <script src="https://tgmprint.com/assets/javascripts/tables/examples.datatables.row.with.details.js"></script> -->
		<script src="https://tgmprint.com/assets/javascripts/tables/examples.datatables.tabletools.js"></script>

		<script src="https://tgmprint.com/assets/vendor/jquery-validation/jquery.validate.js"></script>
		<script src="https://tgmprint.com/assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
		<script src="https://tgmprint.com/assets/vendor/pnotify/pnotify.custom.js"></script>
		<script src="https://tgmprint.com/assets/javascripts/ui-elements/examples.notifications.js"></script>
		<script src="https://tgmprint.com/assets/javascripts/ui-elements/examples.lightbox.js"></script>
		<script src="https://tgmprint.com/assets/app.js"></script>
		<script src="https://tgmprint.com/assets/javascripts/ui-elements/examples.charts.js"></script>
		<script src="https://tgmprint.com/assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="https://tgmprint.com/assets/javascripts/pages/examples.mediagallery.js"></script>

		<!-- <script src="assets/javascripts/ui-elements/examples.charts.js"></script> -->
		<script>
			// Format angka saat diketik
			document.getElementById('rupiah').addEventListener('input', function () {
				let value = this.value.replace(/\D/g, '');
				this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
			});

			// Hapus titik saat form disubmit
			document.getElementById('formku').addEventListener('submit', function () {
				let input = document.getElementById('rupiah');
				input.value = input.value.replace(/\./g, ''); // hapus semua titik
			});
		</script>

		

		<script type="text/javascript">
			$(document).ready(function(){
				$('#kategori_id').change(function(){
					var id=$(this).val();
					$.ajax({
						url : "https://tgmprint.com/product/get_subkategori",
						method : "POST",
						data : {id: id},
						async : false,
						dataType : 'json',
						success: function(data){
							var html = '';
							var i;
							for(i=0; i<data.length; i++){
								html += '<option value='+data[i].subkategori_id+'>'+data[i].subkategori_nama+'</option>';
							}
							$('.subkategori').html(html);
							
						}
					});
				});
			});
		</script>

		<script type="text/javascript">
			$(document).ready(function(){
				$('#bahan_finishing').change(function(){
					var id=$(this).val();
					$.ajax({
						url : "https://tgmprint.com/transaksi/get_finishing",
						method : "POST",
						data : {id: id},
						async : false,
						dataType : 'json',
						success: function(data){
							var html = '';
							var i;
							for(i=0; i<data.length; i++){
								html += '<option value='+data[i].harga_id+'>'+data[i].detail_product+'</option>';
							}
							$('.finishing').html(html);
							
						}
					});
				});
			});
		</script>

		<script type="text/javascript">
			$(document).ready(function(){
				$('#subkategori_id').change(function(){
					var id=$(this).val();
					$.ajax({
						url : "https://tgmprint.com/transaksi/get_largeformat",
						method : "POST",
						data : {id: id},
						async : false,
						dataType : 'json',
						success: function(data){
							var html = '';
							var i;
							for(i=0; i<data.length; i++){
								html += '<option value='+data[i].bahan_id+'>'+data[i].bahan_nama+'</option>';
							}
							$('.bahan').html(html);
							
						}
					});
				});
			});
		</script>


		<script type="text/javascript">
			$(document).ready(function(){
				$('.copy-btn').on("click", function(){
					$("#text-copy").select();
					document.execCommand("copy");
					// alert('text copied...');
				})
			})
		</script>


		<script>
			(function($) {
			'use strict';

			var datatableInit = function() {
				var $table = $('#datatable-details');

				// format function for row details
				var fnFormatDetails = function( datatable, tr ) {
					var data = datatable.fnGetData( tr );
					
					return [
						'<table class="table">',
							// '<tr class="b-top-none">',
							'<tr>',
								'<td>' + data[6] + '</td>',
							'</tr>',
							
							
						'</table>'
					].join('');
				};

				// insert the expand/collapse column
				var th = document.createElement( 'th' );
				var td = document.createElement( 'td' );
				td.innerHTML = '<i data-toggle class="fa fa-plus-square-o text-primary h5 m-none" style="cursor: pointer;"></i>';
				td.className = "text-center";

				$table
					.find( 'thead tr' ).each(function() {
						this.insertBefore( th, this.childNodes[0] );
					});

				$table
					.find( 'tbody tr' ).each(function() {
						this.insertBefore(  td.cloneNode( true ), this.childNodes[0] );
					});

				// initialize
				var datatable = $table.dataTable({
					aoColumnDefs: [{
						bSortable: false,
						aTargets: [ 0 ]
					}],
					aaSorting: [
						[1, 'asc']
					]
				});

				// add a listener
				$table.on('click', 'i[data-toggle]', function() {
					var $this = $(this),
						tr = $(this).closest( 'tr' ).get(0);

					if ( datatable.fnIsOpen(tr) ) {
						$this.removeClass( 'fa-minus-square-o' ).addClass( 'fa-plus-square-o' );
						datatable.fnClose( tr );
					} else {
						$this.removeClass( 'fa-plus-square-o' ).addClass( 'fa-minus-square-o' );
						datatable.fnOpen( tr, fnFormatDetails( datatable, tr), 'details' );
					}
				});
			};

			$(function() {
				datatableInit();
			});

			}).apply(this, [jQuery]);
		</script>
		


		
			
	</body>
</html>