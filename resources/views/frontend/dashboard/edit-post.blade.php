@extends('layouts.frontend.app')

@section('title')
    Edit: {{$post->title}}
@endsection

@section('body')

<div class="dashboard container">
  <!-- Sidebar -->
  <aside class="col-md-3 nav-sticky dashboard-sidebar">
    <!-- User Info Section -->
    <div class="user-info text-center p-3">
      <img src="{{asset(auth()->user()->image)}}" alt="{{auth()->user()->name}}" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover" />
      <h5 class="mb-0" style="color: #ff6f61"></h5>
    </div>

    <!-- Sidebar Menu -->
    <div class="list-group profile-sidebar-menu">
      <a href="{{route('frontend.dashboard.profile')}}" class="list-group-item list-group-item-action active menu-item" data-section="profile">
        <i class="fas fa-user"></i> Profile
      </a>
      <a href="" class="list-group-item list-group-item-action menu-item" data-section="notifications">
        <i class="fas fa-bell"></i> Notifications
      </a>
      <a href="{{route('frontend.dashboard.setting')}}" class="list-group-item list-group-item-action menu-item" data-section="settings">
        <i class="fas fa-cog"></i> Settings
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="main-content col-md-9">
    <!-- Show/Edit Post Section -->
    <section id="posts-section" class="posts-section">
      <h2>Your Post</h2>
      <ul class="list-unstyled user-posts">
        <!-- Example of a Post Item -->
        <li class="post-item">
          <!-- Editable Title -->
          <input name="title" type="text" class="form-control mb-2 post-title" value="{{$post->title}}" />

          <!-- Editable Content -->
          <textarea name="desc" class="form-control mb-2 post-content">
                {!! $post->desc !!}
            </textarea>

          <!-- Post Images Slider -->
          <div class="tn-slider">
            <div class="slick-slider edit-slider" id="postImages">
              @foreach ($post->images as $image)
              <div class="tn-img">
                <img src="{{asset( $image->path)}}" />
              </div>
              @endforeach
            </div>
          </div>

          <!-- Image Upload Input for Editing -->
          <input name="images[]" type="file" class="form-control mt-2 edit-post-image" accept="image/*" multiple />

          <!-- Editable Category Dropdown -->
          <select class="form-control mb-2 post-category">
            @foreach ($categories as $category)
                <option value="{{$category->id}}" @selected($post->category_id == $category->id)> {{$category->name}} </option>
            @endforeach
          </select>

          <!-- Editable Enable Comments Checkbox -->
          <div class="form-check mb-2">
            <input name="comment_able" class="form-check-input enable-comments" type="checkbox" @checked($post->comment_able) />
            <label class="form-check-label">
              Enable Comments
            </label>
          </div>

          <!-- Post Meta: Views and Comments -->
          <div class="post-meta d-flex justify-content-between">
            <span class="views">
              <i class="bi bi-eye"></i> {{$post->num_of_views}}
            </span>
            <span class="post-comments">
              <i class="fas fa-comment"></i> {{$post->comments->count()}}
            </span>
          </div>

          <!-- Post Actions -->
          <div class="post-actions mt-2">
            <button class="btn btn-primary edit-post-btn">Edit</button>
            <a href="" class="btn btn-danger delete-post-btn">Delete</a>
            <button class="btn btn-success save-post-btn d-none">
              Save
            </button>
            <button class="btn btn-secondary cancel-edit-btn d-none">
              Cancel
            </button>
          </div>

        </li>
        <!-- Additional posts will be added dynamically -->
      </ul>
    </section>
  </div>
</div>

@endsection
