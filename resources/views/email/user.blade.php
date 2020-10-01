@component('mail::message')
# warning , <?php
$name = explode(' ',trim($p->user->name)); 
echo $name[0];
?>

<p>Your ad has been reported as</p>

<h3>{{$r}}</h3>
if we got more reports your ad will be removed form this site

<p></p>

@component('mail::button', ['url' => config('app.url').'/ad/detail/'.$p->id.'/'.$p->slug.''])
Check yout ad
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
