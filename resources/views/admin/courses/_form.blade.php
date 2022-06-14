<form id="create-form" style="width: 100%;" action="{{ $action }}" method="post">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group col">
                            <label for="active" class="col-form-label">Գլխավոր</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input  @error('is_main') is-invalid @enderror" @if(isset($course) && $course->is_main) checked @endif type="radio" id="yes" value="1" name="is_main">
                                    <label for="yes" class="custom-control-label">Այո</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input  @error('is_main') is-invalid @enderror" @if(isset($course) && !$course->is_main) checked @endif type="radio" id="no" value="0" name="is_main">
                                    <label for="no" class="custom-control-label">Ոչ</label>
                                </div>

                            @error('is_main')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-9">
                            <label class="col-form-label" for="title_am">@error('title_am')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)</label>
                            <input type="text"
                                   class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                   id="title_am" name="title_am" value="{{ old('title_am') ?: (isset($course) ? $course->title_am : '') }}">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-9">
                            <label class="col-form-label" for="title_en">@error('title_en')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)</label>
                            <input type="text"
                                   class="form-control form-control-sm @error('title') is-invalid @enderror"
                                   id="title_en" name="title_en" value="{{ old('title_en') ?: (isset($course) ? $course->title_en : '') }}">
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                            <div class="input-group-sm">
                                <textarea id="description_am" class="form-control @error('description_am') is-invalid @enderror"
                                          name="description_am" rows="10">{{ old('description_am') ?: (isset($course) ? $course->description_am : '') }}</textarea>
                                @error('description_am')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                            <div class="input-group-sm">
                                <textarea id="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                          name="description_en" rows="10">{{ old('description_en') ?: (isset($course) ? $course->description_en : '') }}</textarea>
                                @error('description_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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
