<?php
function making_menu()
{
    global $conn;
    $output = '';
    $query = "SELECT * FROM menu ORDER BY `name` ASC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="' . $row["id"] . '" data-price="' . $row["price"] . '">' . $row["name"] . '</option>';
    }
    return $output;
}
function meal_menu()
{
    global $conn;
    $output = '';
    $query = "SELECT * FROM meal ORDER BY `name` ASC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="' . $row["id"] . '" data-price="' . $row["price"] . '">' . $row["name"] . '</option>';
    }
    return $output;
}
?>

<style>
    @import url('select_with_search/select2.min.css');

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

    /* .menu_item i {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #da2424;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 12px;
        display: none;
    }

    .drop-box .menu_item i {
        display: flex;
    } */
    .table_box {
        height: unset;
    }

    #addMenuBox .row {
        margin-top: 10px;
    }

    #addMenuBox .col-2.small-6.columns {
        padding: 4px;
    }

    .total-form-group {
        width: 40%;
        float: right;
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Reports</a>
    </div>
    <!-- card -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Form</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body table_box">
                    <form id="booked_menu_frm">
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="my-form-group">
                                    <!-- <input type="text" name="name" required> -->
                                    <select name="order_type" id="order_type" class="custom-select" onchange="orderType()">
                                        <option value="" disabled selected>select</option>
                                        <option value="vendor">Vendor</option>
                                        <option value="normal">normal</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <div class="my-form-group" id="vendor_select" style="display:none">
                                    <select id="vender_order" name="vender_order" class="custom-select" require>
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
                                <div class="my-form-group" id="order_name" style="display:none">
                                    <input type="text" name="name" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Name</label>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <div class="my-form-group">
                                    <input type="date" name="delivery_date" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Delivery Date</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="my-form-group">
                                    <input type="text" name="contact" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Contact</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="my-form-group">
                                    <input type="text" name="cnic" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>CNIC</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="my-form-group">
                                    <input type="text" name="customer_address" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Delivery Address</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="my-form-group">
                                    <input type="text" name="delivery_address" required>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Customer Address</label>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-md-12">
                                <div class="drop-box" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            </div> -->
                            <div class="col-12 col-md-12">
                                <div class="items_box">
                                    <h1>Items</h1>
                                    <div id="addMenuBox">
                                        <div class="row">
                                            <input type="hidden" id="menuId">
                                            <div class="col-2 small-6 columns">
                                                <select name="menu_id[]" class="form-control" placeholder="Item Name" id="it_1" onchange="Total(this.id)">
                                                    <option value="">select</option>
                                                    <?php echo making_menu(); ?>
                                                </select>
                                            </div>
                                            <div class="col-2 small-6 columns">
                                                <input type="number" name="making_qty[]" class="form-control" placeholder="Qty." value="1" min="1" id="qa_1" onchange="Total(this.id)">
                                            </div>
                                            <div class="col-2 small-6 columns">
                                                <input type="number" name="meal_qty[]" class="form-control" placeholder="Qty." value="1" min="1" id="qb_1" onchange="Total(this.id)">
                                            </div>
                                            <div class="col-2 small-6 columns">
                                                <select name="meal_id[]" class="form-control" placeholder="meal" min="1" id="mb_1" onchange="Total(this.id)">
                                                    <option value="">select</option>
                                                    <?php echo meal_menu(); ?>
                                                </select>
                                            </div>
                                            <div class="col-2 small-6 columns">
                                                <input type="number" class="form-control total" id="to_1" name="total[]">

                                            </div>
                                            <div class="col-2 small-6 columns">
                                                <select name="provided[]" class="form-control" id="pr_1" onchange="Total(this.id)">
                                                    <option value="0" selected>Not Provided</option>
                                                    <option value="1">Provided</option>
                                                </select>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-12">
                                <div class="submit-form-group">
                                    <!-- <input type="button" class="btn btn-success" onchange="getTotal()" value="Calculate" /> -->
                                    <!-- <div class="btn btn-primary" onchange="getTotal()">Calculate</div> -->
                                    <div class="btn btn-primary" onclick="getTotal()">Calculate</i></div>
                                    <div class="btn btn-warning" id="add_1" onclick="addMenu()"><i class="fas fa-plus"></i></div>
                                    <div class="btn btn-danger" id="add_1" onclick="Delete_row()"><i class="fas fa-trash"></i></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="total-form-group">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">TOTAL</label>
                                        <input type="number" class="form-control" name="sum" id="sum">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">DISCOUNT</label>
                                        <input type="number" class="form-control" name="discount" id="discount" value="0" min="0" onchange="getTotal()">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">PAID</label>
                                        <input type="number" class="form-control" name="grandTotal" id="grandTotal">
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="submit-form-group">
                                    <input type="submit" class="btn btn-success" value="Confirm Booking" />
                                    <!-- <div class="btn btn-warning" id="add_1" onclick="addMenu()"><i class="fas fa-plus"></i></div>
                                    <div class="btn btn-danger" id="add_1" onclick="Delete_row()"><i class="fas fa-trash"></i></div> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>


</div>
<script src="select_with_search/select2.min.js"></script>
<script>
    let add_row = 2;

    function allowDrop(ev) {
        ev.preventDefault();
    }

    $("#vender_order").select2({
        placeholder: "Select Payment Party*",
        allowClear: true
    });

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
    }
    $('#booked_menu_frm').submit(function(e) {
        e.preventDefault()
        // console.log("runing...")
        start_load();
        $.ajax({

            url: './controllers/ajax.php?action=book_menu',
            method: "POST",
            data: $(this).serialize(),
            error: err => console.log(),
            success: function(resp) {
                if (resp) {
                    window.alert_toast("Menu data successfully Booked", "success");
                    setTimeout(function() {
                        location.reload();

                    }, 1000)
                }
            }
        })
    })
    const addMenu = () => {
        let html = '';

        html += '<div class="row">'
        html += '<div class="col-2  small-6 columns">'
        html += '<select name="menu_id[]" class="form-control"  placeholder="Item Name" id="it_' + add_row + '"  onchange="Total(this.id)">'
        html += ' <option value="">select</option>'
        html += '  <?php echo making_menu(); ?></select>'
        html += ' </div>'
        html += ' <div class="col-2 small-6 columns">'
        html += '<input type="number" name="making_qty[]" class="form-control" min="1" value="1" id="qa_' + add_row + '" placeholder="Qty." onchange="Total(this.id)">'
        html += '</div>'
        html += '<div class="col-2 small-6 columns">'
        html += '<input type="number" name="meal_qty[]" class="form-control" min="1" value="1" id="qb_' + add_row + '" placeholder="Qty." onchange="Total(this.id)">'
        html += '</div>'
        html += '<div class="col-2 small-6 columns">'
        html += '<select name="meal_id[]" class="form-control" placeholder="meal" id="mb_' + add_row + '" onchange="Total(this.id)">'
        html += '<option value="">select</option>'
        html += '<?php echo meal_menu(); ?></select>'
        html += '</div>'
        html += '<div class="col-2 small-6 columns">'
        html += '<input type="number" class="form-control total"  name="total[]" id="to_' + add_row + '">'
        html += '</div>'
        html += '<div class="col-2 small-6 columns">'
        html += '<select name="provided[]" class="form-control" id="pr_' + add_row + '" onchange="Total(this.id)">'
        html += '<option value="0" selected>Not Provided</option>'
        html += '<option value="1">Provided</option>'
        html += '</select>'
        html += '</div>'
        html += '</div>'
        $('#addMenuBox').append(html);
        add_row += 1;


    }
    const Delete_row = () => {
        $('#addMenuBox').children().last().remove();
    }
    const Total = (SelectId) => {
        let id = SelectId.split("_");
        id = id[1]
        let making_price = $("#it_" + id + " option:selected").attr("data-price")
        let qty_a = $("#qa_" + id).val()
        let qty_b = $("#qb_" + id).val()
        let meal_price = $("#mb_" + id + " option:selected").attr("data-price")
        if ($("#pr_" + id + " option:selected").val() == "1") {
            $("#to_" + id).val(making_price * qty_a)
        } else {
            $("#to_" + id).val((making_price * qty_a) + (qty_b * meal_price))

        }
    }
    const getTotal = () => {
        var sum = 0;
        $('.total').map((i, e) => {
            sum += parseInt(e.value)
        })
        $("#sum").val(sum)
        $("#grandTotal").val(sum - parseInt($('#discount').val()))
    }
    const orderType = () => {
        let type = $("#order_type option:selected").val()
        if (type == "vendor") {
            $("#vendor_select").show()
            $("#order_name").hide()
        } else if (type == "normal") {
            $("#vendor_select").hide()
            $("#order_name").show()
        }

    }
</script>