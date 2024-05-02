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
        /* max-height: 40px; */
    }

    .employee-shifts-avatar {
        position: absolute;
        max-height: 40px;
        max-width: 40px;
        top: 25px;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        left: 20px;
        border-radius: 50%;
    }

    .employee-shifts-name {
        font-size: 15px;
    }

    .employee-shifts-title {
        font-size: 12px;
        color: #007aff;
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
        opacity: 1;

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

    .mbsc-ios.mbsc-textfield-inner.mbsc-disabled,
    .mbsc-ios.mbsc-label.mbsc-disabled {
        opacity: 1;
    }

    /* support css */
    /* update the default min-width */
    .md-employee-shifts .mbsc-timeline-column,
    .md-employee-shifts .mbsc-timeline-day,
    .md-employee-shifts .mbsc-timeline-header-column {
        min-width: 10em;
    }

    /* update the default event height and font size */
    .md-employee-shifts .mbsc-schedule-event {
        height: 40px;
        font-size: 14px;
    }

    .md-employee-shifts .mbsc-schedule-event-inner {
        height: 100%;
    }

    .md-employee-shifts .mbsc-schedule-event-title {
        white-space: initial;
    }

    /* support css end*/

    /* ass css */
    #location-dropdown {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: 0px;
        outline: 0px;
        outline: none;
        border: none;
        margin: 10px;
        width: 90%;
        opacity: 1;
    }
