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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-4">
                    <h1>Create Page</h1>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <form id="create-form" style="width: 100%;" action="{{route('pages.store')}}" method="post"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-default">
                                    <div>
                                        <div class="form-group row pl-3 pr-3">
                                            <label class="col-form-label input-box">
                                                <span>Վերնագիր</span>
                                                <input type="text" name="title"
                                                       onkeyup="document.getElementById('slug_input').value= this.value.split(' ').join('-').toLowerCase()"
                                                       value="{{old('title')}}"
                                                       class="form-control @error('title') is-invalid @enderror">
                                                @error('title')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </label>
                                        </div>
                                        <div class="form-group row pl-3 pr-3">
                                            <label class="col-form-label input-box">
                                                <span>Slug</span>
                                                <input type="text" name="slug" id="slug_input" value="{{old('slug')}}"
                                                       class="form-control @error('slug') is-invalid @enderror">
                                                @error('slug')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </label>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="col-form-label">Content</label>
                                            <div class="input-group-sm">
                                                <textarea
                                                    class="form-control @error('content') is-invalid @enderror ckeditor"
                                                    name="content" rows="20">{{old('content')}}</textarea>
                                                @error('content')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-default">
                                    <div class="post-box">
                                        <section class="content-header">
                                            <div class="container-fluid">
                                                <div class="row mb-4">
                                                    <h5>SEO</h5>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="form-group row pl-3 pr-3">
                                            <label class="col-form-label input-box">
                                                <span>Canonical</span>
                                                <input type="text" name="canonical"
                                                       value="{{old('canonical')}}"
                                                       class="form-control @error('canonical') is-invalid @enderror">
                                                @error('canonical')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </label>
                                        </div>
                                        <div class="form-group row pl-3 pr-3">
                                            <label class="col-form-label input-box">
                                                <span>Վերնագիր</span>
                                                <input type="text" name="meta_title" id="meta_title" value="{{old('meta_title')}}"
                                                       class="form-control @error('meta_title') is-invalid @enderror">
                                                @error('meta_title')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Description</label>
                                            <div class="input-group-sm">
                                                <textarea
                                                    class="form-control @error('meta_description') is-invalid @enderror"
                                                    name="meta_description" rows="4">{{old('meta_description')}}</textarea>
                                                @error('meta_description')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="post-box">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-default">
                                        <div data-card-widget="collapse">
                                            <div class="card-title">
                                                Main image
                                            </div>
                                            <button style="float: right;" class="btn btn-sm btn-primary"
                                                    form="create-form" type="submit">Publish
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
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
    <script>
        $("body").on('click', '.cart-header-actions', function (event) {
            event.stopPropagation();
        });
    </script>
@endsection
