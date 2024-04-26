<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?php echo assets_url('admin') ?>/css/mobiscroll.jquery.min.css">
<style>
    .employee-shifts-day {
        font-size: 14px;
        font-weight: 600;
        opacity: .6;
    }

    .employee-shifts-popup .mbsc-popup .mbsc-popup-header {
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .employee-shifts-cont {
        position: relative;
        padding-left: 42px;
        max-height: 40px;
    }

    .employee-shifts-avatar {
        position: absolute;
        max-height: 40px;
        max-width: 40px;
        top: 18px;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        left: 20px;
    }

    .employee-shifts-name {
        font-size: 15px;
    }

    .employee-shifts-title {
        font-size: 12px;
    }

    .md-employee-shifts .mbsc-timeline-resource,
    .md-employee-shifts .mbsc-timeline-resource-col {
        width: 200px;
        align-items: center;
        display: flex;
    }

    .md-employee-shifts .mbsc-schedule-event {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 36px;
    }

    /* custom css */
    #location-dropdown2 {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: 0px;
        outline: 0px;
        outline: none;
        border: none;
        margin: 10px;
        width: 90%;

    }

    .mbsc-ios.mbsc-form-control-wrapper:after,
    .mbsc-ios.mbsc-form-control-wrapper:before {
        border: unset;
        border-color: #fff;
    }

    .mbsc-ios.mbsc-textfield-wrapper-underline {
        border-bottom: 1px solid #ccc;
        z-index: 5;
        border-top: 1px solid #ccc;
    }

    .mbsc-timeline.mbsc-ltr .mbsc-schedule-event-inner,
    .md-employee-shifts .mbsc-schedule-event {
        height: max-content;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.schedule') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"><a><?php echo lang('App.schedule') ?></a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->

<section class="content">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-12">
            <select class="form-control" id="location" name="location" required>
                <?php if (count($locations) === 1) : ?>
                    <?php $location = reset($locations); ?>
                    <option value="<?= $location['id'] ?>" selected><?= $location['name'] ?></option>
                <?php else : ?>
                    <option value="all">All Locations</option>
                    <?php foreach ($locations as $location) : ?>
                        <?php
                        // Check if locationId is set in the URL
                        $locationIdFromUrl = isset($_GET['locationId']) ? $_GET['locationId'] : null;
                        ?>
                        <option value="<?= $location['id'] ?>" <?= ($location['id'] == $locationIdFromUrl) ? 'selected' : '' ?>>
                            <?= $location['name'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <!-- Default card -->
            <div class="card">

                <div class="card-body">

                    <div id="demo-employee-shifts-calendar" class="md-employee-shifts"></div>

                    <div id="demo-employee-shifts-popup" class="employee-shifts-popup" style="display: none;">
                        <div class="mbsc-form-group">
                            <label for="employee-shifts-start">
                                Shift start
                                <input mbsc-input data-dropdown="true" id="employee-shifts-start" />
                            </label>
                            <label for="employee-shifts-end">
                                Shift end
                                <input mbsc-input data-dropdown="true" id="employee-shifts-end" />
                            </label>
                            <label for="location-dropdown2" class=" mbsc-ios mbsc-ltr mbsc-form-control-wrapper mbsc-textfield-wrapper mbsc-font mbsc-textfield-wrapper-underline mbsc-textfield-wrapper-inline"><span class=" mbsc-ios mbsc-ltr mbsc-label mbsc-label-inline mbsc-label-underline-inline">
                                    Location
                                </span><span class="mbsc-ios mbsc-ltr mbsc-textfield-inner mbsc-textfield-inner-underline mbsc-textfield-inner-inline"><select id="location-dropdown2"></select><span class="mbsc-select-icon mbsc-select-icon-underline mbsc-ltr mbsc-ios mbsc-select-icon-inline mbsc-icon mbsc-ios"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M256 294.1L383 167c9.4-9.4 24.6-9.4 33.9 0s9.3 24.6 0 34L273 345c-9.1 9.1-23.7 9.3-33.1.7L95 201.1c-4.7-4.7-7-10.9-7-17s2.3-12.3 7-17c9.4-9.4 24.6-9.4 33.9 0l127.1 127z"></path>
                                        </svg></span></span></label>
                            <div id="demo-employee-shifts-date"></div>
                        </div>

                        <!-- <div class="mbsc-form-group">
                            <label for="location-dropdown2" style="padding-left: 1em;">Location</label>
                            <select id="location-dropdown2"></select>
                        </div> -->

                        <div class="mbsc-button-group">
                            <button class="mbsc-button-block" id="employee-shifts-delete" mbsc-button data-color="danger" data-variant="outline">Delete shift</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('js') ?>

<script src="<?php echo assets_url('admin') ?>/js/mobiscroll.jquery.min.js"></script>
<script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    var locationSelect = document.getElementById('location');

    locationSelect.addEventListener('change', function() {
        var selectedLocationId = this.value;
        //if (selectedLocationId !== "") {
        // Construct the new URL with the selected location ID
        var url = window.location.href.split('?')[0] + '?locationId=' + selectedLocationId;

        // Redirect to the new URL
        window.location.href = url;
        // }
    });
    $(function() {
        // Extract locationId from the URL
        var urlParams = new URLSearchParams(window.location.search);
        var locationId = urlParams.get('locationId');

        // date logic start
        var weekStartOn = '<?php echo $weekStartOn; ?>';
        var today = new Date();
        var dayOfWeekMapping = {
            'sunday': 0,
            'monday': 1,
            'tuesday': 2,
            'wednesday': 3,
            'thursday': 4,
            'friday': 5,
            'saturday': 6
        };
        var defaultTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        var timeZone = defaultTimezone;
        var weekStartDay = dayOfWeekMapping[weekStartOn.toLowerCase()];
        var startOfWeek = new Date(today);
        startOfWeek.setDate(today.getDate() - (today.getDay() - weekStartDay + 7) % 7);
        var endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(startOfWeek.getDate() + 6);
        var options = {
            timeZone: timeZone,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var refDate = startOfWeek.toLocaleString('en-US', options).split(',')[0];
        var selectedDate = endOfWeek.toLocaleString('en-US', options).split(',')[0];
        // date logic end

        // AJAX request with locationId included in the data
        $.ajax({
            url: '<?php echo base_url('CreateSchedule/getUserdata'); ?>',
            method: 'POST',
            data: {
                locationId: locationId,
                refDate: refDate,
                selectedDate: selectedDate
            },
            success: function(response) {
                var responseData = JSON.parse(response);

                if (responseData.success) {
                    if (Array.isArray(responseData.staff)) {
                        initializeMobiscroll(responseData.staff, responseData.shifts, responseData.event_time_format);
                    }
                } else {
                    var deniedUrl = '<?php echo base_url('errors/denied'); ?>';
                    window.location.href = deniedUrl;
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch staff data:', error);
            }
        });

        // Initialize Mobiscroll function with staff data
        function initializeMobiscroll(staff, shifts, event_time_format) {

            // Set Mobiscroll options

            var resources = staff.map(function(employee) {
                return {
                    id: employee.id,
                    name: employee.name,
                    color: employee.color,
                };
            });
            mobiscroll.setOptions({
                theme: 'ios',
                themeVariant: 'light'
            });
            var calendar;
            var popup;
            var range;
            var oldShift;
            var tempShift;
            var deleteShift;
            var restoreShift;
            var formatDate = mobiscroll.formatDate;
            var $location2 = $('#location-dropdown2');
            var $deleteButton = $('#employee-shifts-delete');
            var shifts = shifts;
            var invalid = [];

            function createAddPopup() {
                // hide delete button inside add popup
                $deleteButton.hide();
                deleteShift = true;
                restoreShift = false;

                // set popup header text and buttons for adding
                popup.setOptions({
                    headerText: '<div>New shift</div>',
                    buttons: [
                        'cancel',
                        {
                            text: 'Add',
                            keyCode: 'enter',
                            handler: function() {
                                var date = range.getVal();
                                $.ajax({
                                    url: '<?php echo base_url('CreateSchedule/saveEvent'); ?>',
                                    method: 'POST',
                                    data: tempShift,
                                    success: function(response) {
                                        var responseData = JSON.parse(response);
                                        if (responseData && responseData.success === false) {
                                            alert(responseData.message);
                                            calendar.removeEvent(tempShift);

                                        } else {
                                            console.log(response)
                                            var lastId = responseData.lastid;
                                            tempShift.id = lastId;
                                            var locationText = $('#location-dropdown2 option:selected').text();
                                            if (event_time_format == '12 Hour') {
                                                var title = formatDate('hh:mm A', date[0]) + ' - ' + formatDate('hh:mm A', date[1] ? date[1] : date[0]) + ' <br> ' + locationText;
                                            } else {
                                                var title = formatDate('HH:mm', date[0]) + ' - ' + formatDate('HH:mm', date[1] ? date[1] : date[0]) + ' <br> ' + locationText;
                                            }
                                            tempShift.title = title;
                                            calendar.updateEvent(tempShift);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        //console.error('Failed to save event:', error);
                                    }
                                });
                                deleteShift = false;
                                popup.close();
                            },
                            cssClass: 'mbsc-popup-button-primary',
                        },
                    ],
                });

                // fill popup with a new event data
                range.setVal([tempShift.start, tempShift.end]);
                popup.open();
            }

            function createEditPopup(args) {
                var ev = args.event;
                var resource = staff.find(function(r) {
                    return r.id == ev.resource;
                });

                // show delete button inside edit popup
                $deleteButton.show();

                deleteShift = false;
                restoreShift = true;
                //console.log('createEditPopup');

                $.ajax({
                    url: '<?php echo base_url('CreateSchedule/getUserLocations'); ?>',
                    method: 'POST',
                    data: {
                        eventId: ev.id,
                        userId: ev.resource
                    },
                    success: function(response) {
                        var responseData = JSON.parse(response);

                        populateLocation2Dropdown(responseData.locations);


                        $location2.val(ev.location2);


                        if (responseData.locations.length > 0) {
                            $location2.val(responseData.selectedlocationId[0].location);
                        }
                    },
                    error: function(xhr, status, error) {
                        // console.error('Failed to fetch user locations:', error);
                    }
                });
                // set popup header text and buttons for editing
                popup.setOptions({
                    headerText: '<div>Edit ' + resource.name + '\'s hours</div>',
                    buttons: [
                        'cancel',
                        {
                            text: 'Save',
                            keyCode: 'enter',
                            handler: function() {
                                var date = range.getVal();
                                // update event with the new properties on save button click
                                if (event_time_format == '12 Hour') {
                                    var title = formatDate('hh:mm A', date[0]) + ' - ' + formatDate('hh:mm A', date[1] ? date[1] : date[0]) + ' <br> ' + $('#location-dropdown2 option:selected').text();
                                } else {
                                    var title = formatDate('HH:mm', date[0]) + ' - ' + formatDate('HH:mm', date[1] ? date[1] : date[0]) + ' <br> ' + $('#location-dropdown2 option:selected').text();
                                }
                                calendar.updateEvent({
                                    id: ev.id,
                                    title: title,
                                    location2: $location2.val(),
                                    start: date[0],
                                    end: date[1] ? date[1] : date[0],
                                    resource: resource.id,
                                    color: resource.color,
                                    start2: formatDate('HH:mm', date[0]), // Format the start time as required
                                    end2: formatDate('HH:mm', date[1] ? date[1] : date[0]), // Format the end time as required
                                    date2: formatDate('YYYY-MM-DD', date[0]) // Format the date as required
                                });
                                // Make an AJAX call to update the event
                                $.ajax({
                                    url: '<?php echo base_url('CreateSchedule/updateEvent'); ?>',
                                    method: 'POST',
                                    data: ev,
                                    success: function(response) {
                                        console.log(response)
                                        var responseData = JSON.parse(response);
                                        if (responseData && responseData.success === false) {
                                            alert(responseData.message);
                                            calendar.updateEvent(oldShift);

                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Failed to update event:', error);
                                    }
                                });

                                restoreShift = false;
                                popup.close();
                            },
                            cssClass: 'mbsc-popup-button-primary',
                        },
                    ],
                });


                $location2.val(ev.location2);
                range.setVal([ev.start, ev.end]);
                popup.open();
            }
            var calendar = $('#demo-employee-shifts-calendar')
                .mobiscroll()
                .eventcalendar({
                    view: {
                        timeline: {
                            type: 'day',
                            size: 7,
                            resolutionHorizontal: 'day',
                            eventList: true,
                        }
                    },
                    refDate: refDate,
                    selectedDate: selectedDate,
                    data: shifts,
                    dragToCreate: false,
                    dragToResize: false,
                    dragToMove: false,
                    clickToCreate: true,
                    resources: staff,
                    invalid: invalid,
                    extendDefaultEvent: function(ev) {

                        var d = ev.start;
                        var start = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 7);
                        var end = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 13);
                        var defaultLocationId = staff.length > 0 ? staff[0].id : null;
                        if (event_time_format == '12 Hour') {
                            var title = formatDate('hh:mm A', start) + ' - ' + formatDate('hh:mm A', end);
                        } else {
                            var title = formatDate('HH:mm', start) + ' - ' + formatDate('HH:mm', end);
                        }
                        $.ajax({
                            url: '<?php echo base_url('CreateSchedule/getUserLocations'); ?>',
                            method: 'POST',
                            data: {
                                userId: ev.resource
                            },
                            success: function(response) {
                                var responseData = JSON.parse(response);
                                populateLocation2Dropdown(responseData.locations);
                                ev.location2 = responseData.locations.length > 0 ? responseData.locations[0].id : null;
                            },
                            error: function(xhr, status, error) {
                                console.error('Failed to fetch user locations:', error);
                            }
                        });
                        return {
                            title: title,
                            start: start,
                            end: end,
                            resource: ev.resource,
                            location2: ev.location2,
                            start2: formatDate('HH:mm', start),
                            end2: formatDate('HH:mm', end),
                            date2: start.getFullYear() + '-' + ('0' + (start.getMonth() + 1)).slice(-2) + '-' + ('0' + start.getDate()).slice(-2)
                        };
                    },

                    onEventCreate: function(args) {

                        //console.log('onEventCreate');
                        // Store temporary event
                        tempShift = args.event;
                        $.ajax({
                            url: '<?php echo base_url('CreateSchedule/getUserLocations'); ?>',
                            method: 'POST',
                            data: {
                                userId: tempShift.resource
                            },
                            success: function(response) {
                                var responseData = JSON.parse(response);
                                tempShift.location2 = responseData.locations.length > 0 ? responseData.locations[0].id : null;
                            },
                            error: function(xhr, status, error) {
                                console.error('Failed to fetch user locations:', error);
                            }
                        });
                        setTimeout(function() {
                            createAddPopup(args);
                        }, 100);
                    },
                    onEventClick: function(args) {
                        oldShift = $.extend({}, args.event);
                        tempShift = args.event;
                        if (!popup.isVisible()) {
                            createEditPopup(args);
                        }
                    },
                    renderResource: function(resource) {
                        return (
                            '<div class="employee-shifts-cont">' +
                            '<div class="employee-shifts-name">' +
                            resource.name +
                            '</div>' +
                            '<div class="employee-shifts-title">' +
                            resource.title +
                            '</div>' +
                            '<img class="employee-shifts-avatar" src="' +
                            resource.img +
                            '"/>' +
                            '</div>'
                        );
                    },
                })
                .mobiscroll('getInst');

            popup = $('#demo-employee-shifts-popup')
                .mobiscroll()
                .popup({
                    display: 'bottom',
                    contentPadding: false,
                    fullScreen: true,
                    onClose: function() {
                        if (deleteShift) {
                            calendar.removeEvent(tempShift);
                        } else if (restoreShift) {
                            calendar.updateEvent(oldShift);
                        }
                    },
                    responsive: {
                        medium: {
                            display: 'center',
                            width: 400,
                            fullScreen: false,
                            touchUi: false,
                            showOverlay: false,
                        },
                    },
                })
                .mobiscroll('getInst');

            range = $('#demo-employee-shifts-date')
                .mobiscroll()
                .datepicker({
                    controls: ['time'],
                    select: 'range',
                    display: 'anchored',
                    showRangeLabels: false,
                    touchUi: false,
                    startInput: '#employee-shifts-start',
                    endInput: '#employee-shifts-end',
                    stepMinute: 30,
                    timeWheels: '|h:mm A|',
                    onChange: function(args) {
                        var date = args.value;

                        // update shift's start/end date
                        tempShift.start = date[0];
                        tempShift.end = date[1] ? date[1] : date[0];


                        var startTime = ('0' + tempShift.start.getHours()).slice(-2) + ':' + ('0' + tempShift.start.getMinutes()).slice(-2) + ':' + ('0' + tempShift.start.getSeconds()).slice(-2);

                        // Extract end time
                        var endTime = ('0' + tempShift.end.getHours()).slice(-2) + ':' + ('0' + tempShift.end.getMinutes()).slice(-2) + ':' + ('0' + tempShift.end.getSeconds()).slice(-2);

                        var startDate = tempShift.start.getFullYear() + '-' + ('0' + (tempShift.start.getMonth() + 1)).slice(-2) + '-' + ('0' + tempShift.start.getDate()).slice(-2);

                        tempShift.start2 = startTime;
                        tempShift.end2 = endTime;
                        tempShift.date2 = startDate;

                        if (event_time_format == '12 Hour') {
                            var title = formatDate('hh:mm A', date[0]) + ' - ' + formatDate('hh:mm A', date[1] ? date[1] : date[0]);
                        } else {
                            var title = formatDate('HH:mm', date[0]) + ' - ' + formatDate('HH:mm', date[1] ? date[1] : date[0]);
                        }
                        tempShift.title = title;
                        //console.log(tempShift)
                    },
                })
                .mobiscroll('getInst');
            $location2.on('change', function(ev) {
                // update current event's title
                tempShift.location2 = ev.target.value;
            });
            $deleteButton.on('click', function() {
                // Save a local reference to the deleted event
                var deletedShift = tempShift;

                // Close the popup
                popup.close();

                // Send an AJAX request to delete the event
                $.ajax({
                    url: '<?php echo base_url('CreateSchedule/deleteEvent'); ?>',
                    method: 'POST',
                    data: {
                        id: deletedShift.id
                    }, // Assuming id is used to identify the event to be deleted
                    success: function(response) {

                        var responseData = JSON.parse(response);

                        if (responseData.success) {
                            // Remove the event from the calendar
                            calendar.removeEvent(deletedShift);

                            // Show a snackbar with an option to undo the deletion
                            mobiscroll.snackbar({
                                button: {
                                    action: function() {
                                        // Add the event back to the calendar
                                        calendar.addEvent(deletedShift);
                                    },
                                    text: 'Undo',
                                },
                                message: 'Shift deleted',
                            });
                        } else {
                            alert(responseData.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to delete event:', error);
                    }
                });
            });

            function populateLocation2Dropdown(locations) {
                var options = '';
                locations.forEach(function(location) {
                    options += '<option value="' + location.id + '">' + location.name + '</option>';
                });
                $location2.html(options);
            }
        }
    });
</script>

<?= $this->endSection() ?>