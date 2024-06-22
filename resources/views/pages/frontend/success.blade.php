@extends('layouts.front')
@section('content-app')

        <!-- step 1 -->
        <section class="steps">
            <h2 class="main-heading">Terimakasih telah mengisi survey</h2>
            <div class="line-break"></div>
            <p class="text-muted">Silahkan tekan tombol dibawah ini untuk kembali ke halaman depan aplikasi ini</p>
            <div >
                   <a href="{{  route('home')}}"> <button type="button" class="btn btn-primary">Kembali</button></a>

            </div>
            <!-- form -->

        </section>

@endsection