</style>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo lang('App.view_own_schedule') ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"><a><?php echo lang('App.view_own_schedule') ?></a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
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
    <?php if ($view_own_schedule_permission && !($view_own_schedule_permission && $view_asssied_location_schedule_permission)) : ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="col-md-12 calendertitlemain">
                            <h5><?php echo lang('App.view_own_schedule') ?></h5>
                        </div> -->
                        <div id="demo-employee-shifts-calendar" class="md-employee-shifts"></div>

                        <div id="demo-employee-shifts-popup" class="employee-shifts-popup" style="display: none;">
                            <div class="mbsc-form-group">
                                <label for="employee-shifts-start">
                                    Shift start
                                    <input mbsc-input data-dropdown="true" id="employee-shifts-start" disabled />
                                </label>
                                <label for="employee-shifts-end">
                                    Shift end
                                    <input mbsc-input data-dropdown="true" id="employee-shifts-end" disabled />
                                </label>

                                <label for="location-dropdown2" class=" mbsc-ios mbsc-ltr mbsc-form-control-wrapper mbsc-textfield-wrapper mbsc-font mbsc-textfield-wrapper-underline mbsc-textfield-wrapper-inline"><span class=" mbsc-ios mbsc-ltr mbsc-label mbsc-label-inline mbsc-label-underline-inline">
                                        Location
                                    </span><span class="mbsc-ios mbsc-ltr mbsc-textfield-inner mbsc-textfield-inner-underline mbsc-textfield-inner-inline"><select id="location-dropdown2" disabled></select><span class="mbsc-select-icon mbsc-select-icon-underline mbsc-ltr mbsc-ios mbsc-select-icon-inline mbsc-icon mbsc-ios"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 294.1L383 167c9.4-9.4 24.6-9.4 33.9 0s9.3 24.6 0 34L273 345c-9.1 9.1-23.7 9.3-33.1.7L95 201.1c-4.7-4.7-7-10.9-7-17s2.3-12.3 7-17c9.4-9.4 24.6-9.4 33.9 0l127.1 127z"></path>
                                            </svg></span></span></label>
                                <div id="demo-employee-shifts-date"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- assigned location calander  -->
    <?php if ($view_asssied_location_schedule_permission || ($view_own_schedule_permission && $view_asssied_location_schedule_permission)) : ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="col-md-12 calendertitlemain">
                            <h5><?php echo lang('App.view_own_schedule') ?></h5>
                        </div> -->
                        <div id="demo-employee-shifts-calendar2" class="md-employee-shifts"></div>

                        <div id="demo-employee-shifts-popup2" class="employee-shifts-popup" style="display: none;">
                            <div class="mbsc-form-group">
                                <label for="employee-shifts-start">
                                    Shift start
                                    <input mbsc-input data-dropdown="true" id="employee-shifts-start2" disabled />
                                </label>
                                <label for="employee-shifts-end">
                                    Shift end
                                    <input mbsc-input data-dropdown="true" id="employee-shifts-end2" disabled />
                                </label>

                                <label for="location-dropdown" class=" mbsc-ios mbsc-ltr mbsc-form-control-wrapper mbsc-textfield-wrapper mbsc-font mbsc-textfield-wrapper-underline mbsc-textfield-wrapper-inline"><span class=" mbsc-ios mbsc-ltr mbsc-label mbsc-label-inline mbsc-label-underline-inline">
                                        Location
                                    </span><span class="mbsc-ios mbsc-ltr mbsc-textfield-inner mbsc-textfield-inner-underline mbsc-textfield-inner-inline"><select id="location-dropdown" disabled></select><span class="mbsc-select-icon mbsc-select-icon-underline mbsc-ltr mbsc-ios mbsc-select-icon-inline mbsc-icon mbsc-ios"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 294.1L383 167c9.4-9.4 24.6-9.4 33.9 0s9.3 24.6 0 34L273 345c-9.1 9.1-23.7 9.3-33.1.7L95 201.1c-4.7-4.7-7-10.9-7-17s2.3-12.3 7-17c9.4-9.4 24.6-9.4 33.9 0l127.1 127z"></path>
                                            </svg></span></span></label>
                                <div id="demo-employee-shifts-date2"></div>
                            </div>
                        </div>
                        <!-- assigned location calender end -->
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</section>
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

    <?php if ($view_own_schedule_permission && !($view_own_schedule_permission && $view_asssied_location_schedule_permission)) : ?>
        $(function() {

            // Extract locationId from the URL
            var urlParams = new URLSearchParams(window.location.search);
            var locationId = urlParams.get('locationId');

            // AJAX request with locationId included in the data
            $.ajax({
                url: '<?php echo base_url('ViewOwnSchedule/getUserdata'); ?>',
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
                            initializeMobiscroll(responseData.staff, responseData.shifts);
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


            function initializeMobiscroll(staff, shifts) {
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

                function createEditPopup(args) {
                    var ev = args.event;
                    var resource = staff.find(function(r) {
                        return r.id == ev.resource;
                    });
                    $deleteButton.show();
                    deleteShift = false;
                    restoreShift = true;
                    //console.log('createEditPopup');
                    $.ajax({
                        url: '<?php echo base_url('ViewOwnSchedule/getUserLocations'); ?>',
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
                    popup.setOptions({
                        headerText: '<div>View ' + resource.name + '\'s hours</div>',
                        buttons: [
                            'cancel',
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
                        todayText: 'Week',
                        refDate: refDate,
                        selectedDate: selectedDate,
                        data: shifts,
                        dragToCreate: false,
                        dragToResize: false,
                        dragToMove: false,
                        clickToCreate: false,
                        resources: staff,
                        invalid: invalid,
                        extendDefaultEvent: function(ev) {
                            var d = ev.start;
                            var start = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 7);
                            var end = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 13);
                            var defaultLocationId = staff.length > 0 ? staff[0].id : null;
                            //console.log('extendDefaultEvent');
                            $.ajax({
                                url: '<?php echo base_url('ViewOwnSchedule/getUserLocations'); ?>',
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
                                title: formatDate('HH:mm', start) + ' - ' + formatDate('HH:mm', end),
                                start: start,
                                end: end,
                                resource: ev.resource,
                                location2: ev.location2
                            };
                        },
                        onEventCreate: function(args) {},
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
                            tempShift.start = date[0];
                            tempShift.end = date[1] ? date[1] : date[0];
                            tempShift.title = formatDate('HH:mm', date[0]) + ' - ' + formatDate('HH:mm', date[1] ? date[1] : date[0]);
                        },
                    })
                    .mobiscroll('getInst');
                $location2.on('change', function(ev) {
                    tempShift.location2 = ev.target.value;
                });
                $deleteButton.on('click', function() {
                    var deletedShift = tempShift;
                    popup.close();
                });

                function populateLocation2Dropdown(locations) {
                    var $locationDropdown2 = $('#location-dropdown2');
                    $locationDropdown2.empty();
                    locations.forEach(function(location) {
                        $locationDropdown2.append('<option value="' + location.id + '">' + location.name + '</option>');
                    });
                }
            }
        });
    <?php endif; ?>

    // ass cal js start
    <?php if ($view_asssied_location_schedule_permission || ($view_own_schedule_permission && $view_asssied_location_schedule_permission)) : ?>
        $(function() {
            // Extract locationId from the URL
            var urlParams = new URLSearchParams(window.location.search);
            var locationId = urlParams.get('locationId');

            // AJAX request with locationId included in the data
            $.ajax({
                url: '<?php echo base_url('ViewAsssiedLocationSchedule/getUserdata'); ?>',
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
                            initializeMobiscroll(responseData.staff, responseData.shifts);
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

            function initializeMobiscroll(staff, shifts) {
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
                var $location2 = $('#location-dropdown');
                var $deleteButton = $('#employee-shifts-delete');
                var shifts = shifts;
                var invalid = [];

                function createEditPopup(args) {
                    var ev = args.event;
                    var resource = staff.find(function(r) {
                        return r.id == ev.resource;
                    });
                    $deleteButton.show();
                    deleteShift = false;
                    restoreShift = true;
                    //console.log('createEditPopup');
                    $.ajax({
                        url: '<?php echo base_url('ViewAsssiedLocationSchedule/getUserLocations'); ?>',
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
                    popup.setOptions({
                        headerText: '<div>View ' + resource.name + '\'s hours</div>',
                        buttons: [
                            'cancel',
                        ],
                    });
                    $location2.val(ev.location2);
                    range.setVal([ev.start, ev.end]);
                    popup.open();
                }
                var calendar = $('#demo-employee-shifts-calendar2')
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
                        todayText: 'Week',
                        refDate: refDate,
                        selectedDate: selectedDate,
                        data: shifts,
                        dragToCreate: false,
                        dragToResize: false,
                        dragToMove: false,
                        clickToCreate: false,
                        resources: staff,
                        invalid: invalid,
                        extendDefaultEvent: function(ev) {
                            var d = ev.start;
                            var start = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 7);
                            var end = new Date(d.getFullYear(), d.getMonth(), d.getDate(), 13);
                            var defaultLocationId = staff.length > 0 ? staff[0].id : null;
                            //console.log('extendDefaultEvent');
                            $.ajax({
                                url: '<?php echo base_url('ViewAsssiedLocationSchedule/getUserLocations'); ?>',
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
                                title: formatDate('HH:mm', start) + ' - ' + formatDate('HH:mm', end),
                                start: start,
                                end: end,
                                resource: ev.resource,
                                location2: ev.location2
                            };
                        },
                        onEventCreate: function(args) {},
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

                popup = $('#demo-employee-shifts-popup2')
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

                range = $('#demo-employee-shifts-date2')
                    .mobiscroll()
                    .datepicker({
                        controls: ['time'],
                        select: 'range',
                        display: 'anchored',
                        showRangeLabels: false,
                        touchUi: false,
                        startInput: '#employee-shifts-start2',
                        endInput: '#employee-shifts-end2',
                        stepMinute: 30,
                        timeWheels: '|h:mm A|',
                        onChange: function(args) {
                            var date = args.value;
                            tempShift.start = date[0];
                            tempShift.end = date[1] ? date[1] : date[0];
                            tempShift.title = formatDate('HH:mm', date[0]) + ' - ' + formatDate('HH:mm', date[1] ? date[1] : date[0]);
                        },
                    })
                    .mobiscroll('getInst');
                $location2.on('change', function(ev) {
                    tempShift.location2 = ev.target.value;
                });
                $deleteButton.on('click', function() {
                    var deletedShift = tempShift;
                    popup.close();
                });

                function populateLocation2Dropdown(locations) {
                    var $locationDropdown2 = $('#location-dropdown');
                    $locationDropdown2.empty();
                    locations.forEach(function(location) {
                        $locationDropdown2.append('<option value="' + location.id + '">' + location.name + '</option>');
                    });
                }
            }
        });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>