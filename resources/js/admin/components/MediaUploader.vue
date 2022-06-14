<style>
.modal-body {
    min-height: 750px;
}
.media-item.active img,
.media-item.active video{
    border: 4px solid #007bff;
}
.modal-dialog {
    max-width: 1229px;
}
.media-item {
    /*padding: 10px;*/
    cursor: pointer;
}
.media-container {
    margin-left: 0;
    margin-right: 0;
}
.image-item, .add-image-item {
    border: 2px solid lightgray;
    width: 80px;
    position: relative;
    cursor: pointer;
}

.add-image-item.full {
    width: 100%;
}

.image-item:hover .remove-item, .add-image-item:hover .remove-item {
    display: block;
}

.image-item img, .add-image-item img {
    width: 100%;
}
.remove-item {
    color: #17a2b8;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-align: center;
    line-height: 75px;
    font-size: 26px;
    font-weight: 400;
    cursor: pointer;
    display: none;
}
</style>
<template>
    <div :style="propMultiple ? 'border: 1px solid gray;padding: 8px;border-radius: 4px; margin-bottom: 20px' : ''">
        <div class="row" v-if="propMultiple">
            <div class="image-item mb-2" v-for="(attachment, index) in selectedAttachments">
                <input type="hidden" :name="`${propInputName}${propMultiple ? '[]' : ''}`" :value="attachment ? attachment.id : ''"/>
                <video v-if="attachment && ['mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'].includes(attachment.format)" width="80" :alt="attachment.alt" :src="attachment.urls.original"></video>
                <img loading="lazy"  v-if="attachment && attachment.format !== 'pdf' && !['mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'].includes(attachment.format)" :alt="attachment.alt" :src="attachment.urls.m"/>
                <img loading="lazy"  v-if="attachment && attachment.format === 'pdf'" :alt="attachment.alt" :src="'/images/pdf.png'"/>
                <span class="remove-item" v-on:click="selectedAttachments.splice(index, 1)"><i class="fas fa-trash"></i></span>
            </div>
        </div>
        <a
            v-if="propMultiple"
            v-on:click="openModal"
            class="btn btn-primary"
        >
            {{ propButton }}
        </a>
        <div
            v-if="!propMultiple"
            v-on:click="() => { selectedAttachments[0] ? selectedAttachments.splice(0, 1) : openModal()}"
            class="add-image-item" :class="propSize"
        >
            <video v-if="selectedAttachments[0] && ['mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'].includes(selectedAttachments[0].format)" width="80" :alt="selectedAttachments[0].alt" :src="selectedAttachments[0].urls.original"></video>
            <input type="hidden" :name="`${propInputName}`" :value="selectedAttachments[0] ? selectedAttachments[0].id : ''"/>
            <img loading="lazy"  v-if="selectedAttachments[0] && selectedAttachments[0].format !== 'pdf' && !['mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'].includes(selectedAttachments[0].format)" :alt="selectedAttachments[0].alt" :src="selectedAttachments[0].urls.m"/>
            <img loading="lazy"  v-if="selectedAttachments[0] && selectedAttachments[0].format === 'pdf'" :alt="selectedAttachments[0].alt" :src="'/images/pdf.png'"/>
            <img loading="lazy"  v-if="!selectedAttachments[0]" src="/images/upload.png"/>
            <span v-if="selectedAttachments[0]" class="remove-item"><i class="fas fa-trash"></i></span>
        </div>
        <div class="modal fade show" style="display: block; padding-right: 17px;" id="modal-xl" v-if="modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ֆայլեր</h4>
                        <button type="button" class="close" v-on:click="modal=false" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" v-on:click="chooseFile">Ընտրել ֆայլ</button>
                                <input type='file' id="getFile" class="d-none" @change="uploadFile" multiple>
                                <span class="selected-file-name">Ֆայլ ընտրված չէ</span>
                            </div>
                            <div class="mt-4 col-12 media-container">
                                <div class="row">
                                    <div class="mt-1 col-3 media-item" v-for="(item, index) in files" v-bind:key="index + item.size">
                                        <img loading="lazy"  width="150" height="90" style="opacity: 0.5" :src="item.preview">
                                    </div>
                                    <div v-for="(item, index) in attachments" class="mt-1 col-3">
                                        <div v-bind:key="item.id" v-on:click="selectFile(item)" class="media-item" v-bind:class="{ active: isSelected(item) }">
                                            <video v-if="item && ['mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'].includes(item.format)" width="150" :alt="item.alt" :src="item.urls.original"></video>
                                            <img loading="lazy" v-if="item.format !== 'pdf' && !['mp4', 'avi', 'flv', 'mov', 'wmv', '3gp', 'ts', 'm3u8'].includes(item.format)" width="150" height="90" :src="item.urls.m">
                                            <img loading="lazy" v-if="item.format === 'pdf'" width="150" height="90" :src="'/images/pdf.png'"/>
                                            <div v-if="item.format === 'pdf'">{{item.name || 'pdf'}}</div>
                                        </div>
                                        <p class="mt-1"><a href="javascript:;" v-on:click="deleteFile(item, index)" class="btn btn-danger">Ջնջել</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <ul class="pagination pagination-sm mt-3 float-left">
                            <li class="page-item" v-if="pageCount >= 7 && filters.page > 4">
                                <a class="page-link" @click="filters.page = 1;applyFilters()">
                                    &laquo;
                                </a>
                            </li>
                            <li v-for="page of pages" v-if="pageCount !== 1" :key="page" v-bind:class="{ active: filters.page === page }" class="page-item">
                                <a class="page-link" @click="filters.page = page;applyFilters()">{{ page }}</a>
                            </li>

                            <li class="page-item" v-if="pageCount >= 7 && (pageCount - filters.page) > 4">
                                <a class="page-link" @click="filters.page = pageCount;applyFilters()">
                                    &raquo;
                                </a>
                            </li>
                        </ul>
                        <a class="btn btn-success" v-on:click="attachFiles()">Փակել</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div v-if="modal" class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
