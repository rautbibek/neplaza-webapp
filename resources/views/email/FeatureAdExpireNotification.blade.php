@component('mail::message')
#Info, <?php
  $name = explode(' ',trim($p->user->name));
  echo $name[0];
  ?>

Your ad is going to expire after tomorrow from feature ad.
<p>
<a href="{{config('app.url').'/ad/detail/'.$p->id.'/'.$p->slug}}">Ad ID :{{$p->productid}}</a>
</p>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
