@extends('_inc.master')
@section('pageContent')
        <div class="container-fluid pb-5">
            <div class="row px-xl-5">
                <div class="col">
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                @if ($errors->has('info'))
                                    <div class="alert alert-info">
                                        {{ $errors->first('info') }}
                                    </div>
                                @endif
                                <div class="text-center"><strong><h2>Hesabını Onayla!</h2></strong></div>
                                <form action="" method="post">
                                   @csrf
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8 text-center">
                                            <p>E posta adresinize gelen onaylama kodunu aşağıdaki alana girip gönderdikten sonra hesabını onaylacakatır.</p>
                                        </div>
                                        <div class="col-lg-2"></div>

                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 form-group">
                                            <label> Onay Kodu: </label>
                                            <input type="text" name="token" required class="form-control" placeholder="Onay Kodu:">
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
