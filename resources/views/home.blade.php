@extends('layouts.app')

@section('content')
<div class="container" style="text-align:center; margin-top:50px;">
    <h1>Welcome to the Scholarship Application System</h1>
    <p>Manage your applications easily and efficiently.</p>

    <div style="margin-top:30px;">
        <a href="{{ route('student.application.create') }}" class="btn btn-primary" style="margin-right:10px;">Add New Application</a>
        <a href="{{ route('applications.index') }}" class="btn btn-success">View Applications</a>
    </div>
</div>
@endsection