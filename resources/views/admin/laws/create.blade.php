@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @php
                            if (session()->get('lawType') == \App\Models\Law::TYPE_LAW) {
                                $title = 'Օրենքներ';
                            } elseif (session()->get('lawType') == \App\Models\Law::TYPE_REGULATION) {
                                $title = 'Կանոնակարգեր';
                            }
                        @endphp

                        <h1 class="m-0">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{route('admin.laws.index')}}" style="color: inherit;">{{ $title }}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            @include('admin.laws._form', ['action' => route('admin.laws.store')])
        </section>
    </div>
@endsection

