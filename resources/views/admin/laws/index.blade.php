@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            @php
                                if (session()->get('lawType') == \App\Models\Law::TYPE_LAW) {
                                    $title = 'Օրենքներ';
                                } elseif (session()->get('lawType') == \App\Models\Law::TYPE_REGULATION) {
                                    $title = 'Կանոնակարգեր';
                                }
                            @endphp
                            {{ $title }}
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.laws.index')}}"
                                                                  style="color: inherit;">{{ $title }}</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <div class="card-tools">
                            <div class="float-sm-right">
                                <a href="{{route('admin.laws.create')}}" class="btn btn-success">Ստեղծել</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12" id="table-init">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            new Table({
                name: "laws",
                order: [4, 'desc'],
                columnDefs: [1, 2, 3, 5],
                columns: [
                    {data: 'id'},
                    {
                        data: 'title_am',
                        title: 'Վերնագիր (հայերեն)'
                    },

                    {
                        data: 'title_en',
                        title: 'Վերնագիր (անգլերեն)'
                    },

                        @if(session()->get('lawType') == \App\Models\Law::TYPE_LAW)
                    {
                        data: 'link',
                        title: 'Հղում'
                    },
                        @elseif(session()->get('lawType') == \App\Models\Law::TYPE_REGULATION)
                    {
                        title: '<i class="far fa-file"></i>',
                        data: 'attachment',
                        type: 'pdf'
                    },
                        @endif
                    {
                        title: 'Ստեղծման ամսաթիվ',
                        data: 'created_at',
                        type: 'date'
                    }
                ],
            })
        });
    </script>
@endsection
