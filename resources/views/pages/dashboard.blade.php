{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title')
    @php
        $id_token = session()->get('id_Token');
        $email = session()->get('user_email');
    @endphp
  Your Dashboard - {{$email}}

@endsection

{{-- page content --}}
@section('content')
<div class="section">
  <div class="card">
    <div class="card-content">
      <p class="caption mb-0">
      

        Welcome
      </p>
    </div> 
  </div>
</div>
@endsection