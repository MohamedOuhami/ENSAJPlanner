<?php

namespace App\Services;

use App\Group;
use App\Lesson;
use App\Timetable;
use Carbon\Carbon;
use App\LessonGroup;

class CalendarService
{
    public function generateCalendarData($weekDays)
    {
        $calendarData = [];
        $timetableid = request()->query('timetable_id');
        $timetable = Timetable::find($timetableid);

        $timeRange = $this->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons = Lesson::with('matiere', 'teacher', 'salle', 'timetable.section')
            ->where('timetable_id', $timetableid)
            ->get();

        // Group lessons by weekday and start_time
        $groupedLessons = $lessons->groupBy(['weekday', 'start_time']);


        foreach ($timeRange as $time) {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day) {
                $lessons_collection = $groupedLessons->get($index);

                if ($lessons_collection) {
                    // Process the grouped lessons data and push it into the calendarData array
                    $groupedData = [];

                    // Find the lessons that match the current time slot
                    $lessons_at_time = $lessons_collection->get($time['start']);

                    if ($lessons_at_time) {
                        foreach ($lessons_at_time as $lesson) {
                            $vhc = $lesson->matiere->volume_horaire_Cours;
                            $vhtd = $lesson->matiere->volume_horaire_TD;
                            $oc = $lesson->matiere->occ_per_week_Cours;
                            $otd = $lesson->matiere->occ_per_week_TD;
                            $groups_ids = LessonGroup::where('lesson_id', $lesson->id)->pluck('group_id');
                            $groups = Group::whereIn('id', $groups_ids)->pluck('intitule');

                            array_push($groupedData, [
                                'class_name' => $lesson->matiere->name,
                                'professor' => $lesson->teacher->name,
                                'type' => $lesson->type,
                                'start_time' => $lesson->start_time,
                                'groups' => $groups ?? '',
                                'salle' => $lesson->salle->label,
                                'weekday' => $lesson->weekday,
                                'skipped' => false,
                                'weekTextCours' => 'S1 - S' . ceil(1 + $vhc / (2 * $oc)),
                                'weekTextTD' => $otd == 0 ? 'N/A' : 'S2 - S' . ceil(2 + $vhtd / (2 * $otd)),
                                'section' => $lesson->timetable->section->Intitule,
                                'timeText' => $timeText,
                                // Set timeText to the current time slot
                                'rowspan' => 1 ?? ''
                            ]);
                        }
                    }

                    // Push the grouped data into the calendarData array
                    array_push($calendarData[$timeText], $groupedData);
                } else {
                    // No lesson found, push null into the calendarData array
                    array_push($calendarData[$timeText], null);
                }
            }
        }

        return $calendarData;
    }

    // Show all of the lessons in 1 timetable

    public function generateCalendarDataTotal($weekDays)
    {
        $calendarData = [];
 

        $timeRange = $this->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons = Lesson::all();

        // Group lessons by weekday and start_time
        $groupedLessons = $lessons->groupBy(['weekday', 'start_time']);


        foreach ($timeRange as $time) {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day) {
                $lessons_collection = $groupedLessons->get($index);

                if ($lessons_collection) {
                    // Process the grouped lessons data and push it into the calendarData array
                    $groupedData = [];

                    // Find the lessons that match the current time slot
                    $lessons_at_time = $lessons_collection->get($time['start']);

                    if ($lessons_at_time) {
                        foreach ($lessons_at_time as $lesson) {
                            $vhc = $lesson->matiere->volume_horaire_Cours;
                            $vhtd = $lesson->matiere->volume_horaire_TD;
                            $oc = $lesson->matiere->occ_per_week_Cours;
                            $otd = $lesson->matiere->occ_per_week_TD;
                            $groups_ids = LessonGroup::where('lesson_id', $lesson->id)->pluck('group_id');
                            $groups = Group::whereIn('id', $groups_ids)->pluck('intitule');

                            array_push($groupedData, [
                                'class_name' => $lesson->matiere->name,
                                'professor' => $lesson->teacher->name,
                                'type' => $lesson->type,
                                'start_time' => $lesson->start_time,
                                'groups' => $groups ?? '',
                                'salle' => $lesson->salle->label,
                                'weekday' => $lesson->weekday,
                                'skipped' => false,
                                'weekTextCours' => 'S1 - S' . ceil(1 + $vhc / (2 * $oc)),
                                'weekTextTD' => $otd == 0 ? 'N/A' : 'S2 - S' . ceil(2 + $vhtd / (2 * $otd)),
                                'section' => $lesson->timetable->section->Intitule,
                                'timeText' => $timeText,
                                // Set timeText to the current time slot
                                'rowspan' => 1 ?? ''
                            ]);
                        }
                    }

                    // Push the grouped data into the calendarData array
                    array_push($calendarData[$timeText], $groupedData);
                } else {
                    // No lesson found, push null into the calendarData array
                    array_push($calendarData[$timeText], null);
                }
            }
        }

        return $calendarData;
    }



    public function generateTimeRange($startTime, $endTime)
    {
        $timeRange = [
            ['start' => '08:00', 'end' => '10:00'],
            ['start' => '10:15', 'end' => '12:15'],
            ['start' => '13:00', 'end' => '15:00'],
            ['start' => '15:15', 'end' => '17:15']
        ];

        return $timeRange;
    }

}