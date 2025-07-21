@extends('layouts.frontend.app')

@section('title')
    Profile
@endsection

@section('body')
    <!-- Profile Start -->
    <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
            <!-- User Info Section -->
            <div class="user-info text-center p-3">
                <img src="{{asset(Auth::guard('web')->user()->image)}}" alt="User Image" class="rounded-circle mb-2"
                    style="width: 80px; height: 80px; object-fit: cover" />
                <h5 class="mb-0" style="color: #ff6f61">{{Auth::guard('web')->user()->name}}</h5>   {{--could just be Auth::user()->name  ** by default Auth::guard('web')->user()--}}
            </div>

            <!-- Sidebar Menu -->
            <div class="list-group profile-sidebar-menu">
                <a href="{{route('frontend.dashboard.profile')}}" class="list-group-item list-group-item-action active menu-item"
                    data-section="profile">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a href="./notifications.html" class="list-group-item list-group-item-action menu-item"
                    data-section="notifications">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="{{route('frontend.dashboard.setting')}}" class="list-group-item list-group-item-action menu-item" data-section="settings">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="content-section active">
                <h2>User Profile</h2>
                <div class="user-profile mb-3">
                    <img src="{{asset(Auth::guard('web')->user()->image)}}" alt="User Image" class="profile-img rounded-circle"
                        style="width: 100px; height: 100px;" />
                    <span class="username">{{Auth::guard('web')->user()->username}}</span>
                </div>
                <br>


                {{-- error messages --}}
                @if (session()->has('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <form action="{{route('frontend.dashboard.post.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Add Post Section -->
                <section id="add-post" class="add-post-section mb-5">
                    <h2>Add Post</h2>
                    <div class="post-form p-3 border rounded">
                        <!-- Post Title -->
                        <input name="title" type="text" id="postTitle" class="form-control mb-2" placeholder="Post Title" />

                        <!-- Post Content -->
                        <textarea name="desc" id="postContent" class="form-control mb-2" rows="3" placeholder="What's on your mind?"></textarea>

                        <!-- Image Upload -->
                        <input name="images[]" type="file" id="postImage" class="form-control mb-2" accept="image/*" multiple />
                        <div class="tn-slider mb-2">
                            <div id="imagePreview" class="slick-slider"></div>
                        </div>

                        <!-- Category Dropdown -->
                        <select name="category_id" id="postCategory" class="form-select mb-2">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select><br>

                        <!-- Enable Comments Checkbox -->
                        <label class="label">
                            Enable Comments: <input name="comment_able" type="checkbox" class="" /> Enable Comments
                        </label><br>

                        <!-- Post Button -->
                        <button type="submit" class="btn btn-primary post-btn">Post</button>
                    </div>
                </section>
            </form>



                <!-- show posts -->
                <section id="posts" class="posts-section">
                    <h2>Recent Posts</h2>
                    <div class="post-list">
                        <!-- Post Item -->
                        @forelse ($posts as $post)
                            <div class="post-item mb-4 p-3 border rounded">
                            <div class="post-header d-flex align-items-center mb-2">
                                <img src="{{asset($post->user->image)}}" alt="User Image" class="rounded-circle"
                                    style="width: 50px; height: 50px;" />
                                <div class="ms-3">
                                    <h5 class="mb-0">{{$post->user->name}}</h5>
                                    <small class="text-muted">{{ $post->created_at}}</small>
                                </div>
                            </div>
                            <h4 class="post-title">{{$post->title}}</h4>
                            <p class="post-content">{!! chunk_split($post->desc, 30) !!}</p>

                            <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#newsCarousel" data-slide-to="1"></li>
                                    <li data-target="#newsCarousel" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ($post->images as  $image)
                                        <div class="carousel-item  @if ($loop->first) active @endif">
                                        <img src="{{ asset($image->path)}}" class="d-block w-100" alt="First Slide">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $post->title }}</h5>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- Add more carousel-item blocks for additional slides -->
                                </div>

                                <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                            <div class="post-actions d-flex justify-content-between">
                                <div class="post-stats">
                                    <!-- View Count -->
                                    <span class="me-3">
                                        <i class="fas fa-eye"></i> 123 views
                                    </span>
                                </div>

                                <div>
                                    <a href="{{route('frontend.dashboard.post.edit', $post->slug)}}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="javascript:void(0);" onclick="if(confirm('Are you sure you want to delete this post?')) document.getElementById('deleteForm_{{$post->id}}').submit()" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-thumbs-up"></i> Delete
                                    </a>

                                    <button id="commentbtn_{{$post->id}}" class="getComments" post-id = "{{$post->id}}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-comment"></i> Comments
                                    </button>

                                    <button id="hidecommentsbtn_{{$post->id}}" style="display: none" class="hideComments" post-id = "{{$post->id}}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-comment"></i> Hide Comments
                                    </button>

                                    <form id="deleteForm_{{$post->id}}" action="{{route('frontend.dashboard.post.delete')}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input hidden name="post_id" type="text" value="{{$post->id}}">
                                    </form>

                                </div>
                            </div>

                            <!-- Display Comments -->
                            <div id="displayComments_{{$post->id}}" class="comments">
                                <div class="comment">
                                    <img src="" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username"></span>
                                        <p class="comment-text">first comment</p>
                                    </div>
                                </div>
                                <!-- Add more comments here for demonstration -->
                            </div>
                        </div>

                        @empty
                            <div>
                                <p>No posts found.</p>
                            </div>
                        @endforelse

                        <!-- Add more posts here dynamically -->
                    </div>
                </section>
            </section>
        </div>
    </div>
    <!-- Profile End -->
@endsection

@push('js')
    <script>
        // Add your JavaScript code here
        $(function() {
            $('#postImage').fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                enableResumableUpload: false,
                showUpload: false
            });
            $('#postContent').summernote({
                height: 300,
            });
        });

        //get post comments
        $(document).on('click', '.getComments', function(e) {
            e.preventDefault();
            var postId = $(this).attr('post-id');
            var url = "{{ route('frontend.dashboard.post.getComments', ':postId') }}";
            url = url.replace(':postId', postId);

            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    let commentsContainer = $('#displayComments_' + postId);
                    commentsContainer.show();
                    commentsContainer.empty(); // Clear previous comments

                    response.comments.forEach(comment => {
                        let commentHtml = `
                            <div class="comment">
                                <img src="${comment.user.image}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${comment.user.name}</span>
                                    <p class="comment-text">${comment.comment}</p>
                                </div>
                            </div>
                        `;
                        commentsContainer.append(commentHtml);
                    });
                    $('#commentbtn_' + postId).hide();
                    $('#hidecommentsbtn_' + postId).show();
                }
            });
        });

        //hide comments
                $(document).on('click', '.hideComments', function(e) {
                    e.preventDefault();
                    var postId = $(this).attr('post-id');
                    $('#displayComments_' + postId).hide();
                    $('#commentbtn_' + postId).show();
                    $('#hidecommentsbtn_' + postId).hide();
                });

    </script>
@endpush
