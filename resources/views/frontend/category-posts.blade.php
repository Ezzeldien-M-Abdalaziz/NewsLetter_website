{{-- @extends('layouts.frontend.app')

@section('body')
<!-- Main News Start-->
      <div class="main-news">
        <div class="container">
          <div class="row">
            <div class="col-lg-9">
              <div class="row">

                @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="mn-img">
                      <img src="{{$post->images->first()->path}}" />
                      <div class="mn-title">
                        <a href="">{{$post->title}}</a>
                      </div>
                    </div>
                  </div>
                @endforeach
               {{$posts->links()}}

              </div>
            </div>

            <div class="col-lg-3">
              <div class="mn-list">
                <h2>Other Categories</h2>
                <ul>
                    @foreach ($read_more_posts as $post )
                      <li><a href="">{{$post->title}}</a></li>
                    @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Main News End-->
@endsection --}}
