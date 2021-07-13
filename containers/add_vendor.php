<?php
include '../database/db_connect.php';
// echo "<script>console.log('hello'," . $_GET['id'] . ")</script>";
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM vendor where id =" . $_GET['id'])->fetch_array();
    foreach ($qry as $k => $v) {
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form id="add_vendor_frm">
        <div class="form-group">
            <label>Vendor Name:</label>
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : "" ?>" />
            <input type="text" name="name" required="required" class="form-control" value="<?php echo isset($name) ? $name : "" ?>" />
        </div>
        <div class="form-group">
            <label>Contact:</label>
            <input type="number" name="contact" required="required" class="form-control" value="<?php echo isset($contact) ? $contact : "" ?>" />
        </div>
        <div class="form-group">
            <label>CNIC:</label>
            <input type="text" name="cnic" required="required" class="form-control" value="<?php echo isset($cnic) ? $cnic : "" ?>" />
        </div>
        <div class="form-group">
            <label>Item:</label>
            <select name="item" id="type" class="custom-select">
                <option value="">select</option>
                <?php
                $sql_item = "SELECT * FROM meal ORDER BY `name` ASC";
                $result_item = mysqli_query($conn, $sql_item);
                while ($row_item = mysqli_fetch_assoc($result_item)) {
                ?>
                    <option value="<?php echo $row_item["id"] ?>" <?php echo (isset($item_id) && $item_id == $row_item["id"]) ? "selected" : "" ?>> <?php echo $row_item["name"] ?></option>';
                <?php
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" cols="30" rows="2" class="form-control"><?php echo isset($address) ? $address : "" ?></textarea>

        </div>
        <div class="form-group">
            <label>Remarks:</label>
            <textarea name="remarks" cols="30" rows="2" class="form-control"><?php echo isset($remarks) ? $remarks : "" ?></textarea>

        </div>


    </form>
</div>
<script>
    $(document).ready(function() {
        $('#add_vendor_frm').submit(function(e) {
            e.preventDefault()
            start_load();
            $.ajax({

                url: './controllers/ajax.php?action=add_vendor',
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