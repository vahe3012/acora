@extends('layouts.admin')

@section('styles')
    <style>
        .input-group-sm {
            padding-top: 3px;
        }

        .card-header {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Խմբագրել: {{$category->title_am}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.categories.index')}}"
                                                                  style="color: inherit;">Կատեգորիա</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.categories._form', ['action' => route('admin.categories.update', $category->id), 'method' => 'PUT', 'report' => $category])
        </section>
    </div>

@endsection

