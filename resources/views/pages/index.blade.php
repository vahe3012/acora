@extends('layouts.admin')

@section('content')
{{--    <div class="content-wrapper">--}}
{{--        <section class="content">--}}
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <h3 class="card-title">Pages</h3>
                                <div class="card-tools">
                                    <a class="btn btn-success" href="{{route('pages.create')}}">Create</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-lg-12 col-md-4 col-sm-6 col-xs-12 p-0 text-right">
                                            <div class="form-group">
                                                <div class="d-inline-block">
                                                    <button id="delete">Delete selected rows</button>
                                                </div>
                                                <select name="status" class="form-control">
                                                    <option value selected="selected">Filter by status</option>
                                                    <option value="publish">Published</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                        <table
                                            class="table table-striped table-bordered dataTable no-footer datatable w-100"
                                            role="grid"
                                            aria-describedby="datatable_info">
                                            <thead>
                                            <tr role="row">
                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                                                    <input type='checkbox' id='checkAll' class="checkAll">
                                                </th>
                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                                                    Page ID
                                                </th>
{{--                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">--}}
{{--                                                    <i class="far fa-image"></i>--}}
{{--                                                </th>--}}
                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                                                    Title
                                                </th>
                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                                                    Slug
                                                </th>
                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                                                    aria-sort="ascending">Status
                                                </th>
                                                <th tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                                                    Actions
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
{{--        </section>--}}
{{--    </div>--}}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection

@section('scripts')


    <!-- jQuery -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    {{--    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>--}}

    <!-- Bootstrap 4 -->


    <!--Import jQuery before export.js-->
    {{--    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>--}}


    <!--Data Table-->
    {{--    <script type="text/javascript"  src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>--}}
    {{--    <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>--}}

    <script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
    {{--    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>--}}
    {{--    <script src="{{asset('js/dataTables.responsive.min.js')}}"></script>--}}
    {{--    <script src="{{asset('js/responsive.bootstrap4.min.js')}}"></script>--}}

    {{--    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>--}}
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>--}}

    <script>
        $(document).ready(function () {
            // DataTable
            let table = $('.datatable').DataTable({
                columnDefs: [
                    {"orderable": false, "targets": [0, 1]},
                ],
                aaSorting: [],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('pages.draw')}}",
                    data: function (data) {
                        // Append to data
                        data.filterByStatus = $('select[name="status"]').val();
                    }
                },
                columns: [

                    {
                        data: 'id', render: function (data) {
                            return `<td><input type="checkbox" class="delete_check" value="${data}"></td>`
                        }
                    },

                    {data: 'id'},

                    // {
                    //     data: 'main_image', render: function (data) {
                    //         return data ? `<img loading="lazy"  width="110" src="${data.urls && data.urls.medium}">` : 'no image'//
                    //     }
                    // },
                    {
                        data: 'title', render: function (data, type, row) {
                            return `<a target="_blank" href="${row.publish_url}">${data}</a>`;
                        }
                    },
                    {data: 'slug'},
                    {
                        data: 'status', render: function (data) {
                            return upperWord(data.split('_').join(' '));
                        }
                    },

                    {
                        data: 'id', render: function (data) {
                            return `<a class="btn btn-info" href="/pages/${data}/edit"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-raised btn-icon btn-danger delete-confirm-btn" data-popup="delete-confirm-${data}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <div class="text-center delete-popup delete-confirm-${data} d-none">
                        <div class="mb-1">Are you sure?</div>
                        <div class="d-flex justify-content-center">
                            <form action="/pages/${data}" class="delete-form" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                {{csrf_field()}}
                            <button type="submit" class="btn btn-raised btn-danger mr-1 delete_form">
                                Yes
                            </button>
                        </form>
                        <button class="btn btn-raised btn-secondary mr-1 delete-popup-close" type="button">
                            No
                        </button>
                    </div>
                    </div>`
                        }
                    },
                ]
            });

            // Draw table after filtering
            const body = $('body')

            body.on('change', 'select[name="status"]', function () {
                table.draw();
            });

            //Search with Enter button
            $('.dataTables_wrapper input[type="search"]').unbind().bind('keyup', function (e) {
                if (e.keyCode === 13) {
                    table.search(this.value).draw();
                }
            });
            body.on("change", "#checkAll", function () {
                let checked = $(this).is(':checked');

                $('.delete_check').each(function () { // stexela petq grel body???
                    $(this).prop('checked', !!checked);
                });
            });

            //Delete selected
            {{--body.on("click", "#delete", function () {--}}
            {{--    let selected = [];--}}
            {{--    $(".delete_check:checked").each(function () {--}}
            {{--        selected.push($(this).attr('value'));--}}
            {{--    });--}}
            {{--    // sranq poxelu entaka en--}}
            {{--    if (!selected.length) {--}}
            {{--        alert("Please select pages.");--}}
            {{--    } else {--}}
            {{--        let check = confirm("Are you sure you want to delete this ?"); // poxel Xoreni pes--}}
            {{--        if (check === true) {--}}
            {{--            $.ajax({--}}
            {{--                url: "{{route('pages.deleteSelected')}}",--}}
            {{--                method: "post",--}}
            {{--                data: {--}}
            {{--                    idList: selected,--}}
            {{--                    _token: "{{ csrf_token() }}" // POST-i jamanak token@ petq e poxancvi--}}
            {{--                },--}}
            {{--                success: function (data) {--}}
            {{--                    $('.datatable').DataTable().ajax.reload();--}}
            {{--                }--}}
            {{--            })--}}
            {{--        }--}}
            {{--    }--}}

            {{--});--}}


            body.on('click', '.delete-confirm-btn', function () {
                $(`body .${$(this).attr('data-popup')}`).removeClass('d-none')
            })

            body.on('click', '.delete-popup-close', function () {
                $('body .delete-popup').addClass('d-none')
            })
        });

        function upperWord(str) {
            const arr = str.split(" ");

            for (let i = 0; i < arr.length; i++) {
                arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
            }

            return arr.join(" ")
        }

    </script>
@endsection
