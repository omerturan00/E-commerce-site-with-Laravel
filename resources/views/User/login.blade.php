@extends('_inc.master')
@section('pageContent')


    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            <div class="text-center"><strong><h2>Giriş Yap!</h2></strong></div>
                            <form action="{{route('user.login.post')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6 form-group">
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required placeholder="Email">
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6 form-group">
                                        <label> Şifre: </label>
                                        <input type="password" name="password" required class="form-control" placeholder="Şifre">
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button class="btn btn-outline-success btn-lg col-lg-12">Gönder</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
