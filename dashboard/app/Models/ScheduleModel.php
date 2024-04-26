<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ScheduleModel extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'schedule_id';
    protected $allowedFields = ['employee_id', 'location_id', 'date', 'start_time', 'end_time', 'total_time'];

    /**
     * Fetch schedules for a given week.
     *
     * @param string $date Any date within the week of interest.
     * @param int|null $employeeId (optional) Specific employee to filter schedules.
     * @return array An array of schedules.
     */
    public function getSchedulesForWeek($date, $employeeId = null)
    {
        // Convert $date to a Time instance, find the last Monday
        $time = new Time($date);
        $monday = $time->startOfWeek();

        // Build the base query
        $query = $this->where('date >=', $monday->format('Y-m-d'))
                      ->where('date <=', $monday->addDays(6)->format('Y-m-d'));

        if (!is_null($employeeId)) {
            $query = $query->where('employee_id', $employeeId);
        }

        return $query->findAll();
    }

    /**
     * Insert or update a schedule.
     *
     * @param array $data Schedule data.
     * @return bool True on success, false on failure.
     */
    public function upsertSchedule($data)
    {
        // Attempt to find an existing schedule for the date and employee
        $existingSchedule = $this->where('date', $data['date'])
                                 ->where('employee_id', $data['employee_id'])
                                 ->first();

        if ($existingSchedule) {
            return $this->update($existingSchedule['schedule_id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    /**
     * Calculate total time in minutes from start and end times.
     *
     * @param string $startTime Start time (e.g., "08:00").
     * @param string $endTime End time (e.g., "17:00").
     * @return int Total time in minutes.
     */
    public function calculateTotalTime($startTime, $endTime)
    {
        $start = Time::createFromFormat('H:i', $startTime);
        $end = Time::createFromFormat('H:i', $endTime);
        return $end->difference($start)->getMinutes();
    }
}