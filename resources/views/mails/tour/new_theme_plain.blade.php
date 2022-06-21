
{{__('Hello!')}}
{{__('A new discussion in the tour has been added!')}}


{{__('Tour link')}}:{{ $tour->tour_link }}
{{__('Tour name')}}:{{ $tour->tour_name }}
{{__('Topic link')}}:{{env('APP_URL')}}tours/themes/{{ $tour->theme->id }}
{{__('Topic name')}}:{{ $tour->theme->theme }}

