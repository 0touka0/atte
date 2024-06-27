<?php

namespace App\Http\Controllers;

use App\Models\BreakTime;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function index()
    {
        $id = Auth::id(); // 現在ログインしているユーザのIDを取得
        $user = User::where('id', $id)->first();

        // 勤務中か否か
        $isWorking = Work::where('user_id', $id)->whereNull('end')->exists();

        // 休憩中か否か
        $isOnBreak = BreakTime::whereHas('work', function ($query) use ($id) {
            $query->where('user_id', $id)->whereNull('end');
        })->whereNull('end')->exists();

        return view('index', compact('user','isWorking', 'isOnBreak'));
    }

    //勤務時間
    public function startWork()
    {
        $user_id = Auth::id();
        $start = now();

        $work = Work::where('user_id', $user_id)->whereNull('end')->first(); // 終了していない勤務のレコードを取得
        // もし既に終了していない勤務がある場合は、エラーメッセージを返す
        if ($work) {
            return redirect('/')->with('message', '既に勤務中です');
        }

        Work::create([
            'user_id' => $user_id,
            'start' => $start,
            'end' => null,
        ]);

        return redirect('/')->with('message', '勤務開始');
    }

    public function endWork()
    {
        $user_id = Auth::id();
        $end = now();
        $work = Work::where('user_id', $user_id)->whereNull('end')->first(); // 終了していない勤務のレコードを取得

        if ($work) {
            // 勤務開始時間を数値型に変換
            $workStartTime = Carbon::parse($work->start);

            // 勤務開始時間と終了時間の日付が異なる場合
            if ($workStartTime->format('Y-m-d') != $end->format('Y-m-d')) {
                // 終了時間を前日の23:59に設定
                $work->update(['end' => $end->copy()->subDay()->endOfDay()]);

                // 翌日の勤務を開始し、現在の時間で終了させる新しいレコードを作成
                Work::create([
                    'user_id' => $user_id,
                    'start' => $end->copy()->startOfDay(),
                    'end' => $end,
                ]);
            } else {
                $work->update(['end' => $end]);
            }
            return redirect('/')->with('message', '勤務終了');
        } else {
            return redirect('/')->with('message', '勤務終了の記録が見つかりませんでした');
        }
    }

    //休憩時間
    public function startBreak()
    {
        $user_id = Auth::id();

        // 終了していない休憩を取得
        $break = BreakTime::whereHas('work', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->whereNull('end');
        })->whereNull('end')->first();
        // もし終了していない休憩がある場合は、エラーメッセージを返す
        if ($break) {
            return redirect('/')->with('message', '既に休憩中です');
        }

        // 終了していない勤務のレコードを取得
        $work = Work::where('user_id', $user_id)->whereNull('end')->first();

        if ($work) {
            $start = now();
            BreakTime::create([
                'work_id' => $work->id,
                'start' => $start,
            ]);
            return redirect('/')->with('message', '休憩開始');
        } else {
            return redirect('/')->with('message', '勤務中の記録が見つかりませんでした');
        }
    }

    public function endBreak()
    {
        $user_id = Auth::id();
        $end = now();
        // 現在勤務中のユーザーが記録した、終了していない休憩のレコードを取得
        $break = BreakTime::whereHas('work', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)->whereNull('end');
        })->whereNull('end')->first();

        if ($break) {
            // 休憩開始時間を数値型に変換
            $breakStartTime = Carbon::parse($break->start);

            // 休憩開始時間と終了時間の日付が異なる場合
            if ($breakStartTime->format('Y-m-d') != $end->format('Y-m-d')) {
                $break->update(['end' => $end->copy()->subDay()->endOfDay()]);

                // 翌日の休憩を開始し、現在の時間で終了させる新しいレコードを作成
                BreakTime::create([
                    'work_id' => $break->work_id,
                    'start' => $end->copy()->startOfDay(),
                    'end' => $end,
                ]);
            } else {
                $break->update(['end' => $end]);
            }
            return redirect('/')->with('message', '休憩終了');
        } else {
            return redirect('/')->with('message', '休憩中の記録が見つかりませんでした');
        }
    }
}
