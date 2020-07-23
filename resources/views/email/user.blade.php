@component('mail::message')
# warning , {{$p->user->name}}

Your ad has been reported by customer check your ad again 
if we got more reports your ad will be removed form this site 

<p></p>

@component('mail::button', ['url' => config('app.url').'/ad/detail/'.$p->id.'/'.$p->slug.''])
Check yout ad
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
