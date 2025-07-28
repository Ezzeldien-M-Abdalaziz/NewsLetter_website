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
                        <button class="btn btn-sm btn-danger">Clear All</a>
                    </div>
                </div>
               <a href="">
                <div class="notification alert alert-info">
                    <strong>Info!</strong> This is an informational notification.
                    <div class="float-right">
                        <button style="margin-left: 250px" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
               </a>
               <a href="">
                <div class="notification alert alert-warning">
                    <strong>Warning!</strong> This is a warning notification.
                    <div class="float-right">
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
               </a>
               <a href="">
                <div class="notification alert alert-success">
                    <strong>Success!</strong> This is a success notification.
                    <div class="float-right">
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
               </a>
            </div>
        </div>
      </div>
      <!-- Dashboard End-->
@endsection
