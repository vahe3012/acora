@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Թվապատկերներ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.digital-images.index')}}" style="color: inherit;">Թվապատկերներ</a></li>
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
                                <a href="{{route('admin.digital-images.create')}}" class="btn btn-success">Ստեղծել</a>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            new Table({
                name: "digital-images",
                order: [5, "desc"],
                columnDefs: [1, 2, 3, 4, 6],
                columns: [
                    {data: 'id'},
                    {
                        data: 'order',
                        title: 'Հերթականություն'
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
                        title: '<i class="far fa-image"></i>',
                        data: 'attachment',
                        type: 'image'
                    },
                    {
                        title: 'Ստեղծման ամսաթիվ',
                        data: 'created_at',
                        type: 'date'
                    }
                ]
            })

            $("table").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function () {
                    let order = [];

                    $('table tr.sortable-row').each(function (index) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });

                    $.post("{{ route('admin.digitalImages.sort') }}", {order: order})
                        .done(response => {
                            if (response.status === "success") {
                                console.log(response)
                            } else {
                                console.log(response)
                            }
                        })
                        .fail(e => console.log(e))
                }
            })
        })
    </script>
@endsection
