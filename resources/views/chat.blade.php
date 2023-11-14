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
  var messageKey = 0;

  formChat.addEventListener('submit', e => {
    e.preventDefault();

    var message = e.target.message.value;
    var messageTemplates = `
    <li class="d-flex mb-3 flex-row-reverse">
        <div class="card w-75 message-green">
            <div class="card-body p-2">
                <p class="mb-0">
                    ${message}
                </p>
            </div>
        </div>
    </li>
    <li class="d-flex mb-3 flex-row">
        <div class="card w-75">
            <div class="card-body p-2" id="chat-answer-${messageKey}">
                <div class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Thinking...</span>
                </div>
            </div>
        </div>
    </li>
    `;

    e.target.message.value = '';
    chatMessages.innerHTML += messageTemplates;

    fetch(formChat.getAttribute('action'), {
      headers: {
        'Content-Type': 'application/json',
      },
      method: formChat.getAttribute('method'),
      body: JSON.stringify({ message }),
    }).then(async res => {
      var reader = res.body.getReader();
      var decoder = new TextDecoder();
      let text = '';
      var chatAnswer = document.getElementById('chat-answer-'+messageKey);

      while (true) {
        var {value, done} = await reader.read();
        if (done) break;
        text += decoder.decode(value, {stream: true});
        chatAnswer.innerHTML = text;
      }

      messageKey++;

      // return res.json();
    })
    // .then(data  => {
    //   var chatAnswer = document.getElementById('chat-answer-'+messageKey);
    //   chatAnswer.innerHTML = data.answer;
    //   messageKey++;
    // });
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
          <button type="submit" class="btn btn-primary btn-rounded float-end">Send</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection