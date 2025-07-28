@extends('layouts.frontend.app')

@section('title')
    Setting
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
            class="list-group-item list-group-item-action menu-item"
            data-section="notifications"
          >
            <i class="fas fa-bell"></i> Notifications
          </a>
          <a
            href="{{route('frontend.dashboard.setting')}}"
            class="list-group-item list-group-item-action active menu-item"
            data-section="settings"
          >
            <i class="fas fa-cog"></i> Settings
          </a>
        </div>
      </aside>

      <!-- Main Content -->
      <div class="main-content" >
        <!-- Settings Section -->
        <section id="settings" class="content-section" style="display:block">
          <h2>Settings</h2>

          @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
          <form action="{{route('frontend.dashboard.setting.update')}}" class="settings-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="name">name:</label>
              <input name="name" type="text" id="name" value="{{auth()->user()->name}}" />
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="username">Username:</label>
              <input name="username" type="text" id="username" value="{{auth()->user()->username}}" />
            </div>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="email">Email:</label>
              <input name="email" type="email" id="email" value="{{auth()->user()->email}}" />
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="profile-image">Profile Image:</label>
              <input name="image" type="file" id="profile-image" accept="image/*" />
            </div>
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="country">Country:</label>
              <input
                type="text"
                name="country"
                id="country"
                value="{{auth()->user()->country}}"
              />
            </div>
            @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="city">City:</label>
              <input name="city" type="text" id="city" value="{{auth()->user()->city}}" />
            </div>
             @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="street">Street:</label>
              <input name="street" type="text" id="street" value="{{auth()->user()->street}}" />
            </div>
             @error('street')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="form-group">
              <label for="phone">phone:</label>
              <input name="phone" type="text" id="phone" value="{{auth()->user()->phone}}" />
            </div>
             @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="submit" class="save-settings-btn">
              Save Changes
            </button>
          </form>

          <!-- Form to change the password -->
          <form action="{{route('frontend.dashboard.setting.changePassword')}}" method="POST" class="change-password-form">
            @csrf
            <h2>Change Password</h2>
            <div class="form-group">
              <label for="current-password">Current Password:</label>
              <input
                type="password"
                name="current_password"
                id="current-password"
                placeholder="Enter Current Password"
              />
            </div>
            <div class="form-group">
              <label for="new-password">New Password:</label>
              <input
                type="password"
                name="password"
                id="new-password"
                placeholder="Enter New Password"
              />
            </div>
            <div class="form-group">
              <label for="confirm-password">Confirm New Password:</label>
              <input
                type="password"
                name="password_confirmation"
                id="confirm-password"
                placeholder="Enter Confirm New "
              />
            </div>
            <button type="submit" class="change-password-btn">
              Change Password
            </button>
          </form>
        </section>
      </div>
    </div>

    <!-- Dashboard End-->
@endsection
