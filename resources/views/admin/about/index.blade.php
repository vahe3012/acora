@extends('layouts.admin')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Մեր մասին</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.settings.index')}}">Գլխավոր</a></li>
                            <li class="breadcrumb-item active">Մեր մասին</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <form id="create-form" style="width: 100%;" action="{{ route('admin.about.store') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title"><b>Փոխել Մեր մասին էջը</b></h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="activity_am">@error('activity_am')<i class="far fa-times-circle"></i>@enderrorԳործունեությունը (հայերեն)</label>
                                        <textarea name="activity_am" id="activity_am" cols="30" rows="10" class="form-control ckeditor @error('activity_am') is-invalid @enderror">
                                            {{ old('activity_am') ?: (!empty($aboutContent) ? $aboutContent['activity_am'] : '') }}
                                        </textarea>
                                        @error('activity_am')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="activity_en">@error('activity_en')<i class="far fa-times-circle"></i>@enderrorԳործունեությունը (անգլերեն)</label>
                                        <textarea name="activity_en" id="activity_en" cols="30" rows="10" class="form-control ckeditor @error('activity_en') is-invalid @enderror">
                                            {{ old('activity_en') ?: (!empty($aboutContent) ? $aboutContent['activity_en'] : '') }}
                                        </textarea>
                                        @error('activity_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objectives_am">@error('objectives_am')<i class="far fa-times-circle"></i>@enderrorՆպատակները (հայերեն)</label>
                                        <textarea name="objectives_am" id="objectives_am" cols="30" rows="10" class="form-control ckeditor @error('objectives_am') is-invalid @enderror">
                                            {{ old('objectives_am') ?: (!empty($aboutContent) ? $aboutContent['objectives_am'] : '') }}
                                        </textarea>
                                        @error('objectives_am')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objectives_en">@error('objectives_en')<i class="far fa-times-circle"></i>@enderrorՆպատակները (անգլերեն)</label>
                                        <textarea name="objectives_en" id="objectives_en" cols="30" rows="10" class="form-control ckeditor @error('objectives_en') is-invalid @enderror">
                                            {{ old('objectives_en') ?: (!empty($aboutContent) ? $aboutContent['objectives_en'] : '') }}
                                        </textarea>
                                        @error('objectives_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="management_am">@error('management_am')<i class="far fa-times-circle"></i>@enderrorԿառավարում (հայերեն)</label>
                                        <textarea name="management_am" id="management_am" cols="30" rows="10" class="form-control ckeditor @error('management_am') is-invalid @enderror">
                                            {{ old('management_am') ?: (!empty($aboutContent) ? $aboutContent['management_am'] : '') }}
                                        </textarea>
                                        @error('management_am')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="management_en">@error('management_en')<i class="far fa-times-circle"></i>@enderrorԿառավարում (անգլերեն)</label>
                                        <textarea name="management_en" id="management_en" cols="30" rows="10" class="form-control ckeditor @error('management_en') is-invalid @enderror">
                                            {{ old('management_en') ?: (!empty($aboutContent) ? $aboutContent['management_en'] : '') }}
                                        </textarea>
                                        @error('management_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="history_am">@error('history_am')<i class="far fa-times-circle"></i>@enderrorՊատմություն (հայերեն)</label>
                                        <textarea name="history_am" id="history_am" cols="30" rows="10" class="form-control ckeditor @error('history_am') is-invalid @enderror">
                                            {{ old('history_am') ?: (!empty($aboutContent) ? $aboutContent['history_am'] : '') }}
                                        </textarea>
                                        @error('history_am')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="history_en">@error('history_en')<i class="far fa-times-circle"></i>@enderrorՊատմություն (անգլերեն)</label>
                                        <textarea name="history_en" id="history_en" cols="30" rows="10" class="form-control ckeditor @error('history_en') is-invalid @enderror">
                                            {{ old('history_en') ?: (!empty($aboutContent) ? $aboutContent['history_en'] : '') }}
                                        </textarea>
                                        @error('history_en')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card card-default">
                                        <div class="card-header" data-card-widget="collapse">
                                            <div class="card-title">
                                                Հիմնադիր փաստաթղթեր
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 p-0">
                                                    <media-uploader
                                                        prop-input-name="founding_documents[attachment_id]"
                                                        prop-size="full"
                                                        prop-format="pdf"
                                                        @error('attachment_id') class="is-invalid" @enderror
                                                        :prop-selected-attachments="{{ json_encode(old('attachment_id') ? \App\Models\Attachment::where('id', old('attachment_id'))->get() : (!empty($aboutContent) ? \App\Models\Attachment::where('id', $aboutContent['founding_documents']['attachment_id'])->get() : []))}}"
                                                    ></media-uploader>
                                                    @error('attachment_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="attachment_title_am">@error('founding_documents[attachment_title_am]')
                                            <i class="far fa-times-circle"></i>@enderrorՓաստաթղթի անվանումը (հայերեն)</label>
                                        <input type="text" id="attachment_title_am"
                                               name="founding_documents[attachment_title_am]" class="form-control"
                                               value="{{ old('founding_documents[attachment_title_am]') ?: (!empty($aboutContent) ? $aboutContent['founding_documents']['attachment_title_am'] : '') }}">
                                        @error('founding_documents[attachment_title_am]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="attachment_title_en">@error('founding_documents[attachment_title_en]')
                                            <i class="far fa-times-circle"></i>@enderrorՓաստաթղթի անվանումը (անգլերեն)</label>
                                        <input type="text" id="attachment_title_en"
                                               name="founding_documents[attachment_title_en]" class="form-control"
                                               value="{{ old('founding_documents[attachment_title_en]') ?: (!empty($aboutContent) ? $aboutContent['founding_documents']['attachment_title_en'] : '') }}">
                                        @error('founding_documents[attachment_title_en]')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right"
                                    form="create-form">Պահպանել փոփոխությունները
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

