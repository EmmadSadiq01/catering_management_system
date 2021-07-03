<style>
    @import url('select_with_search/select2.min.css');

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

    option[value=""][disabled] {
        display: none;
    }

    .select2-container {
        width: 100% !important;
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment</h1>
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
                    <form id="add_payment_frm">
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="my-form-group">
                                    <select id="payment_party" name="payment_party" class="custom-select" require onchange="balanceChange()">
                                        <option value="">Select Party*</option>
                                        <?php
                                        $sql = "SELECT * FROM order_details ORDER BY party_name ASC";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $payment = 0;
                                            $sql_balance = "SELECT * FROM payments WHERE order_id=" . $row['order_id'];
                                            $result_balance = mysqli_query($conn, $sql_balance);
                                            while ($row_balance = mysqli_fetch_assoc($result_balance)) {
                                                $payment += $row_balance['amount'];
                                            }
                                            echo '<option value="' . $row['order_id'] . '" data-balance="' . (($payment > $row['grandTotal']) ? ($payment - $row['grandTotal']) : ($row['grandTotal'] - $payment)) . '">' . $row['party_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="my-form-group">
                                    <select id="type" name="type" require class="custom-select">
                                        <option value="" disabled selected>Type*</option>
                                        <option value="0">Advance</option>
                                        <option value="1">Balance</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="my-form-group">
                                    <input type="number" name="paid_amount" min="0" id="amount" onchange="balanceChange()" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Amount*</label>
                                </div>

                            </div>
                            <!-- <div class="col-12 col-md-6">

                                <div class="my-form-group">
                                    <input type="text" name="description" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Description</label>
                                </div>

                            </div> -->
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label for="">Balance</label>
                                    <input type="text" name="balance" class="form-control" id="balance" required disabled>
                                </div>

                            </div>


                            <div class="col-12 col-md-12">
                                <div class="submit-form-group">
                                    <input type="submit" class="btn btn-success edit_btn" value="ADD" />

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- <table id="table    " class="table table-bordered table-striped">
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
                    </table> -->
                </div>
            </div>
        </div>
    </div>


</div>

<script src="select_with_search/select2.min.js"></script>
<script>
    $("#payment_party").select2({
        placeholder: "Select Payment Party*",
        allowClear: true
    });
    const showBalance = (balance) => {
        $('#balance').val($("[value='" + balance + "']").attr("data-balance"))
    }
    const balanceChange = () => {
        let amount = ($("#amount").val() === "") ? 0 : $("#amount").val();
        let previous_balance = $("#payment_party option:selected").attr("data-balance")
        console.log(amount, previous_balance)
        $('#balance').val(previous_balance - amount)
    }

    $('#add_payment_frm').submit(function(e) {
        e.preventDefault()
        start_load();
        $.ajax({

            url: './controllers/ajax.php?action=add_payment',
            method: "POST",
            data: $(this).serialize(),
            error: err => console.log(),
            success: function(resp) {
                if (resp == 1) {
                    window.alert_toast("Payment successfully Add", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1000)
                }
            }
        })
    })
</script>