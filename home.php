<div class="container-fluid">
  <!-- Page Heading -->

  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white">
    </div>
  </div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Reports</a>
  </div>
  <!-- card -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Open Orders</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-edit fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Close Order </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-tasks fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Money In</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rs 400,000</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-tasks fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                Money Out</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Rs 200,000</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <!-- Today Orders -->
    <div class="col-xl-8 col-lg-8">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Today Orders</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body table_box">
          <table id="table" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Order No</th>
                <th>Name</th>
                <th>Contact</th>
                <th width="30%">Order</th>
                <th>Balance</th>
                <th>Delivery Address</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * fROM order_details ORDER BY delivery_date ASC";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <td><?php echo $row['order_id'] ?></td>
                  <td><?php echo $row['party_name'] ?></td>
                  <td><?php echo $row['contact'] ?></td>
                  <td><?php
                      // fetch order
                      $sql_order = "SELECT * FROM booked_items WHERE order_id=" . $row['order_id'];
                      $result_order = mysqli_query($conn, $sql_order);
                      while ($row_order = mysqli_fetch_assoc($result_order)) {
                        // fetch menu detals
                        $sql_menu = "SELECT * FROM menu WHERE id=" . $row_order['menu_id'];
                        $result_menu = mysqli_query($conn, $sql_menu);
                        while ($row_menu = mysqli_fetch_assoc($result_menu)) {
                          echo $row_menu['name'] . " | ";
                        }
                      }
                      ?></td>
                  <td><?php echo $row['delivery_address'] ?></td>
                  <td><?php echo $row['delivery_date'] ?></td>
                  <!-- <td><button class="btn btn-outline-success" class="edit_booked_item" id="bk_<?php echo $row['order_id'] ?>"><i class="fas fa-edit"></i></button><button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button></td> -->
                  <td>
                    <?php
                    $payment = 0;
                    $sql_balance = "SELECT * FROM payments WHERE order_id=" . $row['order_id'];
                    $result_balance = mysqli_query($conn, $sql_balance);
                    while ($row_balance = mysqli_fetch_assoc($result_balance)) {
                      $payment += $row_balance['amount'];
                    }

                    echo (($payment > $row['grandTotal']) ? ($payment - $row['grandTotal']) : ($row['grandTotal'] - $payment))

                    ?>
                  </td>
                </tr>
              <?php
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Menu -->
    <div class="col-xl-4 col-lg-4">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Menu</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle p-2" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" id="add_menu" href="#">Add Menu</a>
            </div>
          </div>
        </div>
        <!-- Card Body -->
        <div class="card-body table_box">
          <table id="table1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Source</th>
                <th width="30%">Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM menu";
              $result = mysqli_query($conn, $sql);
              $no = 1;
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $row['name'] ?></td>
                  <td><?php echo $row['price'] ?></td>
                  <td><?php echo ($row['source'] === '1') ? 'Insource' : 'Outsource' ?> </td>
                  <td><?php echo $row['description'] ?></td>
                  <td><button class="btn btn-outline-success" class="edit_menu" id="<?php echo $row['id'] ?>" onclick="edit_menu(this.id)"><i class="fas fa-edit"></i></button><button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button></td>
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

<script type="text/javascript">
  $(document).ready(function() {
    $('#table').DataTable();
    $('#table1').DataTable();
  });
  $('#add_menu').click(function() {
    uni_modal("Add Menu", "containers/add_menu.php")
  })
  const edit_menu = (id) => {
    uni_modal("Edit Menu", "containers/add_menu.php?id=" + id)
  }
</script>