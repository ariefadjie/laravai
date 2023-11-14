@extends('laravai::layout')

@section('content')
<div class="px-4 py-5 my-5 text-center">
  <h1 class="display-5 fw-bold text-body-emphasis">LaravAI</h1>
  <div class="col-lg-6 mx-auto">
    <p class="mb-4">
      Dapatkan informasi dari tautan website melalui percakapan chatbot cerdas.
    </p>
    <form method="post" action="{{ route('ariefadjie.laravai.embed.store') }}">
      @csrf
      <div class="input-group">
        <input name="url" required type="url" class="form-control rounded-start border-primary"
          placeholder="masukkan tautan disini" aria-label="Search" aria-describedby="search-addon" />
        <button type="submit" class="btn btn-primary">submit</button>
      </div>
    </form>
  </div>
</div>
@endsection