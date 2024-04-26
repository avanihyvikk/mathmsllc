<?php

namespace App\Controllers;
use App\Controllers\AdminBaseController;
use App\Models\ScheduleModel;
use App\Models\UserModel; // Import the UserModel
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Schedule extends BaseController
{
    protected $scheduleModel;
    protected $userModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display the schedule view with all necessary data.
     */
    public function index()
{
    $users = $this->userModel->findAll();
    $dates = $this->getWeekDates();

    $schedules = []; // This will be an associative array [userId => [date => schedule]]
    foreach ($users as $user) {
        foreach ($dates as $date) {
            // Ensure $user->id is used (object syntax)
            $schedules[$user->id][$date] = $this->scheduleModel->getSchedulesForWeek($date, $user->id);
        }
    }

    return view('schedules/index', [
        'users' => $users,
        'dates' => $dates,
        'schedules' => $schedules,
    ]);
}

    /**
     * Find the last Monday and the next 7 days.
     *
     * @return array An array of 'Y-m-d' formatted strings.
     */
    private function getWeekDates()
    {
        $today = new Time('now');
        // If today is Monday, use today's date; otherwise, find the previous Monday
        $dayOfWeek = $today->getDayOfWeek();
        $monday = ($dayOfWeek === 1) ? $today : $today->subDays($dayOfWeek - 1);

        $dates = [];

        for ($i = 0; $i < 7; $i++) {
            $dates[] = $monday->addDays($i)->toDateString();
        }

        return $dates;
    }

   public function createSchedule()
{
    // Check if the request is a POST request
    if ($this->request->getMethod() === 'post') {
        // Validate the submitted data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'employee_id' => 'required|integer',
            'date' => 'required|valid_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location_id' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $employeeId = $this->request->getPost('employee_id');
        $date = $this->request->getPost('date');
        $startTime = $this->request->getPost('start_time');
        $endTime = $this->request->getPost('end_time');
        $locationId = $this->request->getPost('location_id') ?? 14; // Default to 14 if not provided

        // Calculate total time in minutes
        $totalTime = $this->scheduleModel->calculateTotalTime($startTime, $endTime);

        // Prepare data for insertion
        $data = [
            'employee_id' => $employeeId,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_time' => $totalTime,
            'location_id' => $locationId,
        ];

        // Insert the schedule
        if ($this->scheduleModel->upsertSchedule($data)) {
            // Insertion successful
            return redirect()->to('/schedules')->with('message', 'Schedule added successfully.');
        } else {
            // Insertion failed
            return redirect()->back()->withInput()->with('errors', ['Failed to add schedule.']);
        }
    }

    // If not a POST request, redirect back or to a default page
    return redirect()->to('/schedules');
}
}