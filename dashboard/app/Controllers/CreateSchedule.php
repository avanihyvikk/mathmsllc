<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;
use App\Models\UserModel;
use App\Models\UserShiftScheduleModel;
use App\Models\SettingModel;
use CodeIgniter\I18n\Time;

class CreateSchedule extends AdminBaseController
{
    public $title = 'CreateSchedule';
    public $menu = 'create_schedule';

    public function index()
    {

        $user = (new UserModel)->getById(logged('id'));
        $userModel = new UserModel();
        $assignedLocations = $userModel->getAssignedLocations($user->id);
        $locations = [];
        foreach ($assignedLocations as $location) {
            $locations[] = [
                'id' => $location->location_id,
                'name' => $location->location_name
            ];
        }
        $this->permissionCheck('create_schedule');
        $settingModel = new SettingModel();
        $weekStartOn = $settingModel->where('key', 'week_starts_on')->first()->value;
        return view('admin/shift_schedule/create_schedule_list', [
            'locations' => $locations,
            'weekStartOn' => strtolower($weekStartOn),
        ]);
    }
    public function getUserdata()
    {
        function getRandomColor()
        {
            return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }
        $user = (new UserModel)->getById(logged('id'));

        $userModel = new UserModel();
        $assignedLocations = $userModel->getAssignedLocations($user->id);

        if (isset($_POST['locationId']) && $_POST['locationId'] != null && is_numeric($_POST['locationId'])) {
            $locationIds[] = $_POST['locationId'];
            foreach ($assignedLocations as $assignedLocation) {
                $locationI_ids[] = $assignedLocation->location_id;
            }
            if (in_array($_POST['locationId'], $locationI_ids)) {

                $userIds = $userModel->getUsersfromLocationids($locationIds);
            } else {
                echo json_encode(['success' => false, 'message' => '404']);
                return;
            }
        } else {
            $locationIds = [];
            foreach ($assignedLocations as $assignedLocation) {
                $locationIds[] = $assignedLocation->location_id;
            }
            $userIds = $userModel->getUsersfromLocationids($locationIds);
        }

        $userIdsarr = array();
        foreach ($userIds as $userIdObject) {
            $userIdsarr[] = $userIdObject->user_id;
        }
        $users = $userModel->getusersById($userIdsarr);
        $UserShift = new UserShiftScheduleModel();
        $staff = [];
        foreach ($users as $user) {
            
            $totalShiftHours = $UserShift->getTotalShiftHours($user->id, $_POST['refDate'], $_POST['selectedDate']);
            $totalShiftHours = $totalShiftHours[0]->total_shift_hours;
            $totalShiftHoursFormatted = substr($totalShiftHours, 0, 5);
            $title = !empty($totalShiftHoursFormatted) ? $totalShiftHoursFormatted.' Hrs' : '';

            $staff[] = [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'color' => getRandomColor(),
                'title' => $title,
                'img' => '',
            ];
        }
        
        if (isset($_POST['locationId']) && $_POST['locationId'] != null && is_numeric($_POST['locationId'])) {
            $location[] = $_POST['locationId'];
            $usersshifts = $UserShift->getLocationwiseUserShifts($location);
        } else {
            $usersshifts = $UserShift->getLocationwiseUserShifts($locationIds);
        }
        $settingModel = new SettingModel();
        $event_time_format = $settingModel->where('key', 'event_time_format')->first()->value;

        $shifts = [];
        foreach ($usersshifts as $shift) {
            if ($event_time_format == '12 Hour') {

                $startDatetimeString = $shift->date . ' ' . $shift->start_time;
                $startDatetime = Time::createFromFormat('Y-m-d H:i:s', $startDatetimeString);
                $endDatetimeString = $shift->date . ' ' . $shift->end_time;
                $endDatetime = Time::createFromFormat('Y-m-d H:i:s', $endDatetimeString);
                $timezone = date_default_timezone_get();
                $startDatetime->setTimezone($timezone);
                $endDatetime->setTimezone($timezone);
                $startDatetime = $startDatetime->format('Y-m-d\TH:i:s');
                $endDatetime = $endDatetime->format('Y-m-d\TH:i:s');
                
                $title = date('h:i A', strtotime($shift->start_time)) . ' - ' . date('h:i A', strtotime($shift->end_time)) . '<br>' . $shift->location_name;
            } else {
                
                $startTime = date('H:i', strtotime($shift->start_time));
                $endTime = date('H:i', strtotime($shift->end_time));
                $startDatetimeString = $shift->date . ' ' . $startTime;
                $endDatetimeString = $shift->date . ' ' . $endTime;
                $startDatetime = Time::createFromFormat('Y-m-d H:i', $startDatetimeString);
                $endDatetime = Time::createFromFormat('Y-m-d H:i', $endDatetimeString);
                $timezone = date_default_timezone_get();
                $startDatetime->setTimezone($timezone);
                $endDatetime->setTimezone($timezone);
                $startDatetime = $startDatetime->format('Y-m-d\TH:i:s');
                $endDatetime = $endDatetime->format('Y-m-d\TH:i:s');

                $title = $startTime . ' - ' . $endTime . '<br>' . $shift->location_name;
            }
            $shiftEntry = [
                'id' => $shift->id,
                'start' => $startDatetime,
                'end' => $endDatetime,
                'title' => $title,
                'resource' => $shift->userid,
                'location2' => $shift->location,
                'start2' => $shift->start_time,
                'end2' => $shift->end_time,
                'date2' => $shift->date,
            ];
            $shifts[] = $shiftEntry;
        }
        echo json_encode(['success' => true, 'staff' => $staff, 'shifts' => $shifts, 'event_time_format' => $event_time_format]);
    }
    public function saveEvent()
    {
        $eventData = $_POST;

        $startTime = $eventData['start2'];
        $endTime = $eventData['end2'];
        $date = $eventData['date2'];
        $location = isset($eventData['location2']) ? $eventData['location2'] : null;
        $resource = isset($eventData['resource']) ? $eventData['resource'] : null;

        if ($location === null) {
            echo json_encode(['success' => false, 'message' => 'Please select a location. Kindly wait for a few moments after selecting a location before proceeding.']);
            return;
        }

        $user = (new UserModel)->getById(logged('id'));

        $shiftData = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'date' => $date,
            'location' => $location,
            'userid' => $resource,
            'assign_userid' => $user->id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $UserShift = new UserShiftScheduleModel();
        $availableShifts = $UserShift->chkshiftavailable(
            $shiftData['userid'],
            $shiftData['start_time'],
            $shiftData['end_time'],
            $shiftData['date']
        );
        if (empty($availableShifts)) {
            $userShiftModel = new UserShiftScheduleModel();
            $inserted = $userShiftModel->insert($shiftData);
            if ($inserted) {
                $lastInsertId = $userShiftModel->insertID();
                echo json_encode(['success' => true, 'lastid' => $lastInsertId]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save shift data']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Shift not available for the same time']);
        }
    }
    public function updateEvent()
    {
        $eventData = $_POST;

        $startTime = $eventData['start2'];
        $endTime = $eventData['end2'];
        $date = $eventData['date2'];
        $location = isset($eventData['location2']) ? $eventData['location2'] : null;
        $eventModel = new UserShiftScheduleModel();
        $updateData = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'location' => $location,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $availableShifts = $eventModel->chkshiftavailable(
            $eventData['resource'],
            $updateData['start_time'],
            $updateData['end_time'],
            $date,
            $eventData['id']
        );
        if (empty($availableShifts)) {
            $eventId = $eventData['id'];
            $updated = $eventModel->update($eventId, $updateData);
            if ($updated) {
                echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update event']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Shift not available for the same time']);
        }
    }
    public function deleteEvent()
    {
        $eventId = $_POST['id'];
        if ($eventId) {
            $userShiftModel = new UserShiftScheduleModel();
            $deleted = $userShiftModel->delete($eventId);
            if ($deleted) {
                echo json_encode(['success' => true, 'message' => 'Event deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete event']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid event ID']);
        }
    }

    public function getUserLocations()
    {
        $usrId = $_POST['userId'];
        $eventId = isset($_POST['eventId']) ? $_POST['eventId'] : null;
        $userModel = new UserModel();
        $assignedLocations = $userModel->getAssignedLocations($usrId);
        $locations = [];
        foreach ($assignedLocations as $location) {
            $locations[] = [
                'id' => $location->location_id,
                'name' => $location->location_name
            ];
        }
        $location2 = null;
        if ($eventId !== null) {
            $location2 = $this->getShiftLocation($eventId);
        }
        echo json_encode(['success' => true, 'locations' => $locations, 'selectedlocationId' => $location2]);
    }

    public function getShiftLocation($eventId)
    {
        $userShiftModel = new UserShiftScheduleModel();
        $location2 = $userShiftModel->getShiftLocationById($eventId);
        return $location2;
    }
}
