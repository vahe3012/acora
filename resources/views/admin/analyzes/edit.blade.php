@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Խմբագրել: {{$analyze->title_am}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.analyzes.index')}}" style="color: inherit;">Վերլուծություններ</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            @include('admin.analyzes._form', ['action' => route('admin.analyzes.update', $analyze->id), 'method' => 'PUT', 'analyze' => $analyze])
        </section>
    </div>
@endsection

