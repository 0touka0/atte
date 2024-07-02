<?php

namespace App\Http\Controllers;

use App\Models\BreakTime;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserListController extends Controller
{
    public function userlist(Request $request)
    {
        $request->session()->put('userlist_page', $request->input('page', 1));

        $users = User::paginate(5);

        $works = collect();
        $breakTimes = collect();
        $statuses = collect();

        foreach ($users as $user) {
            $userWorks = Work::where('user_id', $user->id)->whereNull('end')->get();
            $works[$user->id] = $userWorks;

            foreach ($userWorks as $work) {
                $breakTimes[$work->id] = BreakTime::where('work_id', $work->id)->whereNull('end')->get();
            }

            if ($userWorks->isEmpty()) {
                $statuses[$user->id] = '退勤';
            } else {
                $isOnBreak = false;
                foreach ($userWorks as $work) {
                    if (isset($breakTimes[$work->id]) && !$breakTimes[$work->id]->isEmpty()) {
                        $isOnBreak = true;
                        break;
                    }
                }
                $statuses[$user->id] = $isOnBreak ? '休憩中' : '勤務中';
            }
        }

        return view('userlist', compact('users', 'works', 'statuses'));
    }

    public function userdata(Request $request)
    {
        // 指定ユーザーのレコードを取得
        $user = User::find($request->id);

        if ($user) {
            $user_id = $user->id;
            // 上記ユーザーの勤務と休憩オブジェクトを格納
            $works = Work::where('user_id', $user_id)->with(['breakTimes'])->paginate(5);

            // 勤務時間と休憩時間の合計を計算
            $works->each(function ($work) {
                // 日付のフォーマット
                $startDateTime = new \DateTime($work->start);
                $work->startDateFormatted = $startDateTime->format('Y-m-d');

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

                // 表示時間のフォーマット
                $work->startFormatted = $workStartTime->format('H:i:s');
                $work->endFormatted = $workEndTime->format('H:i:s');
                $work->totalBreakTimeFormatted = gmdate('H:i:s', $totalBreakTime);
                $work->actualWorkTimeFormatted = gmdate('H:i:s', $actualWorkTime);
                // dd($work->startFormatted, $work->endFormatted);
            });

        } else {
            // ユーザーが見つからなかった場合の処理
            return response()->json(['error' => 'User not found'], 404);
        }

        return view('userdata', compact('user', 'works'));
    }
}

