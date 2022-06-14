<form id="create-form" style="width: 100%;" action="{{ $action }}" method="post">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <input type="hidden" value="{{ session()->get('lawType') }}" name="type">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group col-9">
                            <label class="col-form-label" for="title_am">@error('title_am')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)
                            </label>
                            <input type="text"
                                   class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                   id="title_am" name="title_am" value="{{ old('title_am') ?: (isset($law) ? $law->title_am : '') }}">
                            @error('title_am')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-9">
                            <label class="col-form-label" for="title_en">@error('title_en')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)
                            </label>
                            <input type="text"
                                   class="form-control form-control-sm @error('title_en') is-invalid @enderror"
                                   id="title_en" name="title_en" value="{{ old('title_en') ?: (isset($law) ? $law->title_en : '') }}">
                            @error('title_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(session()->get('lawType') == \App\Models\Law::TYPE_LAW)
                            <div class="form-group col-9">
                                <label class="col-form-label" for="link">Հղում</label>
                                <input type="text" id="link" class="form-control form-control-sm @error('link') is-invalid @enderror"
                                       name="link" value="{{ old('link') ?: (isset($law) ? $law->link : '') }}">
                                @error('link')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @elseif(session()->get('lawType') == \App\Models\Law::TYPE_REGULATION)
                            <div class="row">
                                <div class="col-6">
                                    <div class="card card-default">
                                        <div class="card-header" data-card-widget="collapse">
                                            <div class="card-title">
                                                Ֆայլ
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 p-0">
                                                    <media-uploader
                                                        prop-input-name="attachment_id"
                                                        prop-size="medium"
                                                        @error('attachment_id') class="is-invalid" @enderror
                                                        :prop-selected-attachments="{{ json_encode(old('attachment_id') ? \App\Models\Attachment::where('id', old('attachment_id'))->get() : (isset($law) ? [$law->attachment] : []))}}"
                                                    ></media-uploader>
                                                    @error('attachment_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-default green-btn btn-outline-success float-right" form="create-form">Պահպանել</button>
                    <button id="reset-form" onclick="document.getElementById('create-form').reset()"
                            class="btn btn-default" type="reset">Վերակայել
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
