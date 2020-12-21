@component('mail::message')
# <?php
$name = explode(' ',trim($p->user->name));
echo $name[0];
?>

Your ad
<p>Title : " {{$p->title}} " </p> 
have been removed form this site.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
