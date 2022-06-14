@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Կարգավորումներ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.settings.index')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active">Կարգավորումներ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <form id="create-form" style="width: 100%;" action="{{route('admin.settings.store')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title"><b>Փոխել կարգավորումները</b></h3>
                        </div>

                        <div class="card-body">
                            <div class="row" style="border: 1px solid rgba(213, 213, 213, 1); padding: 5px;">
                                <div class="col-md-6">
                                    <label for="name" class="mr-3">Սլայդերի նկարներ</label>
                                    <div class="form-group d-inline-block">
                                        <div class="input-group">
                                            <media-uploader
                                                prop-input-name="slider[images]"
                                                prop-button="Ընտրեք նկարներ"
                                                :prop-multiple="true"
                                                class="@error('slider') is-invalid @enderror"
                                                :prop-selected-attachments="{{ json_encode(isset($slider->images) ? \App\Models\Attachment::whereIn('id', $slider->images)->get() : []) }}"
                                            ></media-uploader>
                                            @error('slider[images]')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group" style="padding-left: 0;">
                                        <label class="col-form-label" for="title_am">
                                            @error('slider[title_am]')<i class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)</label>
                                        <input type="text" required
                                               class="form-control form-control-sm @error('slider[title_am]') is-invalid @enderror"
                                               id="title_am" name="slider[title_am]"
                                               value="{{ old('slider[title_am]') ?: ($slider->title_am ?? '') }}">
                                        @error('slider[title_am]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group" style="padding-left: 0;">
                                        <label class="col-form-label" for="title_en">
                                            @error('slider[title_en]')<i class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)</label>
                                        <input type="text" required
                                               class="form-control form-control-sm @error('slider[title_en]') is-invalid @enderror"
                                               id="title_en" name="slider[title_en]"
                                               value="{{ old('slider[title_en]') ?: ($slider->title_en ?? '') }}">
                                        @error('slider[title_en]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                                        <div class="input-group-sm">
                                            <textarea id="description_am" required
                                                  class="form-control @error('slider[description_am]') is-invalid @enderror ckeditor"
                                                  name="slider[description_am]"
                                                  rows="10">{{ old('slider[description_am]') ?: ($slider->description_am ?? '') }}</textarea>
                                            @error('slider[description_am]')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                                        <div class="input-group-sm">
                                            <textarea id="description_en" required
                                                  class="form-control @error('slider[description_en]') is-invalid @enderror ckeditor"
                                                  name="slider[description_en]"
                                                  rows="10">{{ old('slider[description_en]') ?: ($slider->description_en ?? '') }}</textarea>
                                            @error('slider[description_en]')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputError">@error('phone_number')<i
                                                class="far fa-times-circle"></i>@enderror Հեռախոսահամար</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" required
                                                   class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                                   id="phone_number" name="phone_number"
                                                   value="{{$settings->get('phone_number')}}">
                                        </div>
                                        @error('phone_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="inputError">@error('email')<i
                                                class="far fa-times-circle"></i>@enderror էլ․ հասցե</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" required
                                                   class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                   id="email" name="email" value="{{$settings->get('email')}}">
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="address_am">
                                            @error('address_am')<i class="far fa-times-circle"></i>@enderror Հասցե (հայերեն)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" required
                                                   class="form-control form-control-sm @error('address_am') is-invalid @enderror"
                                                   id="address_am" name="address_am" value="{{$settings->get('address_am')}}">
                                        </div>
                                        @error('address_am')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="address_en">
                                            @error('address_en')<i class="far fa-times-circle"></i>@enderror Հասցե (անգլերեն)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" required
                                                   class="form-control form-control-sm @error('address_en') is-invalid @enderror"
                                                   id="address_en" name="address_en" value="{{$settings->get('address_en')}}">
                                        </div>
                                        @error('address_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="map_address">@error('map_address')<i
                                                class="far fa-times-circle"></i>@enderror Հասցեն քարտեզի վրա</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" required
                                                   class="form-control form-control-sm @error('map_address') is-invalid @enderror"
                                                   id="map_address" name="map_address" value="{{ old('map_address') ?? $settings->get('map_address') }}">
                                        </div>
                                        @error('latitude')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-default btn-outline-secondary float-right green-btn"
                                    form="create-form">Պահպանել փոփոխությունները
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

