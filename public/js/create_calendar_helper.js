class CalendarHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $day = $('.day');
        var $dates = [];

        $day.on('click', function(e) {
            var $day = $(e.target);
            var $date = $day.find('.date').html();

            if ($day.hasClass('will-not-attend')) {
                $day.removeClass('will-not-attend');
                $day.addClass('will-attend');

                $dates.push($date);
            } else if ($day.hasClass('will-attend')) {
                $day.removeClass('will-attend');
                $day.addClass('will-not-attend');

                $dates = removeFromArray($date, $dates);
            }

            $('#create_calendar_form_dates').val(
                JSON.stringify($dates)
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