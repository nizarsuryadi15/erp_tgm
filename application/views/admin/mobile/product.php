<div class="container py-4">
  <h4 class="mb-3">Daftar Produk</h4>
  <div class="mb-3">
    <!-- <input type="text" id="searchInput" class="form-control" placeholder="Cari produk..."> -->

  </div>
  <!-- <div id="productList"></div> -->
  <?php 
    $this->load->view('admin/mobile/product_list');
  ?>


</div>

<script>
function loadProduct(page = 1) {
    var keyword = $('#searchInput').val(); // ID cocok

    $.get("<?= base_url('mobile/ajax_list') ?>", { page: page, keyword: keyword }, function(data){
        $('#productList').html(data);
    });
}

$(document).ready(function(){
    loadProduct();

    $('#searchInput').on('keyup', function(){
        loadProduct(); // Muat ulang saat pencarian diketik
    });

    $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    var page = $(this).attr("data-ci-pagination-page");
    if (page) loadProduct(page);
    
});
</script>
