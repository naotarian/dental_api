<div>
  <p>----------------------------------------------------</p>
  <p>ご予約が完了しました。</p>
  <p>----------------------------------------------------</p>
</div>
<div>
  <p>{{ $dental_data['dental_name'] }}です。<br>下記日程でご予約を承りましたので、ご連絡いたします。</p>
  <p>ご予約者様お名前: {{ $reserve_detail['last_name'] }}{{ $reserve_detail['first_name'] }}({{ $reserve_detail['last_name_kana'] }}{{ $reserve_detail['first_name_kana'] }})</p>
  <p>ご予約日: {{ $reserve['reserve_date'] }}</p>
  <p>お時間: {{ $reserve['start_time'] }}</p>
</div>