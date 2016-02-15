@extends('components.base')
@section('content')

    <div class="plans">
        <div class="container">

            @foreach ($projects as $project)
                <div id="testimonialWrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-1 col-md-offset-1">
                                <img id="testimonialPicture" src="/assets/images/b1.jpg" >
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <h2>{{ $project->name }}</h2>
                                <h3>{{ $project->intro }}</h3>
                                <a href="{{ URL('project/'.$project->id) }}" >更多</a>
                            </div>
                            <div class="col-md-3">
                                <h2>zzz</h2>
                                <h3>aaa</h3>
                                <a href="#">Lorem ipsum - www.google.com</a>
                                <a href="#">Enter Live Chart</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{$projects->render()}}
        </div>
    </div>

@endsection
