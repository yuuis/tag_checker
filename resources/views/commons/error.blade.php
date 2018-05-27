<div class="text-danger">
@if (isset($errors) && isset($errors[$target]))
@foreach($errors[$target] as $errorsRow)
{{$errorsRow}}
@endforeach
@if ($pairId != '')
<script type="text/javascript">
document.getElementById('{{$pairId}}').classList.add('bg-danger');
</script>
@endif
@endif
</div>