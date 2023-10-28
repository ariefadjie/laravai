@extends('laravai::layout')

@section('style')
<style>
  .message-green {
    background: #dcf8c6;
  }
</style>
@endsection

@section('content')
<section>
  <div class="container py-3">
    <div class="text-center mb-3">
      <a href="https://www.detik.com/sumut/berita/d-6998827/daftar-pasangan-bakal-capres-dan-cawapres-pilpres-2024-siapa-saja"
        target="_blank">
        <h4>Daftar Pasangan Bakal Capres dan Cawapres Pilpres 2024, Siapa Saja?</h2>
      </a>
    </div>
    <div class="row">
      <div class="col-md-11 mx-auto pt-3 rounded" style="background: #ece5dd">
        <ul class="list-unstyled overflow-scroll" style="height: 380px">
          @for ($i = 0; $i < 10 ; $i++)
            <li class="d-flex mb-3 {{ $i % 2 ? 'flex-row' : 'flex-row-reverse' }}">
              <div class="card w-75 {{ $i % 2 ? '' : ' message-green' }}">
                <div class="card-body p-2">
                  <p class="mb-0">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua.
                  </p>
                </div>
              </div>
            </li>
            @endfor
        </ul>
        <div class="mb-3">
          <div class="form-outline">
            <textarea class="form-control bg-white rounded-pill" rows="2" placeholder="Message"></textarea>
          </div>
        </div>
        <button type="button" class="btn btn-primary btn-rounded float-end">Send</button>
      </div>
    </div>
  </div>
</section>
@endsection