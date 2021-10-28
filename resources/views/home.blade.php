@extends('layouts.app')

@section('content')
<keep-alive>
<router-view></router-view>
<menu></menu>
</keep-alive>
@endsection
