<form enctype="multipart/form-data" action="{{$action}}" method="POST" @if($autocomplete==true)autocomplete="{{$autocomplete}}"@endif @if(isset($style) && $style!='')style="{{$style}}"@endif @if(isset($id) && $id!='')id="{{$id}}"@endif>