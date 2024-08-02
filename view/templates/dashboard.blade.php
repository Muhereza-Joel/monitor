@include('partials/header')
@include('partials/topBar')
@include('partials/leftPane')

<style>
  .tippy-box[data-theme~='tomato'] {
    background-color: #1a252f;
    color: #fff;
  }
</style>

<main id="main" class="main">
  <section class="section dashboard">
    <div class="alert alert-warning mt-2 px-3 py-1">
      <h5>Welcome back, {{$username}}</h5>
      <h6 class="fw-bold">| modifying data is allowed to only members of this organisation. Non-members can only view data.</h6>
      <hr>
      <h6 class="badge bg-primary">
        You are on the
        @if($role == 'Administrator')
        Administrator
        @elseif($role == 'Viewer')
        Viewer
        @else
        User
        @endif
        dashboard
      </h6>
    </div>

    @if($role == 'Viewer')
    <div class="alert alert-danger p-2">
      {{$username}}, your permissions only allow you to view data. If you need to modify or delete any information, please contact the Administrator to update your permissions.
    </div>
    @endif

    <div class="row g-1 mt-4">
      <div class="col-md-3">
        <div class="row g-1">
          <div class="">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">All <span>| Active Indicators</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-graph-up"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$indicatorsCount}}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">All <span>| Active Responses</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-check-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$responsesCount}}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator')
          <div class="">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Your <span>| Responses</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-check-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$userResponsesCount}}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif

          <div class="">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">All <span>| Users</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-circle"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$usersCount}}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <div class="col-md-9">
        <div class="row">
          <div class="col">

            <div class="card info-card calendar-card">
              <div class="card-body">
                
                <div class="card-title">
                  <div class="d-flex flex-row justify-content-between align-items-center">
                    <h5 class="mb-0">Events Calendar</h5>
                    <div class="d-flex align-items-center">
                      <span class="mr-2 mb-0">Filter By</span>
                      <div class="d-flex align-items-center mx-3 form-group mb-0 ml-3">
                        <select class="form-control" id="visibilityFilter">
                          <option value="all">All - public</option>
                          @if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator')
                          <option value="internal">Internal - private</option>
                          @endif
                          <option value="external">External - public</option>
                        </select>
                      </div>
                      <div class="d-flex align-items-center ml-4">
                        <span class="mb-0 mx-2">Key:</span>
                        <div class="d-flex align-items-center mr-3">
                          <div style="width: 20px; height: 20px; background-color: #5e1119; margin-right: 5px;"></div>
                          <span class="me-3">All</span>
                        </div>
                        <div class="d-flex align-items-center mr-3">
                          <div style="width: 20px; height: 20px; background-color: #911180; margin-right: 5px;"></div>
                          <span class="me-3">Internal</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div style="width: 20px; height: 20px; background-color: #0a4663; margin-right: 5px;"></div>
                          <span class="me-3">External</span>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {
    var calendarEl = document.getElementById('calendar');
    var visibilityFilter = $('#visibilityFilter');
    var events = [];

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth,dayGridYear'
      },
      views: {
        dayGridMonth: {
          buttonText: 'Month'
        },
        timeGridWeek: {
          buttonText: 'Week'
        },
        timeGridDay: {
          buttonText: 'Day'
        },
        listMonth: {
          buttonText: 'List'
        },
        dayGridYear: {
          buttonText: 'Year'
        }
      },
      events: events,
      selectable: true,
      eventContent: function(arg) {
        let container = document.createElement('div');
        container.classList.add('fc-event-content');

        let logoWrapper = document.createElement('div');
        logoWrapper.style.backgroundColor = 'white';
        logoWrapper.style.padding = '2px';
        logoWrapper.style.display = 'inline-block';

        let logoImg = document.createElement('img');
        logoImg.src = arg.event.extendedProps.logo;
        logoImg.style.width = '20px';
        logoImg.style.height = '20px';
        logoImg.style.verticalAlign = 'middle';

        logoWrapper.appendChild(logoImg);

        let titleSpan = document.createElement('span');
        titleSpan.innerText = arg.event.title;
        titleSpan.style.marginLeft = '5px';

        container.appendChild(logoWrapper);
        container.appendChild(titleSpan);

        return {
          domNodes: [container]
        };
      },
      eventDidMount: function(info) {
        tippy(info.el, {
          content: info.event.title,
          placement: 'top',
          theme: 'tomato',
        });

        // Set background color based on viewer value
        let viewer = info.event.extendedProps.viewer;
        if (viewer === 'all') {
          info.el.style.backgroundColor = '#5e1119';
        } else if (viewer === 'internal') {
          info.el.style.backgroundColor = '#911180';
        } else if (viewer === 'external') {
          info.el.style.backgroundColor = '#0a4663';
        }
      }
    });

    fetchEvents('all');

    function fetchEvents(visibility) {
      var url = '/{{$appName}}/events/get-events/';
      if (visibility && visibility !== '') {
        url += '?visibility=' + visibility;
      }

      $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
          events = response.response.map(event => ({
            title: stripHtml(event.title),
            start: event.start,
            end: event.end,
            logo: event.logo,
            viewer: event.viewer // Assuming this property exists in your event data
          }));

          if (events.length === 0) {
            Toastify({
              text: "There are no events to display on the calendar!",
              duration: 8000,
              gravity: 'bottom',
              position: 'right',
              backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
            }).showToast();
          }

          calendar.getEventSources().forEach(function(eventSource) {
            eventSource.remove();
          });

          calendar.addEventSource(events);
        }
      });
    }

    function stripHtml(html) {
      var tmp = document.createElement("div");
      tmp.innerHTML = html;
      return tmp.textContent || tmp.innerText || "";
    }

    visibilityFilter.on('change', function() {
      var selectedValue = $(this).val();
      fetchEvents(selectedValue);
    });

    setTimeout(() => {
      calendar.render();
    }, 500);
  });
</script>