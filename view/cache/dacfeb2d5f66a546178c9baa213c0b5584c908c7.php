<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<style>
  .route-graph {
    display: grid;
    grid-template-columns: repeat(8, 40px);
    gap: 2px;
    padding: 20px;
  }

  .seat {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    color: white;
    border-radius: 5px;
  }

  .available {
    background-color: #32a850;
  }

  .booked {
    background-color: red;
  }
</style>

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row g-3">
      <?php if($role == 'Administrator'): ?>
      <div class="col-sm-8">
        <div class="row">
          <div class="col-sm-4">
            <div class="card">
              <div class="card-title ps-3">All Customers</div>
              <div class="card-body">
                <h2><?php echo e($customersCount); ?></h2>
              </div>
            </div>

          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-title ps-3">All Routes/ Journeys</div>
              <div class="card-body">
                <h2><?php echo e($routesCount); ?></h2>
              </div>
            </div>

          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-title ps-3">All Tickets For Today</div>
              <div class="card-body">
                <h2><?php echo e($todaysTicketCount); ?></h2>
              </div>
            </div>

          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-title ps-3">Tickets Paid Today</div>
              <div class="card-body">
                <h2><?php echo e($todaysPaidTicketCount); ?></h2>
              </div>
            </div>

          </div>
          <div class="col-sm-4">
            <div class="card">
              <div class="card-title ps-3">Tickets Un Paid Today</div>
              <div class="card-body">
                <h2><?php echo e($todaysUnPaidTicketCount); ?></h2>
              </div>
            </div>

          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-title ps-3">Revenue Today</div>
              <div class="card-body">
                <h2>Ugx <?php echo e($revenueToday); ?></h2>
              </div>
            </div>

          </div>

        </div>
      </div>
      <?php endif; ?>

      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <div class="alert alert-info mt-2 p-1">
              <strong>
                It is important to check the seats available for the route you plan to travel today. Ensure you book your seat early to avoid inconvenience.
              </strong>
            </div>
            <div>
              <strong>KEY FOR BOOKED AND AVAILABLE SEATS:</strong>
              <div class="d-flex align-items-center">
                <div class="mb-1 me-3">
                  <span>Available Seat Color<span class="seat available"></span></span>
                </div>
                <div class="mb-1">
                  <span>Booked Seat Color<span class="seat booked"></span></span>
                </div>
              </div>
            </div>

          </div>

          <form action="" class="m-2">
            <label for="">Select a route to get the seats available now</label>
            <select name="route-id" id="route-select" class="form-control">
              <option value="">Choose a route</option>
              <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($route['id']); ?>"><?php echo e($route['origin']); ?> -- <?php echo e($route['destination']); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </form>

          <div class="route-graph" id="route-graph">

          </div>

        </div>
      </div>

      <?php if($role == 'Customer'): ?>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Instructions for Booking a Ticket</h5>
            <ol>
              <li>Review the available seats by choosing your desired route in the left section.</li>
              <li>Choose your desired route from the routes section.</li>
              <li>Click book ticket and review your information.</li>
              <li>Proceed to payment and complete the booking process.</li>
              <li>After successful booking and payment, you will be able to print out your ticket.</li>
              <li>Arrive at the departure point on the scheduled date and time.</li>
              <li>Show your ticket to the staff and board the bus.</li>
              <li>Enjoy your journey!</li>
            </ol>

            <strong>Note that the seats are given out on first come, first serve basis.</strong>
            <p class="card-text">If you encounter any issues during the booking process, please contact our customer support for assistance.</p>
          </div>
        </div>
      </div>
      <?php endif; ?>

    </div>

    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    const routeGraph = $('#route-graph');

    $('#route-select').on('change', function() {
      const routeId = $(this).val();

      if (routeId) {
        $.ajax({
          url: `/<?php echo e($appName); ?>/routes/seats/?routeId=${routeId}`,
          method: 'GET',
          success: function(seats) {
            // Clear previous seats
            routeGraph.empty();

            // Append new seats
            seats.forEach(seat => {
              const seatElement = $('<div></div>');
              seatElement.addClass('seat ' + seat.status);
              seatElement.text(seat.seat_number);
              routeGraph.append(seatElement);
            });
          },
          error: function(error) {
            console.error('Error fetching seat data:', error);
          }
        });
      } else {
        // Clear the seat display if no route is selected
        routeGraph.empty();
      }
    });
  });
</script>