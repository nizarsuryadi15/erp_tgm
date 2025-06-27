<?php 
    if ($getproduk['subkategori_id']== '105'){ ?>
    <div class="form-group">
        <label for="ukuran" class="col-md-3">Ukuran</label>
        <div class="input-group mb-md col-md-9">
            <div class="row">
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="panjang" placeholder="Panjang" required>
                    <input type="hidden" class="form-control" name="lebar" placeholder="Panjang" value="1" required>
                    
                </div>
                <div class="col-sm-1">x</div>
                <div class="col-sm-6">
                    <select name="ket_1" id="" class="form-control">
                        <option value="1">0.6</option>
                        <option value="2">0.9</option>
                        <option value="3">0.100</option>
                        <option value="4">0.120</option>
                        <option value="5">0.150</option>
                        <option value="6">0.200</option>
                    </select> 
                </div>
            </div>
        </div>    
    </div>
    <?php 
    }
    ?>
                
                
                