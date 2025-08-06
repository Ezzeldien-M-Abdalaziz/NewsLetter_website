@extends('layouts.frontend.app')

@section('title')
    Notification
@endsection

@section('body')
       <!-- Dashboard Start-->
       <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
          <!-- User Info Section -->
          <div class="user-info text-center p-3">
            <img
              src="{{asset(auth()->user()->image)}}"
              alt="User Image"
              class="rounded-circle mb-2"
              style="width: 80px; height: 80px; object-fit: cover"
            />
            <h5 class="mb-0" style="color: #ff6f61">{{auth()->user()->name}}</h5>
          </div>

          <!-- Sidebar Menu -->
          <div class="list-group profile-sidebar-menu">
            <a
              href="{{route('frontend.dashboard.profile')}}"
              class="list-group-item list-group-item-action menu-item"
              data-section="profile"
            >
              <i class="fas fa-user"></i> Profile
            </a>
            <a
              href="{{route('frontend.dashboard.notification')}}"
              class="list-group-item list-group-item-action active menu-item"
              data-section="notifications"
            >
              <i class="fas fa-bell"></i> Notifications
            </a>
            <a
              href="{{route('frontend.dashboard.setting')}}"
              class="list-group-item list-group-item-action menu-item"
              data-section="settings"
            >
              <i class="fas fa-cog"></i> Settings
            </a>
          </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-6">
                        <form action="{{route('frontend.dashboard.notification.deleteAll')}}" method="POST">
                            @csrf
                            <button style="margin-left: 250px" class="btn btn-sm btn-danger">Delete All</button>
                        </form>
                    </div>
                </div>
                @forelse(auth()->user()->notifications as $notification)
                    <a href="{{$notification->data['link']}}?notification={{$notification->id}}">
                        <div class="notification alert alert-info">
                            <strong>You have a notification from : {{ $notification->data['user_name'] }}</strong> Post title : {{$notification->data['post_title']}}
                            <div class="float-right">
                                <form action="{{route('frontend.dashboard.notification.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$notification->id}}">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="alert-info">
                        No Notification
                    </div>
                @endforelse

            </div>
        </div>
      </div>
      <!-- Dashboard End-->
@endsection
