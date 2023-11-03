@extends('layouts.app')
@section('view')
help_view
@endsection
@section('row')
<div class="col-lg-12 loader-view">
@include('loader.help-view')
</div>
@endsection
@section('modal')
@include('components.modal')
@endsection
