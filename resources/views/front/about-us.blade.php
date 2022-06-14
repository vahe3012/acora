@extends('layouts.front')

@section('content')
    <div class="page-content about-us">
        <div class="page-title-box">
            <h1>{{ __('main.about.title') }}</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 tab-btn-box">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($links as $i => $link)
                            <a class="nav-link {{ $i == 0 ? 'active' : '' }}" id="v-pills-{{ $i }}-tab"
                               data-toggle="pill" href="#v-pills-{{ $i }}"
                               role="tab" aria-controls="v-pills-{{ $i }}" aria-selected="{{ $i == 0 ? 'true' : '' }}">
                                <span>{{ __('main.about.links.' . $link) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        @if(!empty($aboutContent))
                            @foreach($links as $i => $link)
                                <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="v-pills-{{ $i }}"
                                     role="tabpanel" aria-labelledby="v-pills-{{ $i }}-tab">
                                    @if($link == 'founding_documents' && isset($aboutContent['founding_documents']))
                                        <a class="basic-document-box"
                                           href="{{ \App\Models\Attachment::where('id', $aboutContent['founding_documents']['attachment_id'])->first()->urls['original'] }}"
                                           target="_blank">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.508 4.41406H12.1377C9.71024 4.41406 8.49651 4.41406 7.7424 5.16818C6.98828 5.92229 6.98828 7.13603 6.98828 9.56349V22.4371C6.98828 24.8645 6.98828 26.0782 7.7424 26.8324C8.49651 27.5865 9.71024 27.5865 12.1377 27.5865H19.8618C22.2893 27.5865 23.503 27.5865 24.2572 26.8324C25.0113 26.0782 25.0113 24.8645 25.0113 22.4371V11.9173C25.0113 11.3911 25.0113 11.128 24.9133 10.8914C24.8153 10.6549 24.6292 10.4688 24.2572 10.0967L19.3286 5.16818C18.9565 4.79609 18.7705 4.61005 18.5339 4.51206C18.2973 4.41406 18.0342 4.41406 17.508 4.41406Z"
                                                    stroke="#001489" stroke-width="2"/>
                                                <path d="M12.1377 17.2871L19.8618 17.2871" stroke="#FF9E1B"
                                                      stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12.1377 22.4365L17.2871 22.4365" stroke="#FF9E1B"
                                                      stroke-width="2" stroke-linecap="round"/>
                                                <path
                                                    d="M17.2871 4.41406V9.56349C17.2871 10.7772 17.2871 11.3841 17.6642 11.7611C18.0412 12.1382 18.6481 12.1382 19.8618 12.1382H25.0112"
                                                    stroke="#001489" stroke-width="2"/>
                                            </svg>
                                            <h3 class="d-inline-block">{{ $aboutContent['founding_documents']['attachment_title_' . App::getLocale()] }}</h3>
                                        </a>
                                    @elseif(isset($aboutContent[$link .  '_' . App::getLocale()]))
                                        <p>{!! $aboutContent[$link .  '_' . App::getLocale()] !!}</p>
                                    @else
                                        @switch($link)
                                            @case('partners')
                                            @foreach($partners as $partner)
                                                <div class='row align-items-start'>
                                                    <img width="100" src="{{ $partner->image->urls['original'] }}"
                                                         alt="" class='col-sm-3'>
                                                    <div class='col-sm-9'>
                                                        <p class='mb-0 font-weight-bold'>{{ translate($partner, 'title') }}</p>
                                                        {!! translate($partner, 'description') !!}
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                            @break

                                            @case('members')
                                            @foreach($members as $member)
                                                <div class='row align-items-start'>
                                                    <img width="100" src="{{ $member->image->urls['original'] }}" alt=""
                                                         class='col-sm-3'>
                                                    <div class="col-sm-9">
                                                        <p class='mb-0 font-weight-bold'>{{ translate($member, 'title') }}</p>
                                                        {!! translate($member, 'description') !!}
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                            @break

                                            @case('branches')
                                                <p>ՀՀ ՎԿԱ անդամներն ունեն մասնաճյուղերի և ներկայացուցչությունների լայն ցանց
                                                    Երևանում, ՀՀ բոլոր մարզերում, ինչպես նաև Լեռնային Ղարաբաղի
                                                    Հանրապետությունում:</p>
                                            @break

                                            @case('staff')
                                            @foreach($staffs as $staff)
                                                <div class='row align-items-start staff-box'>
                                                    <img width="100" src="{{ $staff->attachment->urls['original'] }}" alt=""
                                                         class='col-sm-3'>
                                                    <div class="col-sm-9">
                                                        <p class='mb-0 font-weight-bold'>{{ translate($staff, 'fullname') }}</p>
                                                        <p class='mb-0 font-italic'>{{ translate($staff, 'position') }}</p>
                                                        {!! translate($staff, 'description') !!}
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                            @break
                                        @endswitch
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
