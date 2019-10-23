    <div class="peers ai-c jc-sb pX-40 pY-30">
        <div class="peers peer-greed">
            <div class="peer">
                <small>{{ $email->created_at }}</small>
                <h5 class="c-grey-900 mB-5">{{ $email->name }}</h5>
                @if (isset($email->email))
                    <span>From: {{ $email->email }}</span>
                @endif
            </div>
        </div>
    </div>
    <!-- Content -->
    <div class="bdT pX-40 pY-30">
        <h4>{{ $email->subject }}</h4>
        <h5 class="fsz-def c-grey-900">ФИО: {{ $email->name }}</h5>
        @if (isset($email->phone))
            <h5 class="fsz-def c-grey-900">Телефон: {{ $email->phone }}</h5>
        @endif
        @if (isset($email->email))
            <h5 class="fsz-def c-grey-900">E-mail: {{ $email->email }}</h5>
        @endif
        @if (isset($email->text))
            {{ $email->text }}
        @endif
    </div>
