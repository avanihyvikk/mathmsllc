<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;
use App\Models\UserModel;
use App\Models\UserShiftScheduleModel;
use App\Models\SettingModel;
use CodeIgniter\I18n\Time;
class ViewAsssiedLocationSchedule extends AdminBaseController
{
    public $title = 'View Asssied Location Schedule';
    public $menu = 'view_asssied_location_schedule';

    public function index()
    {
        $this->permissionCheck('view_asssied_location_schedule');
        return view('admin/shift_schedule/view_asssied_location_schedule_list');
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

        //$userModel = new UserModel();
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
            $userIdsarr['usrids'][] = $userIdObject->user_id;
            $userIdsarr['usrlocations'][$userIdObject->user_id] = $userIdObject->locations;
        }

        $users = $userModel->getusersById($userIdsarr['usrids']);
        $UserShift = new UserShiftScheduleModel();
        $staff = [];
        foreach ($users as $user) {

            $totalShiftHours = $UserShift->getTotalShiftHours($user->id, $_POST['refDate'], $_POST['selectedDate'],$locationIds);
            $totalShiftHours = $totalShiftHours[0]->total_shift_hours;
            $totalShiftHoursFormatted = substr($totalShiftHours, 0, 5);
            $title = !empty($totalShiftHoursFormatted) ? '<i class="fas fa-clock"></i> ' . $totalShiftHoursFormatted . ' Hrs' : '<i class="fas fa-clock"></i> 00:00 Hrs';
            // img start
            $imgType = model('App\Models\UserModel')->getRowById($user->id, 'img_type');
            $defaultImgPath = FCPATH . '/uploads/users/no_user.jpg';
            $imagePath = FCPATH . '/uploads/users/' . $user->id . '.' . $imgType;
            if (file_exists($imagePath)) {
                $imgPath = $imagePath;
            } else {
                $imgPath = $defaultImgPath;
            }
            // img end
            $staff[] = [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'color' => getRandomColor(),
                'title' => $title,
                'img' => base_url('uploads/users/' . basename($imgPath)),
            ];
        }

        if (isset($_POST['locationId']) && $_POST['locationId'] != null && is_numeric($_POST['locationId'])) {
            $location[] = $_POST['locationId'];
            $usersshifts = $UserShift->getLocationwiseUserShifts($location);
        } else {

            $usersshifts = []; // Initialize an empty array to store results

            foreach ($userIdsarr['usrlocations'] as $k => $val) {
                $usloctions = explode(',', $val);
                $usersshifts2 = $UserShift->getLocationwiseUserShifts($usloctions, $k);
                // Check if $usersshifts is not empty before adding to the array
                if (!empty($usersshifts2)) {
                    $usersshifts = array_merge($usersshifts, $usersshifts2);
                }
            }
        }
        $settingModel = new SettingModel();
        $eventtimeformat = $settingModel->where('key', 'event_time_format')->first()->value;
        $shifts = [];
        foreach ($usersshifts as $shift) {
        
            if ($eventtimeformat == '12 Hour') {

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
            ];
            $shifts[] = $shiftEntry;
        }
        echo json_encode(['success' => true, 'staff' => $staff, 'shifts' => $shifts]);
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
