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
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Reports</a> -->
    </div>
    <!-- card -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Vendors</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle p-2" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" id="add_menu" href="#">Add Vendor</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body table_box">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Vendor No</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>CNIC</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


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
    $('#add_menu').click(function() {
        uni_modal("Add Vendor", "containers/add_vendor.php")
    })
</script>