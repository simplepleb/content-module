@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} @endsection

@section('content')

<section class="section-header bg-primary text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <div class="mb-2">
                    <a href="{{route('frontend.categories.index')}}" class="badge badge-sm badge-warning text-uppercase px-3">
                        Category
                    </a>
                </div>
                <h1 class="display-2 mb-4">
                    {{$$module_name_singular->name}}
                </h1>
                <p class="lead">
                    {{$$module_name_singular->description}}
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>

<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">

            @foreach ($contents as $content)
            @php
            $details_url = route("frontend.contents.show",[encode_id($content->id), $content->slug]);
            @endphp

            <div class="col-12 col-md-4 mb-4">
                <div class="card bg-white border-light shadow-soft p-4 rounded">
                    <a href="{{$details_url}}"><img src="{{$content->featured_image}}" class="card-img-top" alt=""></a>
                    <div class="card-body p-0 pt-4">
                        <a href="{{$details_url}}" class="h3">{{$content->name}}</a>
                        <div class="d-flex align-items-center my-4">
                            <img class="avatar avatar-sm rounded-circle" src="https://picsum.photos/seed/picsum/50/50" alt="">
                            {!!isset($content->created_by_alias)? $content->created_by_alias : '<a href="'.route('frontend.users.profile', $$module_name_singular->created_by).'"><h6 class="text-muted small ml-2 mb-0">'.$content->created_by_name.'</h6></a>'!!}
                        </div>
                        <p class="mb-3">{{$content->intro}}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="d-flex justify-content-center w-100 mt-3">
            {{$content->links()}}
        </div>
    </div>
</section>

@endsection