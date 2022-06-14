@extends('layouts.admin')

@section('styles')

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css')}}">

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
                        <h1 class="m-0">Ստեղծել նորություն</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{route('admin.news.index')}}" style="color: inherit;">Նորություններ</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <form id="create-form" style="width: 100%;" action="{{route('admin.news.store')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left column -->
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="col-form-label" for="title_am">@error('title_am')<i
                                                    class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)
                                            </label>
                                            <input type="text"
                                                   class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                                   id="title_am" name="title_am" value="{{old('title_am')}}">
                                            @error('title_am')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="col-form-label" for="title_en">@error('title_en')<i
                                                    class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)
                                            </label>
                                            <input type="text"
                                                   class="form-control form-control-sm @error('title_en') is-invalid @enderror"
                                                   id="title_en" name="title_en" value="{{old('title_en')}}">
                                            @error('title_en')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6 mb-4">
                                            <label class="col-form-label">Բովանդակություն (հայերեն)
                                            </label>
                                            <div class="input-group-sm">
                                                    <textarea
                                                        class="form-control @error('content_am') is-invalid @enderror ckeditor"
                                                        name="content_am" rows="10">{{old('content_am')}}</textarea>
                                                @error('content_am')
                                                    <span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-6 mb-4">
                                            <label class="col-form-label">Բովանդակություն (անգլերեն)
                                            </label>
                                            <div class="input-group-sm">
                                                    <textarea
                                                        class="form-control @error('content_en') is-invalid @enderror ckeditor"
                                                        name="content_en" rows="10">{{old('content_en')}}</textarea>
                                                @error('content_en')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-6 mb-4">
                                            <label for="excerpt_am" class="col-form-label">Համառոտ (հայերեն) </label>
                                            <div class="input-group-sm">
                                                    <textarea
                                                        class="form-control @error('excerpt_am') is-invalid @enderror ckeditor"
                                                        name="excerpt_am" rows="10">{{old('excerpt_am')}}</textarea>
                                                @error('excerpt_am')
                                                    <span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-6 mb-4">
                                            <label for="excerpt_en" class="col-form-label">Համառոտ (անգլերեն)</label>
                                            <div class="input-group-sm">
                                                    <textarea
                                                        class="form-control @error('excerpt_en') is-invalid @enderror ckeditor"
                                                        name="excerpt_en" rows="10">{{old('excerpt_en')}}</textarea>
                                                @error('excerpt_en')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right column -->
                                <div class="col-md-3 post-box">
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <div class="card card-default">
                                                <div class="card-header" data-card-widget="collapse">
                                                    <div class="card-title">
                                                        Նկար
                                                    </div>
                                                    <div class="col-4 p-0 float-right cart-header-actions">
                                                        <button style="float: right;" class="btn btn-sm btn-primary green-btn"
                                                                form="create-form" type="submit">Հրապարակել
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 p-0">
                                                            <media-uploader
                                                                prop-input-name="main_image"
                                                                prop-size="full"
                                                                class="@error('main_image') is-invalid @enderror"
                                                                :prop-selected-attachments="{{json_encode(\App\Models\Attachment::where('id', old('main_image'))->get())}}"
                                                            ></media-uploader>
                                                            @error('main_image')<span
                                                                class="invalid-feedback">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="categories">Կատեգորիա</label>
                                                <select id="categories" class="select2 form-control" name="categories[]"
                                                        multiple="multiple">
                                                    @foreach($categories as $category)
                                                        <option value={{$category->id}} >{{ $category->title_am }}</option>
                                                    @endforeach
                                                </select>

                                                @error('category')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Ամսաթիվ</label>
                                                <div class="input-group-sm">
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-danger" type="button" id="button-addon1" onclick="$('#date').val('')">X</button>
                                                        <input type="text" name="date" id="date"
                                                               class="form-control datepicker @error('date') is-invalid @enderror"
                                                               placeholder="YYYY-MM-DD"
                                                               autocomplete="off"
                                                               value="{{ old('date') }}"
                                                               aria-label="Example text with button addon"
                                                               aria-describedby="button-addon1">
                                                    </div>

                                                    @error('date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <small>
                                                    <i class="fa fa-info-circle"> </i> Ամսաթիվ չնշելու դեպքում, կնշվի ստեղծման ամսաթիվը։
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: "classic"
            });

            $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'})

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            $("body").on('click', '.cart-header-actions', function (event) {
                event.stopPropagation();
            });
        });
    </script>
@endsection
