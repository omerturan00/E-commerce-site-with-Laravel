@extends('_inc.master')
@section('pageContent')


    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            @if ($errors->has('error'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('error') }}
                                </div>
                            @endif
                            <div class="text-center"><strong><h2>Kayıt Ol!</h2></strong></div>
                            <form action="{{route('user.register.post')}}" method="post">
                                @csrf
                                 <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label> Ad: </label>
                                        <input type="text" name="name" class="form-control" required placeholder="Ad">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label> Soyad: </label>
                                        <input type="text" name="surname" class="form-control" required placeholder="Soyad">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Telefon: </label>
                                        <input type="text" name="tel" class="form-control" required placeholder="Telefon">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Email: </label>
                                        <input type="email" name="email" class="form-control" required placeholder="Email">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Şifre: </label>
                                        <input type="password" name="password" required class="form-control" placeholder="Şifre">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Şifre Tekrar: </label>
                                        <input type="password" name="password_retry" required class="form-control" placeholder="Şifre Tekrar">
                                    </div>
                                     <div class="col-lg-12 form-group">
                                         <label> T.C. Kimlik Numarası: </label>
                                         <input type="number" name="identity_number" class="form-control" required minlength="11" maxlength="11">
                                     </div>
                                     <div class="col-lg-12 form-group">
                                         <label> Vergi Dairesi </label>
                                         <input type="text" name="tax_office" class="form-control" required>
                                     </div>
                                     <div class="col-lg-12 form-group">
                                         <label> Vergi Numarası </label>
                                         <input type="number" name="tax_number" class="form-control" required>
                                     </div>
                                    <div class="form-group col-lg-12">
                                        <label> Ülke: </label>
                                        <select name="country" id="country" class="form-control" required>
                                            <option value="">Seçiniz</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->baslik}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label> Şehir: </label>
                                        <select name="city" id="city" class="form-control">
                                            <option value="">Seçiniz</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label> İlçe: </label>
                                        <select name="state" id="state" class="form-control">
                                            <option value="">Seçiniz</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label> Adres: </label>
                                        <textarea name="address" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label> Mahalle: </label>
                                        <input type="text" name="neighborhood" class="form-control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Sokak: </label>
                                        <input type="text" name="street" class="form-control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Posta Kodu: </label>
                                        <input type="text" name="postal_code" class="form-control">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <label> Not: </label>
                                        <textarea name="note" class="form-control" rows="5"></textarea>
                                    </div>
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

@section('pageJs')
    <script>
        $(document).ready(function () {
            // Ülke seçildiğinde şehirleri getir
            $('#country').change(function () {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '/eticaret/get-cities/' + countryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#city').empty().append('<option value="">Seçiniz</option>');
                            $('#state').empty().append('<option value="">Seçiniz</option>');
                            $.each(data, function (key, city) {
                                $('#city').append('<option value="' + city.id + '">' + city.baslik + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city').empty().append('<option value="">Seçiniz</option>');
                    $('#state').empty().append('<option value="">Seçiniz</option>');
                }
            });

            // Şehir seçildiğinde ilçeleri getir
            $('#city').change(function () {
                var cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: '/eticaret/get-states/' + cityId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#state').empty().append('<option value="">Seçiniz</option>');
                            $.each(data, function (key, state) {
                                $('#state').append('<option value="' + state.id + '">' + state.baslik + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty().append('<option value="">Seçiniz</option>');
                }
            });
        });
    </script>
@endsection