export default {
    name: 'media-uploader',
    props: {
        propInputName: {
            type: String,
            default: 'attachment'
        },
        propSize: {
            type: String,
            default: 'small'
        },
        propButton: {
            type: String,
            default: 'Attach Media'
        },
        propMultiple: {
            type: Boolean,
            default: false
        },
        propSelectedAttachments: {
            type: Array,
            default: () => ([])
        },
        propFormat: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            modal: false,
            files: [],
            attachments: [],
            selectedAttachments: this.propSelectedAttachments.filter(i => i),
            total: this.propTotal,
            pageCount: 0,
            pages: [],
            filters: {
                perPage: 16,
                page: 1,
                search: '',
            }
        }
    },
    methods: {
        openModal() {
            this.applyFilters()
            this.modal = true
        },
        isSelected(item) {
            return !!this.selectedAttachments.find(i => i.id === item.id)
        },
        selectFile(selected) {
            if (this.propFormat) {
                if (selected.format !== this.propFormat) {
                    toastr.error('Тhe file can only be in "pdf" format!', 'Something went wrong', {timeOut: 20000})
                    return false
                }
            }

            const isSelected = !!this.selectedAttachments.find(item => item.id === selected.id)

            if(isSelected) {
                this.selectedAttachments = this.selectedAttachments.filter(item => item.id !== selected.id)
            } else {
                if(this.propMultiple) {
                    this.selectedAttachments.push(selected)
                } else {
                    this.selectedAttachments = [selected]
                }
            }

            if(!this.propMultiple) {
                this.modal = false
            }
        },
        chooseFile(event) {
            event.preventDefault()
            document.getElementById('getFile').click()
        },
        async deleteFile(selected, index) {
            try {
                const {data} = await axios.post('/admin/delete-file/' + selected.id)

                if (!data.success) {
                    toastr.error(data.message, 'Something went wrong', {timeOut: 20000})
                    return false
                }

                this.attachments.splice(index, 1)
            } catch (e) {
                console.error('ERROR: ', e)
            }
        },
        attachFiles() {
            this.modal = false
        },
        toBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = () => resolve(reader.result)
                reader.onerror = error => reject(error)
            })
        },
        async prepareFileToUpload(files) {
            const promises = []
            Object.values(files).map(file => {
                promises.push((async () => {
                    file.preview = await this.toBase64(file)
                    return file
                })())
            })

            return await Promise.all(promises)
        },
        async uploadFile(event) {
            const newFiles = await this.prepareFileToUpload(event.target.files)
            let selectedFiles

            if (newFiles.length > 1) {
                selectedFiles = []

                for (let file of newFiles) {
                    selectedFiles.push(file.name)
                }

                selectedFiles = selectedFiles.join(', ')
            } else {
                selectedFiles = newFiles[0].name
            }

            document.querySelector('.selected-file-name').innerText = selectedFiles

            this.files = [...newFiles, ...this.files]

            const iterate = async () => {
                const formData = new FormData()

                if(!this.files.length) {return}

                formData.append('attachment', this.files.splice(0, 1)[0])

                try{
                    const { data } = await axios.post('/admin/upload-file', formData)
                    if(!data || !data.item) {return}

                    this.attachments = [...[data.item], ...this.attachments]
                } catch (e) {console.error('ERROR: ', e)}

                if(this.files.length) {
                    await iterate()
                }
            }

            await iterate()
            await this.applyFilters()
        },
        async applyFilters(){
            const url = new URL(window.location.origin + '/admin/attachments')
            const params = url.searchParams

            Object.keys(this.filters).map(key => {
                if(this.filters[key]) {
                    params.set(key, this.filters[key])
                } else {
                    params.delete(key)
                }
            })

            url.search = params.toString()
            const newUrl = url.toString()

            const {data} = await axios.get(newUrl)
            this.attachments = data.items

            this.total = data.total

            this.renderPagination()
        },
        renderPagination() {
            this.pageCount = Math.ceil(this.total / this.filters.perPage);
            this.pages = [];
            const pages = this.pageCount >= 7 ? 7 : this.pageCount;

            let pageOffset = this.filters.page > 4 ? this.filters.page - 4 : 0;

            pageOffset = (this.pageCount - this.filters.page) < 4 ? this.pageCount - 7 : pageOffset;

            if (pages < 7) {
                for (let i = 1; i <= this.pageCount; i++) {
                    this.pages.push(i);
                }
            }else {
                for (let i = (1 + pageOffset); i <= (pages + pageOffset); i++) {
                    this.pages.push(i);
                }
            }
        }
    }
}
</script>
