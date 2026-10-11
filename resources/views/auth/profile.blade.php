@extends('layouts.app')

@section('content-app')
<div class="container mt-4">


    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="ps-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="../../assets/img/faces/6.jpg"><a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{$data->email}}</h5>
                                    <p class="main-profile-name-text">{{$data->role}}</p>
                                </div>
                            </div>
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success mg-b-0" role="alert">
                            <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    @endif
                    <form role="form" method="POST" action="">
                        @csrf
                        <div class="form-group">
                            <label for="FullName">Usernmae</label>
                            <input type="text" value="{{$data->username}}" id="FullName" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="text" value="{{$data->email}}" id="Email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            
                            <div class="input-group">
                                <input type="password" name="password" placeholder="Min 6 Characters" id="password" class="form-control">
                                <div class="input-group-text"  id="eye_password">
                                    <div class="input-group-text">
                                        <i class="fas fa-eye-slash tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="RePassword">Password Konfirmasi</label>  
                            <div class="input-group">
                                <input type="password" name="password_confirmation" placeholder="Min 6 Characters" id="rePassword" class="form-control">
                                <div class="input-group-text"  id="eye_rePassword">
                                    <div class="input-group-text">
                                        <i class="fas fa-eye-slash tx-24 lh--9 op-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
</div>
@push('script')
<script>
     $('#eye_password').click(function(){
        var password = $("#password").attr('type');
        if(password == 'text'){
            $("#password").prop('type', 'password');
        }else{
            $("#password").prop('type', 'text');
        }
        $('#eye_password i').toggleClass("fa-eye fa-eye-slash");
    });
    $('#eye_rePassword').click(function(){
        var password = $("#rePassword").attr('type');
        if(password == 'text'){
            $("#rePassword").prop('type', 'password');
        }else{
            $("#rePassword").prop('type', 'text');
        }
        $('#eye_rePassword i').toggleClass("fa-eye fa-eye-slash");
    });
</script>
@endpush
@endsection
