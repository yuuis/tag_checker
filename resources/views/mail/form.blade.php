@extends('layouts.master')
@section('content')

<section>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    
    @if (\Session::get("status") === "success")
        <div class="alert alert-success">{{ "メールを送信しました" }} </div>
    @endif

    <h1>警告メールを送信する</h1>

    <br>
    <div class="form-group">
    @include('commons.form', ['id' => 'mail_form', 'action' => '/mail/sent', 'autocomplete' => false, 'buttonNo' => Config::get('const.ORIGN_BUTTON_NO_NAME_SENT')])
        <input type="hidden" name="token" value="{{\Session::get('token')}}">
        <div>
            <label>TO : </label>
            <input type="text" name="mailAddress" id="mailAddress" class="form-control" value="@if(isset($results[0])){{$results[0]->mail_address}}@endif">
            @include('commons.error', ['target' => 'mailAddress', 'pairId' => 'mailAddress']) <br></div>

        <div>
            <label>BCC : </label>
            <input type="text" name="mailAddressBcc" id="mailAddressBcc" class="form-control" value="@if(isset($results[0])){{$results[0]->mail_address_bcc}}@endif">
            @include('commons.error', ['target' => 'mailAddressBcc', 'pairId' => 'mailAddressBcc'])  <br></div>

        <div>
            <label>件名 : </label>
            <input type="text" name="mailSubject" id="mailSubject" class="form-control" value="@if(isset($results[0])){{$results[0]->mail_subject}}@endif">
            @include('commons.error', ['target' => 'mailSubject', 'pairId' => 'mailSubject'])  <br></div>

        <div>
            <label>本文 : </label>
            <textarea class="form-control" rows="3" name="mailText" id="mailText">@if(isset($results[0])) {{$results[0]->mail_text}}@endif</textarea> 
            @include('commons.error', ['target' => 'mailText', 'pairId' => 'mailText']) <br></div>

        <button type="submit" class="btn btn-primary">メールを送信する</button>
    </div>
</section>

@endsection