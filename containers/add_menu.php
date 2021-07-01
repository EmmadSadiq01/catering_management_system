<?php
include '../database/db_connect.php';
// echo "<script>console.log('hello'," . $_GET['id'] . ")</script>";
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM menu where id =" . $_GET['id'])->fetch_array();
    foreach ($qry as $k => $v) {
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form id="add_menu_frm">
        <div class="form-group">
            <label>Item Name:</label>
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : "" ?>" />
            <input type="text" name="name" required="required" class="form-control" value="<?php echo isset($name) ? $name : "" ?>" />
        </div>
        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" required="required" class="form-control" value="<?php echo isset($price) ? $price : "" ?>" />
        </div>
        <div class="form-group">
            <label>Source:</label>
            <select name="source" id="type" class="custom-select">
                <option value="1" <?php echo isset($source) && $source == 1 ? 'selected' : 'selected' ?>>Insource</option>
                <option value="2" <?php echo isset($source) && $source == 2 ? 'selected' : '' ?>>Outsource</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" cols="30" rows="2" class="form-control"><?php echo isset($description) ? $description : "" ?></textarea>

        </div>


    </form>
</div>
<script>
    $(document).ready(function() {
        $('#add_menu_frm').submit(function(e) {
            e.preventDefault()
            start_load();
            $.ajax({

                url: './controllers/ajax.php?action=add_menu',
                method: "POST",
                data: $(this).serialize(),
                error: err => console.log(),
                success: function(resp) {
                    if (resp == 1) {
                        window.alert_toast("Menu data successfully saved", "success");
                        setTimeout(function() {
                            location.reload();

                        }, 1000)
                    }
                }
            })
        })
    })
</script>