<form id="create-form" style="width: 100%;" action="{{ $action }}" method="post" enctype="multipart/form-data">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="active" class="col-form-label mr-3">Գործընկեր</label>
                            <input class="form-control @error('is_partner') is-invalid @enderror"
                                   id="active" @if(isset($partner) && !$partner->is_partner) @else checked @endif type="checkbox"
                                   name="is_partner" value="1" placeholder="active"
                                   data-bootstrap-switch
                                   data-off-color="danger" data-on-color="success">
                            @error('is_partner')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label class="col-form-label" for="title_am">@error('title_am')<i
                                            class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                       id="title_am" name="title_am" value="{{ old('title_am') ?: (isset($partner) ? $partner->title_am : '') }}">
                                @error('title_am')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="title_en">@error('title_en')<i
                                            class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('title_en') is-invalid @enderror"
                                       id="title_en" name="title_en" value="{{ old('title_en') ?: (isset($partner) ? $partner->title_en : '') }}">
                                @error('title_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                                <div class="input-group-sm">
                                <textarea id="description_am" class="form-control @error('description_am') is-invalid @enderror ckeditor"
                                          name="description_am" rows="10">{{ old('description_am') ?: (isset($partner) ? $partner->description_am : '') }}</textarea>
                                    @error('description_am')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                                <div class="input-group-sm">
                                <textarea id="description_en" class="form-control @error('description_en') is-invalid @enderror ckeditor"
                                          name="description_en" rows="10">{{ old('description_en') ?: (isset($partner) ? $partner->description_en : '') }}</textarea>
                                    @error('description_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    prop-input-name="image_id"
                                                    prop-size="full"
                                                    class="@error('image_id') is-invalid @enderror"
                                                    :prop-selected-attachments="{{ json_encode(old('image_id') ? \App\Models\Attachment::where('id', old('image_id'))->get() : (isset($partner) ? [$partner->image] : []))}}"
                                                ></media-uploader>
                                                @error('image_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
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
@section('scripts')
    <script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("body").on('click', '.card-header .cart-header-actions', function (event) {
                event.stopPropagation();
            });

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        });
    </script>
@endsection
