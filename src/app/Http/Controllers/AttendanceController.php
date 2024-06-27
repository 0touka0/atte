<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function attendance($date = null)
    {

        // パラメータがない場合は現在の日付を使用
        $currentDate = $date ? Carbon::parse($date) : Carbon::now();
        // 今日の日付をY-m-d形式にフォーマット
        $today = $currentDate->format('Y-m-d');
        // 前日と次の日を計算
        $previousDate = $currentDate->copy()->subDay()->format('Y-m-d');
        $nextDate = $currentDate->copy()->addDay()->format('Y-m-d');

        // 指定された日付の勤務時間データを取得
        $works = Work::whereDate('start', $today)->with(['breakTimes', 'user'])->paginate(5);

        // 勤務時間と休憩時間の合計を計算
        $totalWorkTime = 0;
        $works->each(function ($work) use (&$totalWorkTime) {
            // 勤務時間の計算
            $workStartTime = Carbon::parse($work->start);
            $workEndTime = Carbon::parse($work->end);
            $workDuration = $workStartTime->diffInSeconds($workEndTime);

            // 休憩時間の計算
            $totalBreakTime = $work->breakTimes->reduce(function ($carry, $breakTime) {
                return $carry + Carbon::parse($breakTime->start)->diffInSeconds($breakTime->end);
            }, 0);

            // 実勤務時間の計算（勤務時間 - 休憩時間）
            $actualWorkTime = $workDuration - $totalBreakTime;
            $work->totalBreakTimeFormatted = gmdate('H:i:s', $totalBreakTime);
            $work->actualWorkTimeFormatted = gmdate('H:i:s', $actualWorkTime);

            // 全体の勤務時間の合計に加算
            $totalWorkTime += $actualWorkTime;
        });

        // 勤務時間をフォーマット
        $totalWorkTimeFormatted = gmdate('H:i:s', $totalWorkTime);

        return view('attendance', compact('works', 'today', 'previousDate', 'nextDate', 'totalWorkTimeFormatted'));
    }
}
