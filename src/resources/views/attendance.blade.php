@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

<style>
svg.w-5.h-5 {
    width: 30px;
    height: 30px;
}
</style>

@section('content')

<div class="main-container">

    <div class="date">
    <h2>{{ \Carbon\Carbon::now()->format('Y/m/d') }}</h2>
    </div>

    <table class="form-table">
        <tr class="table-title">
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤務終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
        </tr>

        @foreach($attendances as $record)
            <tr>
                <td>{{ $record->user->name }}</td>
                <td>{{ $record->start_time }}</td>
                <td>{{ $record->end_time }}</td>
                <td>{{ $record->totalBreakHours() }}</td>
                <td>{{ $record->totalWorkHours() }}</td>
            </tr>
        @endforeach
    </table>

    <div class="main_pagination-container">
        {{ $attendances->links() }}
    </div>

</div>

@endsection