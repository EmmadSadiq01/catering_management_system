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
        <h1 class="h3 mb-0 text-gray-800">Kitchen List</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Reports</a> -->
    </div>
    <!-- card -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Todays Required</h6>
                    <!-- <div class="dropdown no-arrow">
                        <a class="dropdown-toggle p-2" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" id="add_vendor" href="#">Add Vendor</a>
                        </div>
                    </div> -->
                </div>
                <!-- Card Body -->
                <div class="card-body table_box">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM kitchen_list";
                            $reslt = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($reslt)) {

                            ?>
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php 
                                    echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT `name` FROM meal WHERE id=" . $row['item']))['name'] 
                                    ?></td>
                                    <td><?php echo $row['quantity'] ?></td>
                                  
                                </tr>
                            <?php
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
    $('#add_vendor').click(function() {
        uni_modal("Add Vendor", "containers/add_vendor.php")
    })
    $('.edit_vendor').click(function() {
        let id = $(this).attr('data-id')
        uni_modal("Add Vendor", "containers/add_vendor.php?id=" + id)
    })
</script>