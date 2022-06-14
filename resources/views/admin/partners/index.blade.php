@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Գործընկերներ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.partners.index')}}"
                                                                  style="color: inherit;">Գործընկերներ</a></li>
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
                        <h3 class="card-title">Գործընկերներ</h3>
                        <div class="card-tools">
                            <div class="float-sm-right">
                                <a href="{{route('admin.partners.create')}}" class="btn btn-success">Ստեղծել</a>
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
                name: "partners",
                order: [5, "desc"],
                columnDefs: [1, 2, 3, 4, 6],
                columns: [
                    {data: 'id'},
                    {
                        title: '<i class="far fa-image"></i>',
                        data: 'image',
                        type: 'image',
                    },
                    {
                        data: 'title_am',
                        title: 'Վերնագիր (հայերեն)'
                    },
                    {
                        data: 'title_en',
                        title: 'Վերնագիր (անգլերեն)'
                    },
                    {
                        data: 'is_partner',
                        title: 'Գործընկեր',
                        type: 'boolean'
                    },
                    {
                        title: 'Ստեղծման ամսաթիվ',
                        data: 'created_at',
                        type: 'date'
                    }
                ]
            })
        });
    </script>
@endsection
