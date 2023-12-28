<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;


class AuthController extends Controller
{
//homeページ表示
    public function index()
    {
        return view('index');
    }

    //打刻処理
    public function startWork(Request $request)
    {
        $date = $request->input('date');
        $existingRecord = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('date', now())
            ->first();

        if ($existingRecord) {
            Session::flash('punch_error', '本日は既に勤務を開始しています。');
        } else {
            Attendance::create([
                'user_id'    => auth()->user()->id,
                'start_time' => now()->toTimeString(),
                'date'       => now()->toDateString(),
            ]);
            Session::flash('punch_success', '勤務を開始しました。');
        }

        return redirect()->back();
    }

    public function endWork(Request $request)
    {
        $record = Attendance::where('user_id', auth()->user()->id)
            ->whereNull('end_time')
            ->first();

        if ($record) {
            $record->update([
                'end_time' => now()->toTimeString(),
                ]);
                Session::flash('punch_success', '勤務を終了しました。');
            } else {
            Session::flash('punch_error', '本日はまだ勤務を開始していません。');
        }

        return redirect()->back();
    }

    public function startBreak(Request $request)
    {
        Attendance::create([
            'user_id'     => auth()->user()->id,
            'break_start' => now()->toTimeString(),
            'date'        => now()->toDateString(),
        ]);

        Session::flash('punch_success', '休憩を開始しました。');

        return redirect()->back();
    }

    public function endBreak(Request $request)
    {
        $record = Attendance::where('user_id', auth()->user()->id)
            ->whereNotNull('break_start')
            ->whereNull('break_end')
            ->latest('date')
            ->first();

        if ($record) {
            $record->update([
                'break_end' => now()->toTimeString(),
            ]);
            Session::flash('punch_success', '休憩を終了しました。');
        } else {
            Session::flash('punch_error', '休憩を開始していません。');
        }

        return redirect()->back();
    }

//loginページ表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //login機能
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 成功
            return redirect()->intended('/')->with('login_success','ログイン成功しました');
        }

        // 失敗
        return back()->with('login_error' ,'メールアドレスかパスワードが間違っています。',);
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('logout','ログアウトしました');
    }

//registerページ表示
    public function create()
    {
        return view('auth.register');
    }

    //register処理
    public function store(RegisterFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('login'))->with('register_success', '会員登録が完了しました。ログインしてください。');
    }


//日付一覧ページ処理
    public function manage()
    {
        $attendances = Attendance::Paginate(5);

        $totalWorkHours = $this->calculateTotalWorkHours($attendances);
        $totalBreakHours = $this->calculateTotalBreakHours($attendances);

        return view('attendance', compact('attendances', 'totalWorkHours', 'totalBreakHours'));

    }

    // 休憩・勤務時間取得
    private function calculateTotalWorkHours($attendances)
    {
        $totalWorkMinutes = 0;

        foreach ($attendances as $record) {
            $totalWorkMinutes += $this->calculateWorkMinutes($record);
        }

        $totalWorkHours = floor($totalWorkMinutes / 60);
        $totalWorkMinutes %= 60;

        return sprintf('%02d:%02d:00', $totalWorkHours, $totalWorkMinutes);
    }

    private function calculateWorkMinutes($record)
    {
        if ($record->start_time && $record->end_time) {
            $start = Carbon::parse($record->start_time);
            $end = Carbon::parse($record->end_time);

            return $end->diffInMinutes($start);
        }

        return 0;
    }

    private function calculateTotalBreakHours($attendances)
    {
        $totalBreakMinutes = 0;

        foreach ($attendances as $record) {
            $totalBreakMinutes += $this->calculateBreakMinutes($record);
        }

        $totalBreakHours = floor($totalBreakMinutes / 60);
        $totalBreakMinutes %= 60;

        return sprintf('%02d:%02d:00', $totalBreakHours, $totalBreakMinutes);
    }

    private function calculateBreakMinutes($record)
    {
        if ($record->break_start && $record->break_end) {
            $breakStart = Carbon::parse($record->break_start);
            $breakEnd = Carbon::parse($record->break_end);

            return $breakEnd->diffInMinutes($breakStart);
        }

        return 0;
    }
}
