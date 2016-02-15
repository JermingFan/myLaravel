@extends('components.base')
@section('content')

    <div class="container">
        <div class="shared-hosting">
            <h3 class="header-c">Shared Hosting</h3>
            <figure class="float-right"><img src="images/570x330.jpg" alt="Placeholder"></figure>
            <p>{{ $project->intro }}</p>
            <ul class="list-check">
                <li>Proin consectetur lacus malesuada urna congue bibendum posuere eu lacus.</li>
                <li>Donec malesuada nunc vel varius suscipit.</li>
                <li>In nec urna volutpat, viverra enim id, tincidunt massa.</li>
                <li>Duis at elit sit amet mauris convallis lobortis.</li>
            </ul>
        </div>
    </div>
    <div class="about-quote">
        <div class="col-md-6 abt-quote">
            <h5>Success is a science; if you have the conditions, you get the result.</h5>
            <span>Oscar Wilde</span>
        </div>
    </div>

@endsection
