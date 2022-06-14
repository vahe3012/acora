@extends('layouts.front')

@section('content')
    <div class="page-content report">
        <div class="page-title-box">
            <h1>{{ __('main.reports.title') }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 tab-btn-box">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($reports as $i => $report)
                            <a class="nav-link {{ $i == 0 ? 'active' : '' }}" id="v-pills-{{ $i }}-tab" data-toggle="pill" href="#v-pills-{{ $i }}"
                               role="tab" aria-controls="v-pills-{{ $i }}" aria-selected="{{ $i == 0 ? 'true' : '' }}">
                                <span>{{ translate($report, 'title') }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($reports as $i => $report)
                            <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="v-pills-{{ $i }}" role="tabpanel" aria-labelledby="v-pills-{{ $i }}-tab">
                                <h2>{{ translate($report, 'title') }}</h2>
                                <p>{!! html_entity_decode(translate($report, 'description')) !!}</p>

                                @if($report->attachments)
                                    @foreach($report->attachments as $index => $attachment)
                                        <div class="accordion" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="heading_{{ $index }}">
                                                    <h2 class="mb-0">
                                                        <a class="btn  btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse_{{ $index }}"
                                                                aria-expanded="true" aria-controls="collapse_{{ $index }}">
                                                            {{ $attachment->folder }}
                                                        </a>
                                                    </h2>
                                                </div>

                                                <div id="collapse_{{ $index }}" class="collapse {{ $index == 0 ? 'show' : ''}}" aria-labelledby="heading_{{ $index }}" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        @foreach($report->getAttachments($attachment) as $item)
                                                            <div class="reports-file-content-box">
                                                                <a href="{{ $item->urls['original'] }}" target="_blank">
                                                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M17.508 4.41406H12.1377C9.71024 4.41406 8.49651 4.41406 7.7424 5.16818C6.98828 5.92229 6.98828 7.13603 6.98828 9.56349V22.4371C6.98828 24.8645
                                                                            6.98828 26.0782 7.7424 26.8324C8.49651 27.5865 9.71024 27.5865 12.1377 27.5865H19.8618C22.2893 27.5865 23.503 27.5865 24.2572 26.8324C25.0113 26.0782
                                                                            25.0113 24.8645 25.0113 22.4371V11.9173C25.0113 11.3911 25.0113 11.128 24.9133 10.8914C24.8153 10.6549 24.6292 10.4688 24.2572 10.0967L19.3286 5.16818C18.9565
                                                                            4.79609 18.7705 4.61005 18.5339 4.51206C18.2973 4.41406 18.0342 4.41406 17.508 4.41406Z" stroke="#001489" stroke-width="2"/>
                                                                        <path d="M12.1377 17.2871L19.8618 17.2871" stroke="#FF9E1B" stroke-width="2" stroke-linecap="round"/>
                                                                        <path d="M12.1377 22.4365L17.2871 22.4365" stroke="#FF9E1B" stroke-width="2" stroke-linecap="round"/>
                                                                        <path d="M17.2871 4.41406V9.56349C17.2871 10.7772 17.2871 11.3841 17.6642 11.7611C18.0412 12.1382 18.6481 12.1382 19.8618 12.1382H25.0112" stroke="#001489" stroke-width="2"/>
                                                                    </svg>
                                                                    <h5>{{ $item->name }}</h5>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


