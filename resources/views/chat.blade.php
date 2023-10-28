@extends('laravai::layout')

@section('style')
<style>
  .message-green {
    background: #dcf8c6;
  }
</style>
@endsection

@section('script')
<script>
  var formChat = document.getElementById('form-chat');
  var chatMessages = document.getElementById('chat-messages');
  formChat.addEventListener('submit', e => {
    e.preventDefault();

    fetch(formChat.getAttribute('action'), {
      headers: {
        "Content-Type": "application/json",
      },
      method: formChat.getAttribute('method'),
      body: JSON.stringify({
        message: e.target.message.value
      }),
    }).then(res => {
      return res.json();
    }).then(data  => {
      e.target.message.value = '';
      chatMessages.innerHTML += data.html;
    });
  });
</script>
@endsection

@section('content')
<section>
  <div class="container py-3">
    <div class="text-center mb-3">
      <a href="{{ $embedding->url }}" target="_blank">
        <h4>{{ $embedding->title }}</h2>
      </a>
    </div>
    <div class="row">
      <div class="col-md-11 mx-auto pt-3 rounded" style="background: #ece5dd">
        <ul class="list-unstyled overflow-scroll" style="height: 380px" id="chat-messages">
        </ul>
        <form method="post" action="/api/chat/{{$embedding->getKey()}}" id="form-chat">
          @csrf
          <div class="mb-3">
            <div class="form-outline">
              <textarea name="message" class="form-control bg-white rounded-pill" rows="2"
                placeholder="Message"></textarea>
            </div>
          </div>
          <button type="sumit" class="btn btn-primary btn-rounded float-end">Send</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection