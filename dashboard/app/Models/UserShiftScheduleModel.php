<?php

namespace App\Models;

use App\Models\BaseModel;

class UserShiftScheduleModel extends BaseModel
{
    protected $table      = 'user_shift_schedule';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $allowedFields = ['userid', 'location', 'assign_userid', 'start_time', 'end_time', 'date', 'note'];
    public function getAllShiftSchedule()
    {
        return $this->findAll();
    }
    public function getShiftLocationById($eventId)
    {
        return $this->db->table('user_shift_schedule')
            ->select('location')
            ->where('id', $eventId)
            ->get()
            ->getResult();
    }

    public function getLocationwiseUserShifts($locationIds = null, $userId = null)
    {
        $this->join('location', 'location.location_id = user_shift_schedule.location');

        if ($locationIds) {
            if ($userId !== null) {
                return $this->whereIn('user_shift_schedule.location', $locationIds)
                    ->where('user_shift_schedule.userid', $userId)
                    ->findAll();
            } else {
                return $this->whereIn('user_shift_schedule.location', $locationIds)
                    ->findAll();
            }
        } else {
            if ($userId !== null) {
                return $this->where('user_shift_schedule.userid', $userId)
                    ->findAll();
            } else {
                return $this->findAll();
            }
        }
    }
    public function getalluserlocation($locationIds)
    {
        return $this->db->table('assigned_locations')
            ->select('user_shift_schedule.id, user_shift_schedule.userid,assigned_locations.user_id as assigned_locations_userid')
            ->join('user_shift_schedule', 'assigned_locations.location_id = user_shift_schedule.location')
            ->groupBy('user_shift_schedule.id')
            ->get()
            ->getResult();
    }
    public function chkshiftavailable($userId = null, $startTime = null, $endTime = null, $date = null, $currentShiftId = null)
    {
        $sql = "SELECT * FROM user_shift_schedule WHERE 1 = 1 ";
        if ($userId !== null) {
            $sql .= "AND userid = '$userId' ";
        }
        if ($date !== null && $startTime !== null && $endTime !== null) {
            $startMinutes = $this->timeToMinutes($startTime);
            $endMinutes = $this->timeToMinutes($endTime);
            $sql .= "AND date = '$date' AND ";
            $sql .= "((TIME_TO_SEC(start_time) / 60) < $endMinutes AND (TIME_TO_SEC(end_time) / 60) > $startMinutes) ";
        }
        if ($currentShiftId !== null) {
            $sql .= "AND id != $currentShiftId ";
        }
        return $this->query($sql)->getResult();
    }
    private function timeToMinutes($time)
    {
        $parts = explode(':', $time);
        return ($parts[0] * 60) + $parts[1];
    }
    public function getTotalShiftHours($userId, $refDate, $selectedDate)
    {
        $refDateFormatted = date('Y-m-d', strtotime($refDate));
        $selectedDateFormatted = date('Y-m-d', strtotime($selectedDate));

        $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_time, start_time)))) AS total_shift_hours
            FROM $this->table
            WHERE userid = '$userId'
            AND date >= '$refDateFormatted'
            AND date <= '$selectedDateFormatted'";
        $result = $this->query($sql)->getResult();
        return $result;
    }
}
