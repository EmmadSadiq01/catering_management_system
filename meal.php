<style>
    .table_box {
        height: unset;
    }

    .menu_item p {
        margin-bottom: 0px;
    }

    .menu_item {
        width: fit-content;
        color: white;
        padding: 10px 10px;
        border-radius: 10px;
        height: fit-content;
        margin: 0px 4px;
    }

    .menu_item:hover {
        cursor: pointer;
    }

    .drop-box {
        width: 100%;
        height: 200px;
        border: 1px solid;
        padding: 20px;
        border-radius: 20px;
    }

    .dragable_mennu {
        width: 100%;
        height: 100%;
        border: 1px solid;
        padding: 20px;
        border-radius: 20px;
        display: flex;
    }

    .submit-form-group {
        display: flex;
        justify-content: center;
        margin: 10px 0px;
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Meal</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Reports</a>
    </div>
    <!-- card -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Meal Form</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body table_box">
                    <form id="add_meal_frm">
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="my-form-group">
                                    <input type="text" name="name" id="name" required>
                                    <input type="hidden" name="id" id="id">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Name</label>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <div class="my-form-group">
                                    <input type="number" name="mael_price" id="price" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Price (-/kg)</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="submit-form-group">
                                    <input type="submit" class="btn btn-success edit_btn" value="ADD" />

                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="table    " class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM meal";
                            $result = mysqli_query($conn, $sql);
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                    <td><button class="btn btn-outline-success" data-price="<?php echo $row['price'] ?>" data-name="<?php echo $row['name'] ?>" id="<?php echo $row['id'] ?>" onclick="edit_menu(this.id)"><i class="fas fa-edit"></i></button><button class="btn btn-outline-danger" onclick="del_meal(this.id)" id="d_<?php echo $row['id']  ?>" data-id="<?php echo $row['id'] ?>"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
    $('#add_meal_frm').submit(function(e) {
        e.preventDefault()
        start_load();
        $.ajax({

            url: './controllers/ajax.php?action=add_meal',
            method: "POST",
            data: $(this).serialize(),
            error: err => console.log(),
            success: function(resp) {
                if (resp == 1) {
                    window.alert_toast("Meal data successfully Add", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1000)
                }
            }
        })
    })
    const edit_menu = (id) => {
        $("#id").val(id)
        $("#name").val($('#' + id).attr('data-name'))
        $("#price").val($('#' + id).attr('data-price'))
        $(".submit-form-group").html('<input type="submit" class="btn btn-success update_btn" value="Update" /><button class="btn btn-danger" onclick="edit_cancel()">Cancel</button>')


    }
    const edit_cancel = () => {
        $("#id").val("")
        $("#name").val("")
        $("#price").val("")
        $(".submit-form-group").html('<input type="submit" class="btn btn-success edit_btn" value="ADD" />')
    }
    const del_meal = (id) => {
       console.log($('#' + id).attr('data-id'))
       if(confirm("Do you want to delete ?")){
        start_load();
        $.ajax({

            url: './controllers/ajax.php?action=del_meal&id='+$('#' + id).attr('data-id'),
            method: "POST",
            data: $(this).serialize(),
            error: err => console.log(),
            success: function(resp) {
                if (resp == 1) {
                    window.alert_toast("Meal data successfully Deleted", "danger");
                    setTimeout(function() {
                        location.reload();
                    }, 1000)
                }
            }
        })
       }
    }
</script>