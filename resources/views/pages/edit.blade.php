@extends('layouts.admin')

@section('styles')
    <style>
        .input-group-sm{
            padding-top: 3px;
        }

        .card-header {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper admin-product-edit-content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-sm-6 pl-0">
                        <h1>Edit Page</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <form id="create-form" style="width: 100%;" action="{{route('pages.update', $page->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="form-group">
                                            <label class="col-form-label">Վերնագիր</label>
                                            <div class="input-group-sm">
                                                <input type="text" name="title"
                                                       onkeyup="document.getElementById('slug_input').value= this.value.split(' ').join('-').toLowerCase()"
                                                       value="{{$page->title}}" class="form-control @error('title') is-invalid @enderror">
                                                @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Slug</label>
                                            <div class="input-group-sm">
                                                <input type="text" name="slug" id="slug_input" value="{{$page->slug}}" class="form-control @error('slug') is-invalid @enderror">
                                                @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Content</label>
                                            <div class="input-group-sm">
                                        <textarea class="form-control @error('content') is-invalid @enderror ckeditor"
                                                  name="content" rows="20">{{$page->content}}</textarea>
                                                @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card card-default">
{{--                                    <div class="post-box">--}}
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
                                                       value="{{$page->canonical}}"
                                                       class="form-control @error('canonical') is-invalid @enderror">
                                                @error('canonical')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </label>
                                        </div>
                                        <div class="form-group row pl-3 pr-3">
                                            <label class="col-form-label input-box">
                                                <span>Վերնագիր</span>
                                                <input type="text" name="meta_title" id="meta_title" value="{{$page->meta_title}}"
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
                                                    name="meta_description" rows="4">{{$page->meta_description}}</textarea>
                                                @error('meta_description')<span
                                                    class="invalid-feedback">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 post-box">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div>
                                            <div class="mb-3">
                                                <a class="btn-preview" target="_blank" href="{{$page->publish_url}}">Preview</a>
                                            </div>
                                            <div>
                                                <div class="row">
                                                    <div class="col-8 p-0">
                                                        <div class="form-group row">
                                                            <div class="col-12 p-0 input-group-sm">
                                                                <select name="status" class="form-control custom-select">
                                                                    <option value="publish" @if($page->status === 'publish') selected @endif>Publish</option>
                                                                    <option value="pending" @if($page->status === 'pending') selected @endif>Pending</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 p-0">
                                                        <button style="float: right;" class="btn btn-sm btn-primary" form="create-form" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="card card-default">
                                    <div class="card-header" data-card-widget="collapse">
                                        <div class="card-title">
                                            Main image
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 p-0">
                                                <media-uploader
                                                    prop-input-name="main_image"
                                                    prop-size="full"
                                                    class="@error('main_image') is-invalid @enderror"
                                                    :prop-selected-attachments="{{json_encode($page->mainImage ? [$page->mainImage] : [])}}"
                                                ></media-uploader>
                                                @error('main_image')<span class="invalid-feedback">{{ $message }}</span>@enderror
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
        $("body").on('click', '.card-header .cart-header-actions', function(event){
            event.stopPropagation();
        });
    </script>
@endsection
