class CalendarHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $day = $('.day');
        var $willAttend = [];
        var $maybeAttend = [];

        $day.on('click', function(e) {
            var $day = $(e.target);
            var $date = $day.find('.date').html();

            if ($day.hasClass('will-not-attend')) {
                $day.removeClass('will-not-attend');
                $day.addClass('will-attend');

                $willAttend.push($date);
            } else if ($day.hasClass('will-attend')) {
                $day.removeClass('will-attend');
                $day.addClass('maybe-attend');

                $willAttend = removeFromArray($date, $willAttend);
                $maybeAttend.push($date);
            } else if ($day.hasClass('maybe-attend')) {
                $day.removeClass('maybe-attend');
                $day.addClass('will-not-attend');

                $maybeAttend = removeFromArray($date, $maybeAttend);
            }

            console.log({
                'will atend': $willAttend,
                'maybe attend': $maybeAttend
            });


            $('#calendar_form_will_attend').val(
                JSON.stringify($willAttend)
            );

            $('#calendar_form_maybe_attend').val(
                JSON.stringify($maybeAttend)
            );
        });

        function removeFromArray($data, $array) {
            return jQuery.grep($array, function($value) {
                return $value != $data;
            });
        }
    }
}

new CalendarHelper();