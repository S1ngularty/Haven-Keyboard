@extends('layouts.base')
@extends('layouts.template')
@section('content')
<?php 
// dd($user)

?> 

<title>Profile Update</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #4a90e2;
        --secondary-color: #f4f7f6;
        --text-color: #333;
        --border-radius: 12px;
    }

    .content {
        background-color: var(--secondary-color);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        color: var(--text-color);
        line-height: 1.6;
    }

    .profile-container {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        padding: 40px;
        margin-top: 50px;
        max-width: 800px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--secondary-color);
    }

    .profile-photo-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin-right: 30px;
    }

    .profile-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid var(--primary-color);
    }

    .photo-upload {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: var(--primary-color);
        color: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .form-control, .form-select {
        background-color: var(--secondary-color);
        border: 1px solid #e0e4e7;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(74,144,226,0.25);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3a7bd5;
        transform: translateY(-2px);
    }

    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        width: 400px;
        padding: 30px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-btn:hover {
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-photo-container {
            margin-right: 0;
            margin-bottom: 20px;
        }
    }
</style>
</head>
<div class="content">
    @if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>
                {{$error}}
            </li>
        @endforeach
    </ul>
</div>
@endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 profile-container">
                <form action="{{route('user.update',$account->account_id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="profile-header">
                        <div class="profile-photo-container">
                            <img src="{{asset('storage/'.$user->img)}}"
                                 alt="Profile Photo" 
                                 class="profile-photo">
                            <label for="file-upload" class="photo-upload">
                                <i class="fas fa-camera"></i>
                                <input type="file" id="file-upload" name="img" class="d-none" accept="image/*">
                            </label>
                        </div>
                        <div>
                            <h2>{{$user->fname}} {{$user->lname}}</h2>
                            <p class="text-muted">Update your personal information</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" name="fname" class="form-control" 
                                   value="{{$user->fname}}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" name="lname" class="form-control" 
                                   value="{{$user->lname}}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" 
                                   value="{{$user->age}}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="tel" name="contact" class="form-control" 
                                   value="{{$user->contact}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="male" <?php echo ($user->gender=='male' ? 'selected' : '') ?>>Male</option>
                                <option value="female" <?php echo ($user->gender=='female' ? 'selected' : '') ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" 
                                   value="{{$account->username}}" required>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin" "">Admin</option>
                                <option value="user">User</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div> --}}
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100" type="button" onclick="openPopup()">
                                Change Password
                            </button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col text-center">
                            <input type="submit" name="update" class="btn btn-primary px-5" value="Save Changes">
                        </div>
                    </div>
                    <input type="hidden" name="current_img" value="{{$user->img}}">
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change Popup -->
    <div class="popup-overlay" id="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h3 class="mb-4 text-center">Change Password</h3>
            <form action="{{route('user.update.password',['id'=>$account->account_id])}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="newpass" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="newpass" required>
                </div>
                <div class="mb-4">
                    <label for="cpass" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" name="cpass" required>
                </div>
                <button class="btn btn-primary w-100" name="changepass" onclick="closePopup()">
                    Update Password
                </button
            </form>
        </div>
    </div>

    <script>
        function openPopup() {
            document.getElementById('popup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        // Simple client-side password validation
        document.querySelector('form[name="changepass"]').addEventListener('submit', function(e) {
            const newPass = document.querySelector('input[name="newpass"]').value;
            const confirmPass = document.querySelector('input[name="cpass"]').value;
            
            if (newPass !== confirmPass) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </div>
</document_content>