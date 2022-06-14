<div class="col-md-3 col-sm-4 border border-5 mb-3 ml-2 p-2 file-folder" data-index="{{ $index }}">
    <div class="form-group">
        <label for="attachments[{{ $index }}][folder]">Ֆայլի անուն</label>
        <input type="text" class="form-control" id="attachments[{{ $index }}][folder]" name="attachments[{{ $index }}][folder]"
               value="{{ old('attachments['.$index.'][folder]') ?? (isset($attachment) ? $attachment->folder : '') }}">
    </div>
    <div class="form-group d-inline-block files-am">
        <label for="attachments[{{ $index }}][files_am]" class="mr-3">Ֆայլեր (հայերեն)</label>
        <div class="input-group">
            <media-uploader
                prop-input-name="attachments[{{ $index }}][files_am]"
                prop-button="Ընտրեք Ֆայլեր"
                :prop-multiple="true"
                prop-format="pdf"
                :prop-selected-attachments="{{ json_encode(isset($attachment) ? \App\Models\Attachment::whereIn('id', $attachment->files_am)->get() : []) }}"
            ></media-uploader>
        </div>
    </div>
    <div class="form-group d-inline-block files-en">
        <label for="attachments[{{ $index }}][files_en]" class="mr-3">Ֆայլեր (անգլերեն)</label>
        <div class="input-group">
            <media-uploader
                prop-input-name="attachments[{{ $index }}][files_en]"
                prop-button="Ընտրեք Ֆայլեր"
                :prop-multiple="true"
                prop-format="pdf"
                :prop-selected-attachments="{{ json_encode(isset($attachment) ? \App\Models\Attachment::whereIn('id', $attachment->files_en)->get() : []) }}"
            ></media-uploader>
        </div>
    </div>
</div>
