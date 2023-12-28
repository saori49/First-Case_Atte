@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
  <div class="main-container">

    @if(session('login_success'))
      <div class="alert alert-success">
        {{session('login_success')}}
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-danger">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <div class="top-sentence">
      <h2>{{Auth::user()->name}}さんお疲れ様です！</h2>
    </div>

    <div class="button-container">
      <div class="button-inner">
        <form method="post" action="{{route('start-work')}}">
        @csrf
          <button type="submit" name="start_time" id="startWorkButton" class="button">勤務開始</button>
        </form>

        <form method="post" action="{{route('end-work')}}">
        @csrf
          <button type="submit" name="end_time" id="endWorkButton" class="button">勤務終了</button>
        </form>
      </div>

      <div class="button-inner">
        <form method="post" action="{{route('start-break')}}">
        @csrf
          <button type="submit" name="break_start" id="startBreakButton" class="button">休憩開始</button>
        </form>

        <form method="post" action="{{route('end-break')}}">
        @csrf
          <button type="submit" name="break_end" id="endBreakButton" class="button">休憩終了</button>
        </form>
      </div>
    </div>
  </div>
@endsection
